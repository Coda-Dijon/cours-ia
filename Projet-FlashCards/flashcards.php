<?php
/**
 * FlashCards CLI — Outil de révision par flashcards
 * Point d'entrée principal
 */

require_once 'functions.php';
require_once 'data.php';

// Ce script nécessite un terminal interactif (mode CLI)
if (php_sapi_name() !== 'cli') {
    echo "<h1>⚠️ Ce script doit être exécuté en ligne de commande</h1>";
    echo "<p>Ouvrez un terminal et lancez :</p>";
    echo "<pre>docker exec -it php-cours-ia php /var/www/projet/flashcards.php</pre>";
    exit(0);
}

// --- Initialisation ---
$cards = load_cards();

clear_screen();
display_title();
echo "Bienvenue ! Vous avez " . count($cards) . " cartes dans votre collection.\n";

// --- Boucle principale ---
$running = true;

while ($running) {
    echo "\n── Menu principal ──\n";
    echo "1. Ajouter une carte\n";
    echo "2. Voir toutes les cartes\n";
    echo "3. Lancer une révision\n";
    echo "4. Quitter\n";

    $choice = get_user_input("\nVotre choix : ");

    switch ($choice) {

        // --- Ajouter une carte ---
        case '1':
            clear_screen();
            echo "== Nouvelle carte ==\n\n";

            $question = get_user_input("Question : ");
            if (empty($question)) {
                echo "La question ne peut pas être vide.\n";
                break;
            }

            $answer = get_user_input("Réponse : ");
            if (empty($answer)) {
                echo "La réponse ne peut pas être vide.\n";
                break;
            }

            // Proposer les paquets existants ou en créer un nouveau
            $decks = get_deck_names($cards);

            if (!empty($decks)) {
                echo "\nPaquets existants :\n";
                foreach ($decks as $i => $deck) {
                    echo "  " . ($i + 1) . ". $deck\n";
                }
                echo "  " . (count($decks) + 1) . ". Créer un nouveau paquet\n";

                $deck_choice = get_user_input("\nChoisir un paquet : ");
                $deck_index = intval($deck_choice) - 1;

                if ($deck_index >= 0 && $deck_index < count($decks)) {
                    $deck_name = $decks[$deck_index];
                } else {
                    $deck_name = get_user_input("Nom du nouveau paquet : ");
                }
            } else {
                $deck_name = get_user_input("Nom du paquet : ");
            }

            if (empty($deck_name)) {
                $deck_name = "Sans paquet";
            }

            $new_card = [
                'question' => $question,
                'answer' => $answer,
                'deck' => $deck_name,
            ];

            $cards[] = $new_card;
            save_cards($cards);

            echo "\n✅ Carte ajoutée au paquet \"$deck_name\" !\n";
            break;

        // --- Voir toutes les cartes ---
        case '2':
            clear_screen();
            echo "== Toutes vos cartes ==\n";
            display_all_cards($cards);
            pause();
            break;

        // --- Lancer une révision ---
        case '3':
            clear_screen();

            if (empty($cards)) {
                echo "Aucune carte à réviser. Ajoutez-en d'abord !\n";
                break;
            }

            // Choisir un paquet ou tout réviser
            $decks = get_deck_names($cards);

            echo "== Lancer une révision ==\n\n";
            echo "1. Toutes les cartes (" . count($cards) . ")\n";
            foreach ($decks as $i => $deck) {
                $deck_count = count(array_filter($cards, function($c) use ($deck) {
                    return $c['deck'] === $deck;
                }));
                echo ($i + 2) . ". $deck ($deck_count cartes)\n";
            }

            $review_choice = get_user_input("\nVotre choix : ");
            $review_index = intval($review_choice);

            // Filtrer les cartes selon le choix
            if ($review_index === 1) {
                $review_cards = $cards;
            } elseif ($review_index >= 2 && $review_index <= count($decks) + 1) {
                $selected_deck = $decks[$review_index - 2];
                $review_cards = array_filter($cards, function($c) use ($selected_deck) {
                    return $c['deck'] === $selected_deck;
                });
                $review_cards = array_values($review_cards);
            } else {
                echo "Choix invalide.\n";
                break;
            }

            // Mélanger les cartes
            shuffle($review_cards);

            // Session de révision
            $total = count($review_cards);
            $current = 0;

            echo "\n🎯 Révision de $total cartes. C'est parti !\n\n";

            foreach ($review_cards as $card) {
                $current++;
                echo "── Carte $current / $total ──\n\n";

                // Afficher la question
                display_card($card, false);

                get_user_input("\n(Appuyez sur Entrée pour voir la réponse)");

                // Afficher la réponse
                clear_screen();
                echo "── Carte $current / $total ──\n\n";
                display_card($card, true);

                echo "\n";
                pause();

                if ($current < $total) {
                    clear_screen();
                }
            }

            echo "\n🎉 Révision terminée ! $total cartes révisées.\n";
            pause();
            break;

        // --- Quitter ---
        case '4':
            $running = false;
            echo "\nÀ bientôt ! Continuez à réviser 📚\n";
            break;

        default:
            echo "\nChoix invalide. Essayez à nouveau.\n";
            break;
    }
}
