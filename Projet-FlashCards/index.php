<?php
/**
 * Point d'entrée web du projet FlashCards.
 *
 * Ce fichier permet de vérifier que le serveur PHP fonctionne
 * et donne accès aux différents scripts du projet.
 */

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashCards - Projet PHP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            color: #1a1a2e;
            padding: 2rem;
        }
        .container { max-width: 800px; margin: 0 auto; }
        h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            color: #666;
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .card h2 { font-size: 1.2rem; margin-bottom: 0.5rem; }
        .card p { color: #555; line-height: 1.5; }
        .info {
            display: inline-block;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        .files { margin-top: 1rem; }
        .files a {
            display: inline-block;
            margin-right: 1rem;
            color: #1565c0;
            text-decoration: none;
        }
        .files a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>FlashCards</h1>
        <p class="subtitle">Projet PHP — Formation IA &amp; Développement</p>

        <div class="card">
            <h2>Statut du serveur</h2>
            <p><span class="info">PHP <?= phpversion() ?> — Serveur actif</span></p>
        </div>

        <div class="card">
            <h2>Application FlashCards</h2>
            <p>
                <a href="web.php" style="display:inline-block;background:linear-gradient(135deg,#38bdf8,#818cf8);color:#fff;padding:0.5rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;">
                    Ouvrir l'interface web
                </a>
            </p>
            <p style="margin-top:0.8rem;color:#888;font-size:0.85rem;">
                Version CLI : <code>docker exec -it php-cours-ia php /var/www/projet/flashcards.php</code>
            </p>
        </div>

        <div class="card">
            <h2>Fichiers du projet</h2>
            <p>Voici les fichiers PHP disponibles dans ce projet :</p>
            <div class="files">
                <?php
                $files = glob(__DIR__ . '/*.php');
                foreach ($files as $file) {
                    $name = basename($file);
                    echo "<a href=\"$name\">$name</a>\n";
                }
                ?>
            </div>
        </div>

        <div class="card">
            <h2>phpinfo()</h2>
            <p>Pour voir la configuration complète de PHP : <a href="phpinfo.php">phpinfo.php</a></p>
        </div>
    </div>
</body>
</html>
