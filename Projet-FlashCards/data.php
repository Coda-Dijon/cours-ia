<?php
/**
 * FlashCards CLI — Données et gestion de la persistance
 */

// Chemin du fichier de sauvegarde
// En mode web (Apache), le volume Docker monté n'est pas accessible en écriture.
// On utilise /tmp pour la persistance côté serveur.
if (php_sapi_name() === 'cli') {
    define('DATA_FILE', __DIR__ . '/cards.json');
} else {
    define('DATA_FILE', '/tmp/flashcards_data.json');
}

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
