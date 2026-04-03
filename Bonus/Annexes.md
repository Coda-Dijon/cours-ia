<a id="annexes"></a>
# Annexes

<a id="annexe-code"></a>
## Annexe A — Projet FlashCards CLI : code de base

Le code de base est distribué en trois fichiers. Il est volontairement basique — l'outil fonctionne mais ne fait que le strict minimum — pour laisser de la place à l'extension via l'IA.

### Fichier `flashcards.php`

```php
<?php
/**
 * FlashCards CLI — Outil de révision par flashcards
 * Point d'entrée principal
 */

require_once 'functions.php';
require_once 'data.php';

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
```

### Fichier `functions.php`

```php
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
```

### Fichier `data.php`

```php
<?php
/**
 * FlashCards CLI — Données et gestion de la persistance
 */

// Chemin du fichier de sauvegarde
define('DATA_FILE', __DIR__ . '/cards.json');

/**
 * Retourne un jeu de cartes d'exemple pour démarrer
 * Ces cartes portent sur les bases de PHP
 *
 * @return array Liste de tableaux associatifs représentant des cartes
 */
function get_sample_cards(): array
{
    return [
        [
            'question' => 'Quelle fonction affiche du texte dans le terminal en PHP ?',
            'answer' => 'echo (ou print)',
            'deck' => 'PHP Bases',
        ],
        [
            'question' => 'Comment déclare-t-on une variable en PHP ?',
            'answer' => 'Avec le symbole $ suivi du nom : $maVariable = valeur;',
            'deck' => 'PHP Bases',
        ],
        [
            'question' => 'Quelle est la différence entre == et === en PHP ?',
            'answer' => '== compare les valeurs (avec conversion de type), === compare les valeurs ET les types',
            'deck' => 'PHP Bases',
        ],
        [
            'question' => 'Comment parcourir un tableau avec une boucle en PHP ?',
            'answer' => 'foreach ($tableau as $element) { ... } ou foreach ($tableau as $cle => $valeur) { ... }',
            'deck' => 'PHP Bases',
        ],
        [
            'question' => 'Quelle fonction retourne le nombre d\'éléments d\'un tableau ?',
            'answer' => 'count($tableau)',
            'deck' => 'PHP Bases',
        ],
        [
            'question' => 'Que signifie PHP ?',
            'answer' => 'PHP: Hypertext Preprocessor (acronyme récursif)',
            'deck' => 'Culture Dev',
        ],
        [
            'question' => 'Quel mot-clé permet de définir une fonction en PHP ?',
            'answer' => 'function nom_de_la_fonction($params) { ... }',
            'deck' => 'PHP Bases',
        ],
        [
            'question' => 'Comment lire une saisie utilisateur en PHP CLI ?',
            'answer' => 'fgets(STDIN) — retourne la ligne tapée par l\'utilisateur',
            'deck' => 'PHP Bases',
        ],
    ];
}

/**
 * Charge les cartes depuis le fichier JSON
 * Si le fichier n'existe pas, retourne les cartes d'exemple
 *
 * @return array Les cartes sauvegardées (ou les exemples par défaut)
 */
function load_cards(): array
{
    if (!file_exists(DATA_FILE)) {
        return get_sample_cards();
    }

    $json = file_get_contents(DATA_FILE);
    $cards = json_decode($json, true);

    if (!is_array($cards)) {
        return get_sample_cards();
    }

    return $cards;
}

/**
 * Sauvegarde les cartes dans le fichier JSON
 *
 * @param array $cards Les cartes à sauvegarder
 */
function save_cards(array $cards): void
{
    $json = json_encode($cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(DATA_FILE, $json);
}
```

---

<a id="annexe-rules"></a>
## Annexe B — Exemple de fichier rules

Ce fichier est donné en exemple aux étudiants au début du jour 2. Ils s'en inspirent pour créer le leur.

