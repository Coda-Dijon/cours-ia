# Plan détaillé du cours

---

### JOUR 1 — Comprendre l'IA et se confronter à ses limites

#### Matin (9h30 – 12h)

**9h30 – 10h00 · Introduction**
- Présentation intervenant (parcours, rapport à l'IA au quotidien)
- Tour de table : prénom, usage actuel de l'IA, un mot sur leur ressenti
- Cadrage : on code, on se trompe, on analyse — pas de bonne réponse unique

**10h00 – 10h45 · Comment fonctionne un LLM**
- L'IA au quotidien : exemples connus (Netflix, FaceID, GPS…) → l'IA est devenue conversationnelle
- Grandes familles d'IA : ML classique, vision, génératif, robotique, LLM
- Paysage mondial des LLM : acteurs US / Europe / Chine, open source vs fermé
- Prédiction statistique : analogie intuitive, démo live, sampling et température
- Entraînement : pré-entraînement → fine-tuning → RLHF, date de coupure, biais des données
- Tokens : démo tokenizer, coût du français, fenêtre de contexte
- Embeddings, attention, génération auto-régressive — rien de magique, que des stats

*Pause 10h15 – 10h30*

**10h30 – 10h45 · Prise en main de Gemini CLI**
- Installation et vérification sur chaque poste
- Premier prompt, premier réflexe critique

**11h00 – 12h · Exercice 1 — Le run "naïf"**
- Groupes de 3-4, code de base FlashCards distribué
- Consigne volontairement vague, aucune méthode donnée
- L'intervenant observe sans aider, note les patterns d'échec

*Pause déjeuner 12h – 13h30*

#### Après-midi (13h30 – 17h)

**13h30 – 14h15 · Analyse collective des résultats**
- Présentations par groupe + identification des patterns typiques (code trop sophistiqué, hallucination silencieuse, perte de cohérence, code verbeux)
- Questions larges aux étudiants pour faire émerger leurs observations
- Techniques concrètes de relecture : lecture à voix haute, checklist signaux d'alerte, test mental des edge cases

**14h15 – 14h45 · Limites et enjeux éthiques**
- Hallucinations : mécanisme, exemples dev, exercices live (strawberry, fonction fictive)
- Biais : techniques (popularité, tutoriel, anglophone), confirmation (yes-man), sociétaux
- Éthique : propriété intellectuelle, confidentialité (cas Samsung), impact environnemental
- Démo : injection SQL générée par l'IA → correction
- Confiance mal calibrée : l'IA ne dit jamais "je ne sais pas"

*Pause 14h45 – 15h00*

**15h00 – 15h20 · Quand ne PAS utiliser l'IA**
- Matrice de décision (compréhension × type de tâche)
- 5 cas où l'IA nuit : apprentissage fondamental, compréhension d'un bug, code critique, problème flou, micro-tâche
- Discussion ouverte

**15h20 – 15h50 · Le métier qui change**
- Retour d'expérience freelance : ce qui a changé, ce qui n'a pas changé
- Le piège de la productivité apparente
- Discussion : peur vs motivation, remplacement vs augmentation

**15h50 – 17h · La notion de contexte + Débrief Jour 1** *(reportés au début du Jour 2)*

> Ces deux séquences sont désormais positionnées en ouverture du Jour 2 (9h30 – 10h30), de manière à enchaîner immédiatement avec les outils méthodologiques (prompts itératifs, spec, rules, agents). Le détail figure dans la section Jour 2 ci-dessous.

---

### JOUR 2 — Structurer, itérer et maîtriser

> **Note d'organisation** : la matinée du Jour 2 s'ouvre désormais sur un débrief du Jour 1 et la notion de contexte (concept pivot). Pour absorber ces 60 min sans toucher aux horaires de cours, "Du LLM à l'agent" et la "Préparation de l'exercice 2" ont été déplacés en début d'après-midi, l'atelier Symfony est compressé à 30 min (Phase 1 uniquement), et le temps libre encadré "Appliquer la méthodologie" est supprimé.

#### Matin (9h30 – 12h)

**9h30 – 9h50 · Débrief du jour 1**
- Récap guidé des grands moments de la veille (matin LLM, exercice 1 naïf, après-midi limites & éthique)
- Réénonciation des 4 grands messages du Jour 1
- Tour de table express (~30 s par étudiant) : surprise / inquiétude / intention pour aujourd'hui
- Cadrage du Jour 2 pivotant sur le concept de **contexte**

**9h50 – 10h30 · La notion de contexte**
- Pourquoi le contexte est la clé (lien direct avec le chaos vécu hier)
- Rappel du mécanisme LLM : sans contexte, l'IA "moyenne" sur ses données d'entraînement
- Démo side-by-side : même prompt sans / avec contexte (live dans Gemini CLI)
- Les 5 composants d'un bon contexte (qui je suis, ce qui existe, ce que je veux, ce que je ne veux pas, format attendu)
- **Mini-exercice comparatif (15 min)** : chaque binôme reprend un prompt d'hier, le réécrit en deux versions (A sans / B avec contexte), lance les deux dans Gemini CLI, compare. Mise en commun orale.

*Pause 10h30 – 10h45*

**10h45 – 11h15 · Le prompt itératif vs le one-shot**
- Pourquoi le one-shot échoue (on oublie toujours des informations), l'approche itérative en 4 étapes
- Bien signaler un bug : le triptyque attendu / observé / message d'erreur

**11h15 – 11h45 · Spécifier avant de développer**
- Le workflow en 3 phases : spec métier → plan d'implémentation → implémentation par phases avec tests
- Deux contextes séparés (exploration vs dev)
- Démo live du workflow complet
- Templates : spec métier + plan d'implémentation

**11h45 – 12h00 · Sessions d'échange avec l'IA**
- Modèle mental : l'IA = dev intermédiaire, vous = lead technique
- Techniques : "pose-moi des questions", canard en plastique amélioré, prompt défensif

*Pause déjeuner 12h – 13h30*

#### Après-midi (13h30 – 17h)

**13h30 – 14h15 · Du LLM à l'agent — rules, outils, orchestration** *(déplacé du matin)*
- **13h30 – 13h40 · LLM basique vs agent** — les briques (tool use, mémoire, boucle observer/décider/agir). Question : "Gemini CLI hier, c'était encore un chatbot ?"
- **13h40 – 13h55 · Rules = la mémoire long-terme de l'agent** — fichiers de rules, exemple FlashCards, GEMINI.md hiérarchique, skills, panorama des agents (Gemini CLI, Claude Code, Cursor, Copilot)
- **13h55 – 14h10 · Orchestration multi-agents** — patterns (orchestrateur/workers, sub-agents, hand-offs, parallélisation), [claude.com/blog/multi-agent-coordination-patterns](https://claude.com/blog/multi-agent-coordination-patterns), limites (coût, debug, fiabilité)
- **14h10 – 14h15 · Transition** — "vous n'allez plus parler à un chatbot, vous allez configurer un agent"

**14h15 – 14h30 · Préparation de l'exercice 2** *(déplacée du matin)*
- Création du fichier de rules + exploration du repo Anthropic Skills pour s'inspirer de rules existantes
- Session d'échange, rédaction de la spec
- Pas de code — préparation pure
- Choix d'une fonctionnalité par groupe (répétition espacée, stats, import/export, chrono, QCM)

**14h30 – 15h30 · Exercice 2 — Le run "structuré"**
- Même projet, avec rules + spec + itératif
- Critères : code fonctionnel, cohérent avec l'existant, compris par tous, prompts structurés, spec respectée
- L'intervenant circule et intervient cette fois

*Pause 15h30 – 15h45*

**15h45 – 16h15 · Ton workflow réel**
- Démo projet client anonymisé : rules réelles, session de spec, prompt de dev
- 3 exemples d'automatisation quotidienne : CRUD, revue de code, génération de tests
- Les tests comme garde-fou : pourquoi l'IA rend les tests plus nécessaires (pas moins)
- L'analogie du parachute

**16h15 – 16h45 · Atelier — Explorer le framework Symfony avec l'IA** *(format compressé)*
- Mise en place (3 min) : repo Symfony cloné en amont
- Phase 1 (22 min) : comprendre la codebase — cycle d'une requête HTTP
- Mise en commun (5 min) : tour rapide, l'intervenant relie les morceaux
- *Phase 2 (analyse technique approfondie) déplacée en ressource d'autoformation*

**16h45 – 17h · Débrief final**
- La règle : "Jamais une ligne de code que tu ne peux pas expliquer"
- Reprise des mots du tour de table — évolution des perceptions
- Ce qu'ils repartent avec : rules, template de spec, expérience du contraste, regard critique, réflexe d'exploration
