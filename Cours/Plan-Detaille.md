# Plan détaillé du cours

---

### JOUR 1 — Comprendre l'IA et se confronter à ses limites

#### Matin (9h – 12h)

**9h – 9h30 · Introduction**
- Présentation intervenant (parcours, rapport à l'IA au quotidien)
- Tour de table : prénom, usage actuel de l'IA, un mot sur leur ressenti
- Cadrage : on code, on se trompe, on analyse — pas de bonne réponse unique

**9h30 – 10h15 · Comment fonctionne un LLM**
- L'IA au quotidien : exemples connus (Netflix, FaceID, GPS…) → l'IA est devenue conversationnelle
- Grandes familles d'IA : ML classique, vision, génératif, robotique, LLM
- Paysage mondial des LLM : acteurs US / Europe / Chine, open source vs fermé
- Prédiction statistique : analogie intuitive, démo live (deux réponses différentes au même prompt), sampling et température
- Entraînement : pré-entraînement → fine-tuning → RLHF, date de coupure, biais des données
- Tokens : démo tokenizer, coût du français, fenêtre de contexte et ses implications
- Embeddings : mots comme points dans un espace, arithmétique du sens, lien avec la précision du prompt
- Démystification : stockage concret des vecteurs (tableaux de float), multiplication de matrices, rien de magique — uniquement de la statistique
- Attention : relier des éléments éloignés, portée limitée
- Génération auto-régressive : token par token, une erreur précoce fait dériver la suite

**10h30 – 10h45 · Prise en main de Gemini CLI**
- Installation et vérification sur chaque poste
- Premier prompt, premier réflexe critique

**10h45 – 12h · Exercice 1 — Le run "naïf"**
- Groupes de 3-4, code de base FlashCards distribué
- Consigne volontairement vague, aucune méthode donnée
- L'intervenant observe sans aider, note les patterns d'échec

#### Après-midi (13h – 16h)

**13h – 13h45 · Analyse collective des résultats**
- Présentations par groupe + décorticage en live des 4 patterns : code trop sophistiqué, hallucination silencieuse, perte de cohérence, code verbeux
- Techniques concrètes de relecture : lecture à voix haute, checklist signaux d'alerte, test mental des edge cases, diff avec l'existant

**13h45 – 14h15 · Limites et enjeux éthiques**
- Hallucinations : mécanisme, exemples dev, exercices live (strawberry, fonction fictive)
- Biais : techniques (popularité, tutoriel, anglophone), confirmation (yes-man), sociétaux
- Éthique : propriété intellectuelle, confidentialité (cas Samsung), impact environnemental, responsabilité du développeur
- Démo : injection SQL générée par l'IA → correction
- Confiance mal calibrée : l'IA ne dit jamais "je ne sais pas"

**14h30 – 14h50 · Quand ne PAS utiliser l'IA**
- Matrice de décision (compréhension × type de tâche)
- 5 cas où l'IA nuit : apprentissage fondamental, compréhension d'un bug, code critique, problème flou, micro-tâche
- Discussion ouverte

**14h50 – 15h20 · Le métier qui change**
- Retour d'expérience freelance : ce qui a changé, ce qui n'a pas changé
- Le piège de la productivité apparente
- Discussion : peur vs motivation, remplacement vs augmentation

**15h20 – 15h50 · La notion de contexte**
- Pourquoi le contexte est la clé (lien avec le chaos du matin)
- Démo side-by-side : même prompt sans et avec contexte
- Les 5 composantes d'un bon contexte
- Exercice express : réécriture d'un prompt du matin

**15h50 – 16h · Débrief Jour 1**
- Bilan + teaser Jour 2

---

### JOUR 2 — Structurer, itérer et maîtriser

#### Matin (9h – 12h)

**9h – 9h30 · Le prompt itératif vs le one-shot**
- Pourquoi le one-shot échoue, l'approche itérative en 4 étapes
- Démo live sur le projet flashcards
- Bien signaler un bug : le triptyque attendu / observé / message d'erreur

**9h30 – 10h · Spécifier avant de développer**
- Le workflow en 3 phases : spec métier → plan d'implémentation → implémentation par phases avec tests
- Deux contextes séparés (exploration vs dev)
- Démo live du workflow complet
- Templates : spec métier + plan d'implémentation

**10h15 – 10h45 · Sessions d'échange avec l'IA**
- Modèle mental : l'IA = dev intermédiaire, vous = lead technique
- Techniques : "pose-moi des questions", canard en plastique amélioré, prompt défensif (critiquer son propre code)
- Démo live : d'un besoin flou à une architecture claire, sans écrire une ligne de code

**10h45 – 11h15 · Rules, outils et agents**
- Fichiers de rules : concept, exemple FlashCards, GEMINI.md hiérarchique, équivalents (CLAUDE.md, .cursor/rules…)
- Panorama des agents : Gemini CLI, Claude Code, Cursor, Copilot et autres
- Fonctionnalités Gemini CLI : commandes slash, outils intégrés, sandbox, MCP
- Agents et orchestration : agent simple (mode agentic), sub-agents, multi-agents — le rôle du dev se déplace vers la spécification et la vérification

**11h15 – 11h45 · Workflow réel + tests comme garde-fou**
- Démo projet client anonymisé : rules réelles, session de spec, prompt de dev
- 3 exemples d'automatisation quotidienne : CRUD, revue de code, génération de tests
- Tests comme garde-fou : pourquoi l'IA rend les tests plus nécessaires (pas moins), le réflexe de tester chaque fonction générée

**11h45 – 12h · Préparation de l'exercice 2**
- Création du fichier de rules + exploration du repo Anthropic Skills pour s'inspirer de rules existantes
- Session d'échange, rédaction de la spec
- Pas de code — préparation pure
- Choix d'une fonctionnalité par groupe (répétition espacée, stats, import/export, chrono, QCM)

#### Après-midi (13h – 16h)

**13h – 14h15 · Exercice 2 — Le run "structuré"**
- Même projet, avec rules + spec + itératif
- Critères : code fonctionnel, cohérent avec l'existant, compris par tous, prompts structurés, spec respectée
- L'intervenant circule et intervient cette fois

**14h30 – 15h30 · Atelier — Explorer le framework Symfony avec l'IA**
- Phase 1 (25 min) : comprendre la codebase — chaque groupe explore un composant (HttpKernel, Routing, DI, Security, Console, EventDispatcher), cartographie l'architecture, trace le parcours d'une requête
- Phase 2 (25 min) : analyse technique — design patterns, extensibilité, découplage, tests, conventions
- Mise en commun (5 min) : chaque groupe présente, l'intervenant relie les morceaux

**15h30 – 15h50 · Temps libre encadré**
- Appliquer la méthodologie au choix : améliorer les flashcards, refactorer le code du jour 1, explorer un autre repo, créer un outil CLI

**15h50 – 16h · Débrief final**
- La règle : "Jamais une ligne de code que tu ne peux pas expliquer"
- Reprise des mots du tour de table — évolution des perceptions
- Ce qu'ils repartent avec : rules, template de spec, expérience du contraste, regard critique, réflexe d'exploration