```markdown
# Rules — Projet FlashCards CLI

## Identité du projet
- Outil de révision par flashcards en PHP CLI (façon Anki simplifié)
- Niveau : étudiant 1ère année (pas d'OOP)
- Objectif : apprendre à utiliser l'IA de manière structurée

## Stack technique
- PHP 8.1+ (CLI uniquement, pas de serveur web)
- Aucune dépendance externe
- Pas de Composer, pas de framework
- Persistance des données en JSON (fichier cards.json)

## Architecture
- flashcards.php : point d'entrée, menu et boucle principale
- functions.php : fonctions utilitaires (affichage, saisie, listing)
- data.php : données d'exemple, chargement/sauvegarde JSON
- Tout nouveau fichier doit être documenté ici

## Conventions de code
- Noms de fonctions : snake_case en anglais (ex: get_deck_names)
- Noms de variables : snake_case en anglais (ex: $review_cards)
- Commentaires : en français
- Docblocks obligatoires : @param et @return pour chaque fonction
- Indentation : 4 espaces (pas de tabs)
- Maximum 30 lignes par fonction
- Pas de variable globale ($GLOBALS interdit)

## Structures de données
Les cartes sont des tableaux associatifs :
```
$card = [
    'question' => string,  // Texte de la question
    'answer'   => string,  // Texte de la réponse
    'deck'     => string,  // Nom du paquet
];
```
Le fichier cards.json contient un tableau de cartes au format ci-dessus.

## Règles de développement
- Ne JAMAIS modifier la signature d'une fonction existante sans adapter tous les appels
- Toute modification de la structure d'une carte DOIT être rétro-compatible avec le JSON existant
- Toute nouvelle fonctionnalité = d'abord une spec, puis le code
- Pas de code mort (fonctions inutilisées)
- Chaque fonction doit pouvoir être testée indépendamment
- Les fonctions retournent des valeurs (pas d'effets de bord cachés)
- Toujours vérifier que load_cards() / save_cards() fonctionnent après un changement

## Ce que je ne veux PAS
- Pas de classes, pas d'objets, pas de traits, pas d'interfaces
- Pas de fonctions anonymes complexes
- Pas de require/include dynamique
- Pas de code copié depuis des frameworks
- Pas d'anglicismes dans les commentaires
- Pas de base de données (SQLite, MySQL) — on reste sur du JSON
```

---

<a id="annexe-spec"></a>
## Annexe C — Exemple de spec rédigée avec l'IA

Exemple de spec produite lors d'une session d'échange pour le système de répétition espacée.

```markdown
# Spécification : Système de répétition espacée

## Objectif
Prioriser les cartes mal maîtrisées lors des révisions, en utilisant un système de niveaux de maîtrise inspiré d'Anki. Les cartes bien connues sont revues moins souvent, les cartes difficiles reviennent plus fréquemment.

## Structures de données modifiées

### Carte (ajouts — rétro-compatible avec le format existant)
$card['level']         = int    // Niveau de maîtrise (0-5), par défaut 0
$card['last_reviewed'] = string // Date de dernière révision (format 'Y-m-d'), par défaut null
$card['times_correct'] = int    // Nombre de bonnes réponses, par défaut 0
$card['times_wrong']   = int    // Nombre de mauvaises réponses, par défaut 0

### Règles de progression des niveaux
- Bonne réponse : level + 1 (max 5)
- Mauvaise réponse : level revient à 0
- Réponse moyenne ("moyen") : level reste identique

## Fonctions à implémenter

### `ensure_card_metadata(array $card): array`
- Entrée : une carte (avec ou sans métadonnées)
- Sortie : la carte avec toutes les métadonnées initialisées aux valeurs par défaut si manquantes
- Rôle : assure la rétro-compatibilité avec les anciens fichiers JSON

### `calculate_urgency(array $card): float`
- Entrée : une carte avec ses métadonnées
- Sortie : score d'urgence (plus c'est élevé, plus la révision est urgente)
- Formule : jours_depuis_révision × (6 - level)
- Cas limites : carte jamais révisée (last_reviewed = null) → urgence maximale (999)

### `select_review_cards(array $cards, int $limit = 20): array`
- Entrée : toutes les cartes, nombre max à réviser
- Sortie : les $limit cartes les plus urgentes, triées par urgence décroissante
- Cas limites : moins de cartes que la limite → retourne tout

### `record_answer(array &$cards, int $card_index, string $result): void`
- Entrée : tableau de cartes (par référence), index de la carte, résultat ('bon', 'moyen', 'mauvais')
- Effet : met à jour level, last_reviewed, times_correct/wrong
- Sauvegarde automatiquement dans le JSON

### `display_session_summary(array $results): void`
- Affiche le récap de session : cartes révisées, % bon/moyen/mauvais, cartes montées/descendues de niveau

## Modifications de flashcards.php
- L'option "3. Lancer une révision" utilise maintenant select_review_cards() au lieu de shuffle()
- Après révélation de la réponse, demander à l'utilisateur : "1. Bon  2. Moyen  3. Mauvais"
- Appeler record_answer() après chaque auto-évaluation
- Afficher display_session_summary() à la fin de la session
- Ajouter une option "5. Voir mes statistiques" dans le menu principal

## Ordre d'implémentation
1. ensure_card_metadata (rétro-compatibilité)
2. calculate_urgency (logique pure, testable isolément)
3. record_answer (mise à jour + persistance)
4. select_review_cards (sélection intelligente)
5. display_session_summary (affichage)
6. Intégration dans flashcards.php (menu + boucle de révision)

## Critères de validation
- [ ] Les anciennes cartes (sans métadonnées) fonctionnent toujours
- [ ] Une carte de niveau 0 apparaît avant une carte de niveau 5
- [ ] Une mauvaise réponse remet bien le niveau à 0
- [ ] Le fichier JSON est mis à jour après chaque réponse
- [ ] Le récap de session affiche les bonnes informations
- [ ] Une carte jamais révisée est prioritaire
```

