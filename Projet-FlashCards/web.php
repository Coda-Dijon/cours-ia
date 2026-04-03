<?php
/**
 * FlashCards — Interface Web
 * Version navigateur de l'application de révision par flashcards
 */

require_once __DIR__ . '/data.php';

// --- Traitement des actions POST ---
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cards = load_cards();
    $action = $_POST['action'] ?? '';

    // Ajouter une carte
    if ($action === 'add') {
        $question = trim($_POST['question'] ?? '');
        $answer   = trim($_POST['answer'] ?? '');
        $deck     = trim($_POST['deck'] ?? '');
        $new_deck = trim($_POST['new_deck'] ?? '');

        // Si un nouveau paquet est saisi, il a la priorité
        if (!empty($new_deck)) {
            $deck = $new_deck;
        }

        if (empty($question) || empty($answer)) {
            $message = '❌ La question et la réponse sont obligatoires.';
        } else {
            if (empty($deck)) {
                $deck = 'Sans paquet';
            }
            $cards[] = [
                'question' => $question,
                'answer'   => $answer,
                'deck'     => $deck,
            ];
            save_cards($cards);
            $message = '✅ Carte ajoutée au paquet « ' . htmlspecialchars($deck) . ' » !';
        }
    }

    // Supprimer une carte
    if ($action === 'delete') {
        $index = intval($_POST['index'] ?? -1);
        if (isset($cards[$index])) {
            $removed = $cards[$index];
            array_splice($cards, $index, 1);
            save_cards($cards);
            $message = '🗑️ Carte supprimée : « ' . htmlspecialchars($removed['question']) . ' »';
        }
    }
}

// --- Chargement des données ---
$cards = load_cards();

// Regrouper par paquet
$decks = [];
foreach ($cards as $i => $card) {
    $deck_name = $card['deck'];
    if (!isset($decks[$deck_name])) {
        $decks[$deck_name] = [];
    }
    $card['_index'] = $i; // garder l'index global
    $decks[$deck_name][] = $card;
}

