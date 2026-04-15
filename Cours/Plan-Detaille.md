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

**15h50 – 16h30 · La notion de contexte**
- Pourquoi le contexte est la clé (lien avec le chaos du matin)
- Démo side-by-side : même prompt sans et avec contexte
- Les 5 composants d'un bon contexte
- **Mini-exercice comparatif (15 min)** : chaque binôme réécrit un prompt du matin en deux versions (sans/avec contexte), lance les deux dans Gemini CLI, compare. Mise en commun orale.

**16h30 – 17h · Débrief Jour 1**
- Récap guidé des grands moments de la journée (8 min)
- Tour de table posé : ce qui a surpris, ce qui inquiète, ce que je vais changer (15 min)
- Teaser Jour 2 (7 min) : rules, specs, agents, contraste à venir

---

### JOUR 2 — Structurer, itérer et maîtriser

#### Matin (9h30 – 12h)

**9h30 – 10h00 · Le prompt itératif vs le one-shot**
- Pourquoi le one-shot échoue (on oublie toujours des informations), l'approche itérative en 4 étapes
- Bien signaler un bug : le triptyque attendu / observé / message d'erreur

**10h00 – 10h30 · Spécifier avant de développer**
- Le workflow en 3 phases : spec métier → plan d'implémentation → implémentation par phases avec tests
- Deux contextes séparés (exploration vs dev)
- Démo live du workflow complet
- Templates : spec métier + plan d'implémentation

*Pause 10h30 – 10h45*

**10h45 – 11h00 · Sessions d'échange avec l'IA**
- Modèle mental : l'IA = dev intermédiaire, vous = lead technique
- Techniques : "pose-moi des questions", canard en plastique amélioré, prompt défensif

**11h00 – 11h45 · Du LLM à l'agent — rules, outils, orchestration**
- **11h00 – 11h10 · LLM basique vs agent** — les briques (tool use, mémoire, boucle observer/décider/agir). Question : "Gemini CLI hier, c'était encore un chatbot ?"
- **11h10 – 11h25 · Rules = la mémoire long-terme de l'agent** — fichiers de rules, exemple FlashCards, GEMINI.md hiérarchique, skills, panorama des agents (Gemini CLI, Claude Code, Cursor, Copilot)
- **11h25 – 11h40 · Orchestration multi-agents** — pourquoi un seul agent ne suffit plus, patterns (orchestrateur/workers, sub-agents, hand-offs, parallélisation), lien vers [claude.com/blog/multi-agent-coordination-patterns](https://claude.com/blog/multi-agent-coordination-patterns), limites (coût, debug, fiabilité), discussion ouverte sur le métier qui vient
- **11h40 – 11h45 · Transition** — "vous n'allez plus parler à un chatbot, vous allez configurer un agent"

**11h45 – 12h · Préparation de l'exercice 2**
- Création du fichier de rules + exploration du repo Anthropic Skills pour s'inspirer de rules existantes
- Session d'échange, rédaction de la spec
- Pas de code — préparation pure
- Choix d'une fonctionnalité par groupe (répétition espacée, stats, import/export, chrono, QCM)

*Pause déjeuner 12h – 13h30*

#### Après-midi (13h30 – 17h)

**13h30 – 14h45 · Exercice 2 — Le run "structuré"**
- Même projet, avec rules + spec + itératif
- Critères : code fonctionnel, cohérent avec l'existant, compris par tous, prompts structurés, spec respectée
- L'intervenant circule et intervient cette fois

*Pause 14h45 – 15h00*

**15h00 – 15h30 · Ton workflow réel**
- Démo projet client anonymisé : rules réelles, session de spec, prompt de dev
- 3 exemples d'automatisation quotidienne : CRUD, revue de code, génération de tests
- Les tests comme garde-fou : pourquoi l'IA rend les tests plus nécessaires (pas moins)
- L'analogie du parachute

**15h30 – 16h30 · Atelier — Explorer le framework Symfony avec l'IA**
- Mise en place (5 min) : clone du repo Symfony, composant attribué par groupe
- Phase 1 (25 min) : comprendre la codebase — cycle d'une requête HTTP
- Phase 2 (25 min) : analyse technique approfondie — pourquoi ces choix d'architecture
- Mise en commun (5 min) : tour rapide, l'intervenant relie les morceaux

**16h30 – 16h45 · Temps libre encadré**
- Appliquer la méthodologie au choix : améliorer les flashcards, refactorer le code du jour 1, explorer un autre repo, créer un outil CLI

**16h45 – 17h · Débrief final**
- La règle : "Jamais une ligne de code que tu ne peux pas expliquer"
- Reprise des mots du tour de table — évolution des perceptions
- Ce qu'ils repartent avec : rules, template de spec, expérience du contraste, regard critique, réflexe d'exploration