---

<a id="annexe-grille"></a>
## Annexe D — Grille d'évaluation formative

### Évaluation par groupe

| Critère | 0 — Insuffisant | 1 — En cours | 2 — Acquis | 3 — Maîtrisé |
|---------|----------------|--------------|------------|--------------|
| **Code fonctionnel** | Le code ne s'exécute pas | Bugs majeurs qui empêchent d'utiliser l'outil | Quelques bugs mineurs | L'outil fonctionne sans erreur |
| **Cohérence** | Structures incohérentes entre fichiers | Mélange de styles et d'approches | Globalement cohérent avec la base | Parfaitement intégré, on ne distingue pas la base de l'ajout |
| **Compréhension** | Aucun membre ne peut expliquer le code | Explication superficielle ("ça gère le score") | Un membre explique en détail | Tous les membres expliquent n'importe quelle ligne |
| **Qualité des prompts** | Un seul prompt géant | Quelques prompts séparés | Approche itérative avec contexte | Workflow complet : discussion → spec → dev itératif |
| **Rules** | Pas de fichier rules | Rules avec 2-3 lignes vagues | Rules structurées et utiles | Rules complètes + conventions respectées dans le code |
| **Spec** | Pas de spec | Spec informelle / incomplète | Spec structurée avec fonctions listées | Spec complète avec cas limites et critères de validation |
| **Progrès J1 → J2** | Aucune amélioration visible | Légère amélioration | Nette amélioration | Transformation flagrante de la méthode |

### Score total : /21

- 0-7 : les fondamentaux ne sont pas en place
- 8-14 : en bonne voie, la méthode est comprise mais pas encore naturelle
- 15-21 : excellent, la démarche est acquise

---

## Annexe E — Ressources pour aller plus loin

### Outils IA pour le développement

- **Gemini CLI** : outil en ligne de commande de Google pour interagir avec Gemini
- **Claude Code** : outil CLI d'Anthropic, excellent pour le suivi d'instructions
- **GitHub Copilot** : intégré directement dans VS Code / JetBrains
- **Cursor** : éditeur de code avec IA intégrée
- **Aider** : outil CLI open source pour coder avec l'IA

### Principes de prompting

1. **Soyez précis** — "Crée une fonction PHP" vs "Crée une fonction PHP nommée calculate_urgency qui prend un tableau associatif $card et retourne un float"
2. **Donnez du contexte** — le code existant, les conventions, les contraintes
3. **Itérez** — petit à petit, pas tout d'un coup
4. **Vérifiez** — ne faites jamais confiance aveuglément
5. **Spécifiez les anti-patterns** — dites ce que vous ne voulez PAS

### Lectures recommandées

- Documentation officielle de Gemini CLI
- "Prompt Engineering Guide" (dair-ai)
