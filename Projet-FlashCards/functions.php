<?php
/**
 * FlashCards CLI — Fonctions utilitaires
 */

/**
 * Efface l'écran du terminal
 */
function clear_screen(): void
{
    echo "\033[2J\033[H";
}

/**
 * Affiche le titre de l'application
 */
function display_title(): void
{
    echo "╔══════════════════════════════════════╗\n";
    echo "║        📚  FLASHCARDS CLI  📚        ║\n";
    echo "║       Révisez efficacement           ║\n";
    echo "╚══════════════════════════════════════╝\n\n";
}

/**
 * Lit une saisie utilisateur depuis le terminal
 *
 * @param string $prompt Le texte affiché avant la saisie
 * @return string La saisie de l'utilisateur (nettoyée)
 */
function get_user_input(string $prompt): string
{
    echo $prompt;
    $input = trim(fgets(STDIN));
    return $input;
}

/**
 * Met le programme en pause jusqu'à ce que l'utilisateur appuie sur Entrée
 */
function pause(): void
{
    get_user_input("\nAppuyez sur Entrée pour continuer...");
}

/**
 * Affiche une carte (question seulement, ou question + réponse)
 *
 * @param array $card La carte à afficher
 * @param bool $show_answer Afficher la réponse ou non
 */
function display_card(array $card, bool $show_answer = false): void
{
    echo "┌──────────────────────────────────────┐\n";
    echo "  📂 " . $card['deck'] . "\n";
    echo "├──────────────────────────────────────┤\n";
    echo "  ❓ " . $card['question'] . "\n";

    if ($show_answer) {
        echo "├──────────────────────────────────────┤\n";
        echo "  ✅ " . $card['answer'] . "\n";
    }

    echo "└──────────────────────────────────────┘\n";
}

/**
 * Affiche la liste de toutes les cartes, regroupées par paquet
 *
 * @param array $cards Liste de toutes les cartes
 */
function display_all_cards(array $cards): void
{
    if (empty($cards)) {
        echo "Aucune carte enregistrée.\n";
        return;
    }

    // Regrouper par paquet
    $decks = [];
    foreach ($cards as $card) {
        $deck_name = $card['deck'];
        if (!isset($decks[$deck_name])) {
            $decks[$deck_name] = [];
        }
        $decks[$deck_name][] = $card;
    }

    // Afficher
    foreach ($decks as $deck_name => $deck_cards) {
        echo "\n📂 $deck_name (" . count($deck_cards) . " cartes)\n";
        echo str_repeat('─', 40) . "\n";

        foreach ($deck_cards as $index => $card) {
            echo "  " . ($index + 1) . ". " . $card['question'] . "\n";
        }
    }
}

/**
 * Retourne la liste des noms de paquets disponibles
 *
 * @param array $cards Liste de toutes les cartes
 * @return array Liste des noms de paquets (sans doublons)
 */
function get_deck_names(array $cards): array
{
    $decks = [];
    foreach ($cards as $card) {
        if (!in_array($card['deck'], $decks)) {
            $decks[] = $card['deck'];
        }
    }
    return $decks;
}