$deck_names = array_keys($decks);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashCards — Révision</title>
    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
        }

        /* ── Layout ── */
        .app { max-width: 900px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* ── Header ── */
        header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        header h1 {
            font-size: 2.2rem;
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.3rem;
        }
        header p { color: #94a3b8; font-size: 0.95rem; }
        .stats {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        .stat {
            background: #1e293b;
            padding: 0.5rem 1.2rem;
            border-radius: 999px;
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .stat strong { color: #38bdf8; }

        /* ── Tabs ── */
        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 0;
        }
        .tab {
            padding: 0.7rem 1.4rem;
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 0.95rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
        }
        .tab:hover { color: #e2e8f0; }
        .tab.active {
            color: #38bdf8;
            border-bottom-color: #38bdf8;
        }
        .panel { display: none; }
        .panel.active { display: block; }

        /* ── Message flash ── */
        .flash {
            background: #1e293b;
            border-left: 4px solid #38bdf8;
            padding: 0.8rem 1.2rem;
            border-radius: 0 8px 8px 0;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        /* ── Cards list ── */
        .deck-group { margin-bottom: 2rem; }
        .deck-title {
            font-size: 1.1rem;
            color: #818cf8;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .deck-title .count {
            background: #312e81;
            color: #a5b4fc;
            font-size: 0.75rem;
            padding: 0.15rem 0.6rem;
            border-radius: 999px;
        }
        .card {
            background: #1e293b;
            border-radius: 12px;
            padding: 1.2rem 1.4rem;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            transition: background 0.2s;
        }
        .card:hover { background: #263148; }
        .card-body { flex: 1; }
        .card-question {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        .card-answer {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        .card-actions form { display: inline; }
        .btn-delete {
            background: transparent;
            border: 1px solid #475569;
            color: #94a3b8;
            padding: 0.3rem 0.7rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
        }
        .btn-delete:hover {
            border-color: #ef4444;
            color: #ef4444;
        }

        /* ── Form ── */
        .form-group { margin-bottom: 1.2rem; }
        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            color: #94a3b8;
            font-size: 0.9rem;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.7rem 1rem;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color 0.2s;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #38bdf8;
        }
        .form-group textarea { resize: vertical; min-height: 80px; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            border: none;
            color: #0f172a;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }

        /* ── Revision ── */
        .review-setup { text-align: center; padding: 2rem 0; }
        .deck-picker {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.6rem;
            margin: 1.5rem 0;
        }
        .deck-btn {
            padding: 0.6rem 1.2rem;
            background: #1e293b;
            border: 1px solid #334155;
            color: #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .deck-btn:hover, .deck-btn.selected {
            border-color: #38bdf8;
            background: #1e3a5f;
        }

        /* ── Flashcard Review ── */
        .review-area { display: none; text-align: center; }
        .review-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .progress-bar {
            flex: 1;
            max-width: 300px;
            height: 6px;
            background: #1e293b;
            border-radius: 999px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #38bdf8, #818cf8);
            border-radius: 999px;
            transition: width 0.4s ease;
        }
        .progress-text { color: #94a3b8; font-size: 0.85rem; white-space: nowrap; }

        .flashcard {
            background: #1e293b;
            border-radius: 16px;
            padding: 3rem 2rem;
            max-width: 600px;
            margin: 0 auto 1.5rem;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .flashcard:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(56, 189, 248, 0.1);
        }
        .flashcard-label {
            position: absolute;
            top: 1rem;
            left: 1.2rem;
            font-size: 0.75rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .flashcard-deck {
            position: absolute;
            top: 1rem;
            right: 1.2rem;
            font-size: 0.75rem;
            color: #818cf8;
            background: #312e81;
            padding: 0.15rem 0.6rem;
            border-radius: 999px;
        }
        .flashcard-text {
            font-size: 1.3rem;
            line-height: 1.6;
        }
        .flashcard.showing-answer {
            border: 1px solid #334155;
        }
        .flashcard.showing-answer .flashcard-text {
            color: #4ade80;
        }
        .hint { color: #64748b; font-size: 0.85rem; margin-bottom: 1.5rem; }

        .review-controls {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
        }
        .btn-review {
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #1e293b;
            color: #e2e8f0;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .btn-review:hover { border-color: #38bdf8; }
        .btn-review.primary {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            border: none;
            color: #0f172a;
            font-weight: 600;
        }

        /* ── Review complete ── */
        .review-complete {
            text-align: center;
            padding: 3rem 0;
            display: none;
        }
        .review-complete h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        .review-complete p { color: #94a3b8; }

        /* ── Empty state ── */
        .empty {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
            .flashcard-text { font-size: 1.1rem; }
            .flashcard { padding: 2rem 1.2rem; }
        }
    </style>
</head>
<body>
<div class="app">

    <!-- Header -->
    <header>
        <h1>FlashCards</h1>
        <p>Révisez efficacement vos connaissances</p>
        <div class="stats">
            <span class="stat"><strong><?= count($cards) ?></strong> cartes</span>
            <span class="stat"><strong><?= count($deck_names) ?></strong> paquets</span>
        </div>
    </header>

    <!-- Flash message -->
    <?php if (!empty($message)): ?>
        <div class="flash"><?= $message ?></div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab active" onclick="switchTab('cards')">Mes cartes</button>
        <button class="tab" onclick="switchTab('add')">Ajouter</button>
        <button class="tab" onclick="switchTab('review')">Réviser</button>
    </div>

    <!-- ═══ Panel : Mes cartes ═══ -->
    <div id="panel-cards" class="panel active">
        <?php if (empty($cards)): ?>
            <div class="empty">
                <p>Aucune carte pour l'instant.<br>Commencez par en ajouter une !</p>
            </div>
        <?php else: ?>
            <?php foreach ($decks as $name => $deck_cards): ?>
                <div class="deck-group">
                    <div class="deck-title">
                        <?= htmlspecialchars($name) ?>
                        <span class="count"><?= count($deck_cards) ?></span>
                    </div>
                    <?php foreach ($deck_cards as $card): ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-question"><?= htmlspecialchars($card['question']) ?></div>
                                <div class="card-answer"><?= htmlspecialchars($card['answer']) ?></div>
                            </div>
                            <div class="card-actions">
                                <form method="post">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="index" value="<?= $card['_index'] ?>">
                                    <button type="submit" class="btn-delete" title="Supprimer">&times;</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ═══ Panel : Ajouter ═══ -->
    <div id="panel-add" class="panel">
        <form method="post">
            <input type="hidden" name="action" value="add">

            <div class="form-group">
                <label for="question">Question</label>
                <textarea id="question" name="question" placeholder="Ex : Que signifie PHP ?" required></textarea>
            </div>

            <div class="form-group">
                <label for="answer">Réponse</label>
                <textarea id="answer" name="answer" placeholder="Ex : PHP: Hypertext Preprocessor" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="deck">Paquet existant</label>
                    <select id="deck" name="deck">
                        <option value="">— Choisir —</option>
                        <?php foreach ($deck_names as $name): ?>
                            <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_deck">Ou nouveau paquet</label>
                    <input type="text" id="new_deck" name="new_deck" placeholder="Nom du paquet">
                </div>
            </div>

            <button type="submit" class="btn-primary">Ajouter la carte</button>
        </form>
    </div>

    <!-- ═══ Panel : Réviser ═══ -->
    <div id="panel-review" class="panel">

        <!-- Choix du paquet -->
        <div class="review-setup" id="review-setup">
            <h2>Choisissez un paquet</h2>
            <div class="deck-picker">
                <button class="deck-btn selected" onclick="selectDeck(this, 'all')">
                    Toutes (<?= count($cards) ?>)
                </button>
                <?php foreach ($decks as $name => $dc): ?>
                    <button class="deck-btn" onclick="selectDeck(this, '<?= htmlspecialchars($name, ENT_QUOTES) ?>')">
                        <?= htmlspecialchars($name) ?> (<?= count($dc) ?>)
                    </button>
                <?php endforeach; ?>
            </div>
            <button class="btn-primary" onclick="startReview()">Lancer la révision</button>
        </div>

        <!-- Zone de révision -->
        <div class="review-area" id="review-area">
            <div class="review-progress">
                <span class="progress-text" id="progress-text">1 / <?= count($cards) ?></span>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
                </div>
            </div>

            <div class="flashcard" id="flashcard" onclick="flipCard()">
                <span class="flashcard-label" id="flashcard-label">Question</span>
                <span class="flashcard-deck" id="flashcard-deck"></span>
                <div class="flashcard-text" id="flashcard-text"></div>
            </div>
            <p class="hint" id="hint">Cliquez sur la carte pour voir la réponse</p>

            <div class="review-controls">
                <button class="btn-review" onclick="restartReview()">Recommencer</button>
                <button class="btn-review primary" id="btn-next" onclick="nextCard()">Suivante</button>
            </div>
        </div>

        <!-- Fin de révision -->
        <div class="review-complete" id="review-complete">
            <h2>Bravo !</h2>
            <p id="complete-text"></p>
            <br>
            <button class="btn-primary" onclick="restartReview()">Recommencer</button>
        </div>
    </div>

</div>

<script>
// ── Données JSON injectées depuis PHP ──
const allCards = <?= json_encode($cards, JSON_UNESCAPED_UNICODE) ?>;

// ── Tabs ──
function switchTab(name) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.getElementById('panel-' + name).classList.add('active');
}

// ── Review state ──
let selectedDeck = 'all';
let reviewCards = [];
let currentIndex = 0;
let showingAnswer = false;

function selectDeck(btn, deck) {
    document.querySelectorAll('.deck-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    selectedDeck = deck;
}

function shuffle(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
}

function startReview() {
    if (selectedDeck === 'all') {
        reviewCards = [...allCards];
    } else {
        reviewCards = allCards.filter(c => c.deck === selectedDeck);
    }
    if (reviewCards.length === 0) return;

    shuffle(reviewCards);
    currentIndex = 0;
    showingAnswer = false;

    document.getElementById('review-setup').style.display = 'none';
    document.getElementById('review-complete').style.display = 'none';
    document.getElementById('review-area').style.display = 'block';

    renderCard();
}

function renderCard() {
    const card = reviewCards[currentIndex];
    const fc = document.getElementById('flashcard');
    const total = reviewCards.length;

    document.getElementById('flashcard-text').textContent = card.question;
    document.getElementById('flashcard-label').textContent = 'Question';
    document.getElementById('flashcard-deck').textContent = card.deck;
    document.getElementById('progress-text').textContent = (currentIndex + 1) + ' / ' + total;
    document.getElementById('progress-fill').style.width = ((currentIndex + 1) / total * 100) + '%';
    document.getElementById('hint').textContent = 'Cliquez sur la carte pour voir la réponse';
    document.getElementById('btn-next').textContent = currentIndex < total - 1 ? 'Suivante' : 'Terminer';

    fc.classList.remove('showing-answer');
    showingAnswer = false;
}

function flipCard() {
    const card = reviewCards[currentIndex];
    const fc = document.getElementById('flashcard');

    if (!showingAnswer) {
        fc.classList.add('showing-answer');
        document.getElementById('flashcard-text').textContent = card.answer;
        document.getElementById('flashcard-label').textContent = 'Réponse';
        document.getElementById('hint').textContent = '';
        showingAnswer = true;
    } else {
        fc.classList.remove('showing-answer');
        document.getElementById('flashcard-text').textContent = card.question;
        document.getElementById('flashcard-label').textContent = 'Question';
        document.getElementById('hint').textContent = 'Cliquez sur la carte pour voir la réponse';
        showingAnswer = false;
    }
}

function nextCard() {
    currentIndex++;
    if (currentIndex >= reviewCards.length) {
        document.getElementById('review-area').style.display = 'none';
        document.getElementById('review-complete').style.display = 'block';
        document.getElementById('complete-text').textContent =
            'Vous avez révisé ' + reviewCards.length + ' cartes. Continuez comme ça !';
        return;
    }
    showingAnswer = false;
    renderCard();
}

function restartReview() {
    document.getElementById('review-area').style.display = 'none';
    document.getElementById('review-complete').style.display = 'none';
    document.getElementById('review-setup').style.display = 'block';
}
</script>
</body>
</html>
