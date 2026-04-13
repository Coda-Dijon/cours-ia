<a id="jour-2"></a>
# Jour 2 — Structurer, itérer et maîtriser

**Objectif de la journée** : les étudiants apprennent à utiliser l'IA de manière méthodique. Ils découvrent le prompt itératif, les fichiers de règles, la spécification assistée, et les agents. Ils refont le même exercice et constatent l'écart de qualité.

---

<a id="j2-iteratif"></a>
## 9h30 – 10h00 : Le prompt itératif vs le one-shot

### Objectif pédagogique
Comprendre qu'un bon prompt est une *conversation*, pas une commande unique.

### Le problème du one-shot

C'est ce que les étudiants ont fait hier : un gros prompt → un gros résultat → on copie-colle.

**Pourquoi ça ne marche pas** :

- Le prompt unique essaie de tout spécifier d'un coup → il oublie des choses.
- L'IA génère beaucoup de code d'un coup → impossible à vérifier.
- Si un morceau est mauvais, on jette tout et on recommence.
- On ne comprend pas le *cheminement* du code.

### L'approche itérative

```
Prompt 1 : "Je veux un système de score pour mes flashcards. Quels éléments faut-il ?"
        → L'IA propose une structure. On discute.

Prompt 2 : "OK, je garde cette structure. Écris la fonction record_answer($card, $correct)."
        → On vérifie une petite fonction. On valide.

Prompt 3 : "Maintenant get_card_stats, avec le taux de réussite par carte."
        → Incrémental. Chaque étape est vérifiable.

Prompt 4 : "Refactorise pour que le score soit persisté dans le JSON avec les cartes."
        → On améliore par itération, pas par réécriture totale.
```

### Ce qui se passe quand on fait un seul prompt

Le piège du one-shot, c'est qu'on oublie toujours des informations. On pense avoir tout dit, mais en réalité on a laissé des zones d'ombre que l'IA va combler à sa façon — souvent mal. Un prompt unique de 10 lignes omet presque toujours le format des données, les conventions du projet, les cas limites, la gestion d'erreurs. Et on ne s'en rend compte qu'après, quand le code ne fait pas ce qu'on voulait.

L'approche itérative résout ça : en découpant en petites étapes, chaque oubli est rattrapé au prompt suivant.

### Les bénéfices

- **Compréhension** : on comprend chaque morceau parce qu'on l'a demandé individuellement.
- **Contrôle** : on peut corriger tôt au lieu de découvrir les problèmes à la fin.
- **Qualité** : l'IA produit un meilleur code quand le scope est réduit.
- **Apprentissage** : on apprend en dialoguant, pas en copiant.

### Quand ça plante — bien signaler un bug à l'IA (5 min)

L'approche itérative implique que parfois le code généré ne marche pas. La question c'est : comment en parler à l'IA pour qu'elle corrige efficacement ?

**Le mauvais réflexe** : "Ça marche pas, corrige."

→ L'IA ne sait pas *ce qui* ne marche pas. Elle va réécrire le code différemment, en introduisant potentiellement de nouveaux bugs.

**Le bon réflexe** : donner le triptyque **ce que j'attendais / ce qui s'est passé / le message d'erreur** :

```
La fonction record_answer() ne fonctionne pas.

Ce que j'attendais : quand je réponds "bon" à une carte, son compteur "correct" devrait augmenter de 1 et le score devrait être sauvegardé dans le JSON.

Ce qui se passe : le score s'affiche bien pendant la session, mais quand je relance le programme, tout est remis à zéro.

Message d'erreur : il n'y a pas d'erreur PHP, le code s'exécute sans planter.

Voici le code actuel de la fonction :
[coller la fonction]
```

**Pourquoi ça marche mieux** :

- L'IA a le contexte complet du bug — elle peut diagnostiquer au lieu de deviner.
- Le message d'erreur exact (ou l'absence d'erreur) élimine beaucoup d'hypothèses.
- Ça vous force à *comprendre* le problème avant de demander de l'aide — et parfois, en formulant le bug, vous trouvez la solution vous-même.

> **Règle** : ne collez jamais juste "ça marche pas". C'est aussi vrai avec un collègue humain qu'avec l'IA.

---

<a id="j2-specifier"></a>
## 10h00 – 10h30 : Spécifier avant de développer

### Objectif pédagogique
Adopter un workflow professionnel en 3 phases : spécification métier → plan d'implémentation → implémentation par phases avec tests.

### Le problème qu'on résout

Hier, tout le monde a foncé tête baissée. "Améliore mes flashcards" → l'IA a improvisé, et vous avez passé votre temps à réparer.

Le réflexe professionnel, c'est l'inverse : on réfléchit d'abord, on code ensuite. Et l'IA est un partenaire idéal pour les deux premières étapes.

### Le workflow en 3 phases

```
╔═════════════════════════════════════════════════════════════════╗
║  PHASE 1 — SPÉCIFICATION MÉTIER                                ║
║                                                                 ║
║  Contexte IA n°1 (session d'exploration)                        ║
║  "Qu'est-ce qu'on construit et pourquoi ?"                     ║
║                                                                 ║
║  → Discuter du besoin, pas de la technique                     ║
║  → Décrire les comportements attendus côté utilisateur          ║
║  → Lister les règles métier ("une bonne réponse monte          ║
║    le niveau", "niveau max = 5", etc.)                         ║
║  → Identifier les cas limites ("et si toutes les cartes        ║
║    sont maîtrisées ?")                                          ║
║                                                                 ║
║  Livrable : une spec métier claire, sans code                   ║
╚═════════════════════════════════════════════════════════════════╝
                          ↓
╔═════════════════════════════════════════════════════════════════╗
║  PHASE 2 — PLAN D'IMPLÉMENTATION                               ║
║                                                                 ║
║  Toujours dans le contexte n°1                                  ║
║  "Comment on traduit ça en code, étape par étape ?"            ║
║                                                                 ║
║  → Structures de données à créer ou modifier                   ║
║  → Liste des fonctions (signature + description)                ║
║  → Ordre d'implémentation (dépendances entre fonctions)         ║
║  → Découpage en phases testables                                ║
║                                                                 ║
║  Livrable : un plan technique découpé en phases                 ║
╚═════════════════════════════════════════════════════════════════╝
                          ↓
╔═════════════════════════════════════════════════════════════════╗
║  PHASE 3 — IMPLÉMENTATION PAR PHASES (avec tests)              ║
║                                                                 ║
║  Nouveau contexte IA (session de dev)                           ║
║  On colle : rules + spec + plan + code existant                 ║
║                                                                 ║
║  Phase 3a : implémenter les données (structures, constantes)    ║
║     → TESTER : var_dump, vérifier les valeurs                  ║
║  Phase 3b : implémenter la fonction la plus indépendante       ║
║     → TESTER : appel isolé avec des valeurs connues            ║
║  Phase 3c : implémenter la fonction suivante                   ║
║     → TESTER                                                    ║
║  Phase 3d : intégrer dans la boucle de jeu                     ║
║     → TESTER le parcours complet                                ║
║                                                                 ║
║  Règle : on ne passe à la phase suivante que quand              ║
║  la phase actuelle fonctionne.                                  ║
╚═════════════════════════════════════════════════════════════════╝
```

### Pourquoi ce workflow change tout

**Phase 1 (spec métier)** : on clarifie ce qu'on veut *avant* de penser au code. L'IA est excellente pour aider à explorer un besoin, poser les bonnes questions, identifier les cas limites qu'on aurait oubliés.

**Phase 2 (plan d'implémentation)** : on a une carte routière. On sait exactement quelles fonctions créer, dans quel ordre, et comment elles s'articulent. Plus de surprise en cours de route.

**Phase 3 (implémentation par phases)** : chaque morceau est petit, testable, vérifiable. Si l'IA génère du code bugué, on le détecte immédiatement — pas à la fin quand tout est entremêlé.

**Le test après chaque phase est non négociable.** C'est ce qui fait la différence entre "ça a l'air de marcher" et "ça marche".

### Pourquoi deux contextes séparés

- Le contexte d'exploration (phases 1 et 2) est "sale" : on tâtonne, on change d'avis, on explore.
- Le contexte de dev (phase 3) doit être "propre" : spec claire, rules en place, code existant fourni.
- Mélanger les deux pollue le contexte et dégrade la qualité des réponses.

### Démo live (15 min)

Faire la démo complète du workflow sur un cas concret :

1. Ouvrir un premier contexte Gemini CLI → discuter du système de répétition espacée (spec métier)
2. Demander un plan d'implémentation découpé en phases
3. Ouvrir un second contexte → coller le plan + le code existant → implémenter la phase 1
4. Tester la phase 1 en direct (`php -r "require 'data.php'; var_dump(load_cards());"` pour vérifier les nouvelles métadonnées)
5. Continuer avec la phase 2

Montrer le résultat vs ce que le one-shot du jour 1 aurait donné.

#### Template de spec métier

```markdown
# Spec métier : [Nom de la fonctionnalité]

## Ce que ça fait (du point de vue du joueur)
[Décrire l'expérience utilisateur, pas la technique]

## Règles métier
- [Règle 1 : "Une bonne réponse monte le niveau de maîtrise de la carte"]
- [Règle 2 : "Si toutes les cartes sont au niveau max, proposer une révision aléatoire"]
- ...

## Cas limites
- [Que se passe-t-il si... ?]
- [Que se passe-t-il si... ?]
```

#### Template de plan d'implémentation

```markdown
# Plan d'implémentation : [Nom de la fonctionnalité]

## Structures de données
[Les tableaux/variables à créer ou modifier]

## Fonctions à implémenter
- `nom_fonction($params)` : [description courte]
  - Entrée : [types et format]
  - Sortie : [type et format]
  - Cas limites : [ce qui peut mal tourner]

## Découpage en phases
### Phase 1 : [nom — ex: données et structures]
- Quoi : ...
- Test : ...

### Phase 2 : [nom — ex: logique métier]
- Quoi : ...
- Test : ...

### Phase 3 : [nom — ex: intégration]
- Quoi : ...
- Test : ...
```

---

*Pause 10h30 – 10h45*

---

<a id="j2-sessions"></a>
## 10h45 – 11h00 : Sessions d'échange avec l'IA

### Objectif pédagogique
Apprendre à utiliser l'IA comme partenaire de réflexion *avant* de coder, pas seulement comme générateur de code.

### Le bon modèle mental : l'IA est un développeur intermédiaire

Avant de voir les techniques, il faut poser le bon modèle mental. L'IA n'est ni un génie ni un outil magique. **Pensez à l'IA comme un développeur intermédiaire** : il connaît la syntaxe, il a de l'expérience sur des cas classiques, il code vite. Mais il ne connaît pas votre projet, il ne challenge pas vos choix, et il peut faire des erreurs subtiles qu'un senior repérerait.

Concrètement :

- Un **développeur intermédiaire** fait du bon travail quand on lui donne un brief clair et précis. Si on lui dit "fais un truc cool", le résultat sera aléatoire. → L'IA aussi.
- Un **développeur intermédiaire** ne va pas spontanément vous dire "ton architecture est mauvaise". Il va faire ce qu'on lui demande. → L'IA aussi (biais de confirmation).
- Un **développeur intermédiaire** peut écrire du code qui marche mais qui n'est pas optimal, pas sécurisé, ou pas maintenable. → L'IA aussi.

**Conséquence** : votre rôle, c'est celui du **lead technique**. Vous donnez la direction, vous spécifiez, vous relisez, vous validez. L'IA exécute.

### La technique "pose-moi des questions"

C'est la technique la plus simple et la plus puissante pour obtenir du contexte. Au lieu de tout expliquer dans un prompt de 50 lignes, vous dites à l'IA :

```
Je veux ajouter un système de statistiques de progression à mon outil de flashcards PHP CLI.
Avant de proposer quoi que ce soit, pose-moi les questions nécessaires
pour bien comprendre mon besoin et le contexte du projet.
```

L'IA va vous poser des questions comme :
- "Quelles statistiques veux-tu suivre ? (taux de réussite, progression par paquet, temps de réponse...)"
- "Les stats doivent-elles être persistées entre les sessions ?"
- "Veux-tu voir les stats par carte, par paquet, ou les deux ?"
- "Comment veux-tu afficher les stats ? (texte, graphique ASCII, tableau...)"

**Pourquoi c'est puissant** :

1. **Ça force l'IA à identifier ce qui manque** au lieu d'inventer les réponses.
2. **Ça vous fait réfléchir** à des questions que vous ne vous étiez pas posées.
3. **Ça construit un contexte riche** sans que vous ayez à tout anticiper.
4. **Ça reproduit un vrai échange professionnel** — un bon développeur commence toujours par poser des questions.

> **Prompt bonus** : "Pose-moi des questions, mais pose-les une par une, en attendant ma réponse à chaque fois." — pour éviter que l'IA vous noie sous 15 questions d'un coup.

### L'IA comme canard en plastique (amélioré)

Le "rubber duck debugging", c'est expliquer son problème à un canard en plastique pour mieux le comprendre. L'IA, c'est un canard qui répond.

**Usages avant de coder** :

1. **Explorer un problème** : "Je dois gérer un système de score qui persiste entre les sessions. Quelles sont les approches possibles ?"
2. **Challenger sa compréhension** : "Explique-moi pourquoi un tableau associatif est plus adapté qu'un tableau indexé pour stocker une flashcard avec ses métadonnées."
3. **Anticiper les cas limites** : "Quels edge cases devrais-je gérer dans un système de répétition espacée pour flashcards ?"
4. **Comparer des approches** : "Quelle est la différence entre stocker les stats de révision dans le même fichier JSON que les cartes vs dans un fichier séparé ? Avantages/inconvénients de chaque ?"

### Le prompt défensif — demander à l'IA de se critiquer

Une fois que l'IA a produit du code, utilisez-la aussi pour le challenger :

- **"Quels sont les bugs potentiels dans ce code ?"** → L'IA repère souvent des cas limites qu'elle n'a pas gérés elle-même.
- **"Est-ce que cette approche a des failles de sécurité ?"** → Utile pour les requêtes SQL, la gestion d'entrées utilisateur.
- **"Propose une version plus simple."** → L'IA over-engineer souvent. Lui demander de simplifier donne parfois un meilleur résultat.
- **"Explique ce code comme si c'était pour un étudiant de 1ère année."** → Si l'explication est incompréhensible, le code est probablement trop complexe pour votre niveau.

> **Attention** : la critique de l'IA n'est pas parfaite non plus. Elle peut trouver des faux problèmes ou passer à côté de vrais bugs. C'est un outil supplémentaire, pas un remplacement de la relecture humaine.

On fera un exercice de session d'échange ensemble en cours — pas besoin de le détailler ici, on le vivra en direct.

**Message clé** : on n'a pas encore écrit une ligne de code, mais on a une vision claire de ce qu'on va construire. La session d'échange PRÉCÈDE le code.

---

<a id="j2-rules"></a>
## 11h00 – 11h30 : Rules, outils et agents — tour d'horizon complet

### Objectif pédagogique
Comprendre les mécanismes qui permettent de donner un contexte *persistant* à l'IA, connaître le panorama des outils disponibles, et découvrir les concepts d'agents et d'orchestration.

### Les rules (fichiers de règles)

**Ce que c'est** : un fichier de texte (souvent en markdown) qui donne des instructions permanentes à l'IA. Comme un brief qu'on donnerait à un nouvel employé.

**Pourquoi c'est puissant** : au lieu de répéter le contexte à chaque prompt, on le met dans un fichier que l'IA lit automatiquement.

**Exemple concret** (adapté au projet de flashcards) :

```markdown
# Rules — Projet FlashCards CLI

## Contexte technique
- PHP 8.1+ en CLI uniquement (pas de web)
- Pas d'OOP : on utilise des fonctions et des tableaux associatifs
- Pas de dépendance externe (ni Composer, ni bibliothèque tierce)
- Persistance des données en JSON (fichier cards.json)

## Conventions de code
- Noms de fonctions en snake_case
- Commentaires en français
- Chaque fonction a un docblock avec @param et @return
- Indentation : 4 espaces

## Structure du projet
- flashcards.php : point d'entrée (menu et boucle principale)
- functions.php : toutes les fonctions utilitaires (affichage, saisie, listing)
- data.php : données d'exemple, chargement/sauvegarde JSON

## Structure des données
- Carte : ['question' => string, 'answer' => string, 'deck' => string]
- Le fichier cards.json contient un tableau de cartes au format ci-dessus
- Toute modification de la structure DOIT être rétro-compatible avec le JSON existant

## Règles de développement
- Toute nouvelle fonction doit être testable indépendamment
- Pas de variable globale
- Les fonctions retournent des valeurs, elles ne modifient pas directement les paramètres
- Maximum 30 lignes par fonction
- Toujours vérifier que le JSON se charge/sauvegarde correctement après un changement de structure
```

**Démo** : montrer comment créer un fichier `GEMINI.md` à la racine du projet et comment l'IA le prend en compte automatiquement (on y reviendra en détail juste après).

### Les skills et commandes

**Ce que c'est** : des instructions pré-enregistrées pour des tâches récurrentes. Au lieu de retaper le même prompt à chaque fois, on crée un "raccourci" réutilisable.

**Concrètement** : un skill, c'est un fichier texte qui contient un prompt + des instructions. Quand on l'invoque, l'IA reçoit ce contexte automatiquement. C'est comme un template de prompt qu'on peut partager et réutiliser.

**Exemples de skills qu'on pourrait créer pour notre projet FlashCards** :

- `/review` → "Analyse ce code PHP et liste les problèmes potentiels : bugs, failles de sécurité, conventions non respectées"
- `/spec` → "Génère une spécification technique à partir de cette discussion, au format du template qu'on a vu ce matin"
- `/test` → "Écris des cas de test pour cette fonction en utilisant des assertions PHP simples"

**Le même concept existe chez tous les outils** — c'est un pattern universel :

| Outil | Nom du concept | Comment ça marche |
|---|---|---|
| **Gemini CLI** | Skills (`.gemini/skills/`) | Dossier avec un fichier prompt + config, invocable par `/nom_du_skill` |
| **GitHub Copilot CLI** | Skills | Même logique — des commandes personnalisées enregistrées dans la config |
| **Claude Code** | Slash commands (`.claude/commands/`) | Fichier markdown avec le prompt, invocable par `/nom_de_commande` |
| **Cursor** | Custom commands | Prompts personnalisés accessibles depuis la palette de commandes |

L'idée est toujours la même : capitaliser sur un bon prompt pour ne pas le réécrire. Quand vous trouvez une manière efficace de demander quelque chose à l'IA, transformez-la en skill.

**Démo** : montrer comment créer un skill simple dans Gemini CLI — par exemple un skill `/flashcard-review` qui demande à l'IA d'analyser le code du projet en vérifiant la cohérence avec les règles métier des flashcards.

### Les agents de code IA — panorama

Avant de parler d'agents au sens technique, faisons le tour des outils qui existent. Le marché évolue très vite, mais voici les principaux acteurs à connaître :

**Gemini CLI** (Google — gratuit, open source)
C'est l'outil qu'on utilise dans ce cours. Il tourne dans le terminal, se connecte à Gemini, et peut lire/écrire des fichiers, exécuter des commandes, et travailler sur l'ensemble d'un projet. Son point fort : une fenêtre de contexte massive (1M tokens) qui lui permet de "voir" des centaines de fichiers d'un coup. C'est aussi l'outil avec le tier gratuit le plus généreux.

**Claude Code** (Anthropic — payant)
Également en terminal, c'est le concurrent direct de Gemini CLI. Très fort en raisonnement complexe, débogage, et compréhension profonde de codebase. Son modèle (Claude Opus) est considéré comme l'un des meilleurs en raisonnement. Plus cher, mais souvent plus précis sur des tâches complexes.

**Cursor** (IDE complet — freemium)
Un éditeur de code complet (basé sur VS Code) avec l'IA intégrée partout : autocomplétion, chat, édition multi-fichiers. Le plus accessible pour les débutants. Leader du marché actuellement.

**GitHub Copilot** (Microsoft/GitHub — payant, gratuit pour étudiants)
Intégré dans VS Code et d'autres IDE. Surtout connu pour l'autocomplétion de code en temps réel (il propose la suite du code pendant qu'on tape). Depuis peu, il propose aussi un mode "agent" plus complet.

**Autres** : Windsurf (Codeium), Codex CLI (OpenAI), Qwen Code, Aider... Le paysage change tous les mois.

> **Point clé pour les étudiants** : les principes qu'on apprend (rules, specs, approche itérative) s'appliquent à TOUS ces outils. Ce qui change, c'est l'interface et la syntaxe. Ce qui reste, c'est la méthode.

### Tour complet de Gemini CLI — les fonctionnalités clés

Gemini CLI n'est pas qu'un simple chat dans le terminal. C'est un outil complet avec de nombreuses fonctionnalités. Faisons le tour de ce qui est disponible.

#### Le fichier GEMINI.md — le cœur du contexte

Le fichier `GEMINI.md` est le mécanisme principal de Gemini CLI pour donner du contexte persistant à l'IA. C'est l'équivalent du "rules" qu'on a vu, mais avec un système hiérarchique puissant.

**Où le placer** :

- **Global** : `~/.gemini/GEMINI.md` → instructions par défaut pour TOUS vos projets (style de code, langue préférée, etc.)
- **Projet** : `GEMINI.md` à la racine du projet → instructions spécifiques au projet (stack technique, conventions, structure)
- **Sous-dossier** : un `GEMINI.md` dans n'importe quel dossier → instructions ultra-spécifiques à ce module

Le système est **hiérarchique** : Gemini CLI charge et concatène TOUS les fichiers trouvés, du global au plus spécifique. Quand l'IA accède à un fichier dans un sous-dossier, elle découvre automatiquement le `GEMINI.md` local.

**Importer d'autres fichiers** : on peut découper un gros GEMINI.md en plusieurs fichiers avec la syntaxe `@fichier.md` :

```markdown
# Rules du projet

@conventions.md
@structure.md
@regles-metier.md
```

> **Équivalents chez les concurrents** : Claude Code utilise `CLAUDE.md`, Cursor utilise `.cursor/rules`, GitHub Copilot utilise `.github/copilot-instructions.md`. Le concept est le même partout — seul le nom du fichier change.

#### La mémoire (`/memory`)

La mémoire dans Gemini CLI, c'est le mécanisme qui gère l'ensemble des instructions chargées depuis les fichiers GEMINI.md. Trois commandes à connaître :

- `/memory show` → affiche le contexte complet chargé (tous les GEMINI.md concaténés, de tous les niveaux). Indispensable pour vérifier que l'IA a bien lu vos instructions.
- `/memory reload` → force le rechargement de tous les fichiers GEMINI.md. Utile quand on vient de modifier un fichier en cours de session.
- `/memory add <texte>` → ajoute du texte directement au GEMINI.md global (`~/.gemini/GEMINI.md`) sans quitter la session. Pratique pour enregistrer une préférence à la volée : `/memory add Toujours répondre en français`.

**Démo** : créer un `GEMINI.md` à la racine du projet de flashcards, montrer `/memory show`, modifier le fichier, faire `/memory reload`, montrer la différence.

#### Les commandes slash

Gemini CLI propose des commandes intégrées pour piloter la session. Les principales :

- `/help` → liste toutes les commandes disponibles
- `/tools` → affiche la liste des outils que l'IA peut utiliser (lecture/écriture de fichiers, exécution de commandes, recherche web, etc.). Très utile pour comprendre ce que le modèle "voit" comme capacités.
- `/stats` → statistiques de la session en cours : nombre de tokens consommés, tokens cachés, durée, nombre d'appels d'outils. Utile pour comprendre la "consommation" d'une conversation.
- `/compact` → **résume toute la conversation** et remplace l'historique par ce résumé. Ça libère de la place dans la fenêtre de contexte quand on atteint les limites. On garde l'essentiel, on jette le bruit.
- `/chat` → ouvre une conversation parallèle (branching). On peut explorer une piste sans polluer la conversation principale.

> **Conseil** : montrer `/stats` régulièrement pendant les exercices pour que les étudiants visualisent combien de tokens ils consomment. Ça rend le coût de l'IA concret.

#### Les outils intégrés (tools)

Quand on dit que Gemini CLI est un "agent", c'est parce qu'il ne fait pas que discuter — il a des **outils** qu'il peut utiliser de manière autonome :

- **Lecture/écriture de fichiers** → il peut lire votre code, créer de nouveaux fichiers, modifier des fichiers existants
- **Exécution de commandes shell** → il peut lancer `php flashcards.php`, `git status`, `composer install`... directement depuis la conversation
- **Recherche Google** (grounding) → il peut vérifier une info en temps réel sur le web pour compléter ses connaissances
- **Fetch web** → il peut aller lire le contenu d'une page web

C'est cette combinaison lecture + écriture + exécution qui fait la différence avec un simple chatbot.

### Les agents et l'orchestration

#### L'agent simple — le mode "agentic"

Au-delà des outils eux-mêmes, le mot "agent" désigne un enchaînement automatisé d'actions. L'IA exécute plusieurs étapes dans un ordre défini, sans intervention humaine entre chaque étape.

**Exemple concret** :

```
Vous : "Ajoute une fonction reset_card_level qui remet une carte
        en révision (niveau 0), avec un test."

L'IA enchaîne automatiquement :
1. Lit le fichier functions.php pour voir le code existant
2. Lit data.php pour comprendre la structure de données
3. Écrit la fonction reset_card_level dans functions.php
4. Crée un test
5. Exécute le test avec php -r "..."
6. Corrige si le test échoue
```

C'est ce que font Gemini CLI et Claude Code quand on leur donne une tâche complexe : ils décomposent, lisent des fichiers, écrivent du code, exécutent des tests — tout seuls. On appelle ça le mode "agentic".

**Démo** : donner cette tâche à Gemini CLI et observer comment il enchaîne les étapes automatiquement.

#### Les sub-agents — déléguer des sous-tâches

Gemini CLI va plus loin avec les **sub-agents** : des agents spécialisés qui tournent dans leur propre contexte, séparé du contexte principal. L'agent principal peut "appeler" un sub-agent pour une tâche spécifique. Le sub-agent a ses propres instructions, ses propres outils, et il rapporte son résultat à l'agent principal.

```
Agent principal (vous lui parlez) :
  "Ajoute le système de répétition espacée aux flashcards"

  → Délègue au sub-agent "analyste" :
      "Lis tout le code existant et fais-moi un résumé de l'architecture"
      ← Résultat : résumé de l'architecture

  → Délègue au sub-agent "développeur" :
      "Voici l'architecture. Implémente les fonctions de répétition espacée."
      ← Résultat : nouveau code

  → Délègue au sub-agent "testeur" :
      "Voici le code. Écris et exécute les tests."
      ← Résultat : rapport de tests
```

L'intérêt : chaque sub-agent a un contexte propre et ciblé. Il ne voit que ce dont il a besoin, ce qui améliore la qualité des réponses (moins de bruit = meilleur résultat).

#### L'orchestration multi-agents — le futur

On entre dans le territoire avancé, mais c'est important de savoir que ça existe. L'idée : au lieu d'un seul agent qui fait tout, on a **plusieurs agents qui collaborent** :

- Un **orchestrateur** (le "chef de projet") qui reçoit la tâche et la décompose
- Des **agents spécialistes** qui travaillent en parallèle sur des sous-tâches
- Un **mécanisme de coordination** pour que les agents ne se marchent pas dessus (pas d'édition simultanée du même fichier)

Des projets comme Maestro (pour Gemini CLI) permettent déjà de faire tourner 20+ agents spécialisés en parallèle : un pour l'architecture, un pour la sécurité, un pour les tests, un pour la documentation...

**On n'en est pas encore là au quotidien**, mais c'est la direction que prend l'industrie. Ce qui est important à comprendre :

1. **Les agents deviennent de plus en plus autonomes** — la tendance est claire.
2. **Le rôle du développeur se déplace** : de "celui qui écrit le code" vers "celui qui définit les règles, vérifie les résultats, et orchestre les agents".
3. **Les compétences fondamentales ne changent pas** : comprendre le code, savoir spécifier un besoin, savoir tester — tout ce qu'on apprend dans ce cours reste la base.

> **Attention** : plus l'agent est autonome, plus il faut vérifier le résultat. Un agent peut enchaîner 10 étapes... dont 3 mauvaises. Un système multi-agents peut produire un projet entier... avec des bugs subtils dans chaque module. La relecture humaine reste indispensable.

---

<a id="j2-workflow"></a>
## 11h15 – 11h45 : Ton workflow réel

### Objectif pédagogique
Montrer un cas concret d'utilisation professionnelle de l'IA, avec des exemples réels, et faire comprendre pourquoi les tests sont le filet de sécurité indispensable quand on travaille avec l'IA.

### Démo courte — Projet client

Montrer (en floutant les infos confidentielles si nécessaire) :

1. **Le fichier de rules** d'un vrai projet — montrer la richesse du contexte donné à l'IA.
2. **Une session de spec** — comment une discussion avec l'IA aboutit à un document technique clair.
3. **Un prompt de développement** — avec le contexte, les rules, la spec → le code produit.

### Ce que j'automatise au quotidien (3 exemples)

**Exemple 1 : Génération de CRUD**
> "Quand j'ai une nouvelle entité à créer (ex : un système de facturation), l'IA me génère le squelette complet en suivant mes rules : migration, modèle, contrôleur, routes, validation. Je passe de 2h à 15 min — mais je relis tout."

**Exemple 2 : Revue de code**
> "Avant de committer, je fais relire mon diff par l'IA. Elle détecte les incohérences, les oublis de validation, les failles de sécurité basiques. Ça ne remplace pas une vraie revue humaine, mais ça attrape 80% des erreurs bêtes."

**Exemple 3 : Rédaction de tests**
> "J'écris la fonction, je demande à l'IA de générer les tests unitaires. Elle couvre souvent des cas limites auxquels je n'aurais pas pensé. Je vérifie et j'ajuste, mais ça me fait gagner un temps considérable."

### Les tests : le vrai garde-fou quand on travaille avec l'IA

Vous n'avez pas encore appris à écrire des tests automatisés — et ce n'est pas le sujet du cours. Mais il faut comprendre dès maintenant **pourquoi les tests deviennent encore plus importants** quand on utilise l'IA pour coder.

#### Le problème fondamental

Quand vous écrivez du code vous-même, ligne par ligne, vous comprenez chaque décision. Si un bug arrive, vous avez une intuition de où chercher parce que vous avez construit le raisonnement.

Quand l'IA écrit du code pour vous, vous recevez un bloc de 50 lignes d'un coup. Même si vous le relisez, vous n'avez pas le même niveau de compréhension que si vous l'aviez écrit. Et c'est là que les bugs se cachent — dans les détails que vous n'avez pas questionnés.

**Sans tests, comment savoir que le code fait ce qu'il prétend faire ?**

On ne le sait pas. On fait confiance. Et la confiance, en développement, c'est le meilleur moyen de livrer des bugs.

#### Les tests comme filet de sécurité

Un test, c'est simple dans le principe : on appelle une fonction avec des valeurs connues, et on vérifie que le résultat est celui qu'on attend.

```
J'appelle calculate_urgency() avec une carte de niveau 2
    revue il y a 3 jours → j'attends un certain score.

J'appelle record_answer() avec une bonne réponse
    → je vérifie que le compteur a bien augmenté de 1.

J'appelle load_cards() après une sauvegarde
    → je vérifie que les données sont les mêmes.
```

C'est exactement ce que vous avez fait avec `php -r "..."` dans le workflow par phases. Ces petites vérifications manuelles, c'est déjà du test. La version "pro", c'est simplement de les automatiser pour pouvoir les relancer à volonté.

#### Pourquoi c'est crucial avec l'IA

L'IA fait trois choses qui rendent les tests indispensables :

1. **Elle modifie du code existant sans le vouloir.** Quand vous lui demandez d'ajouter une fonctionnalité, elle peut casser quelque chose qui marchait avant. C'est ce qu'on appelle une **régression**. Sans tests, vous ne le découvrez que quand un utilisateur tombe dessus.

2. **Elle gère mal les cas limites.** L'IA produit souvent du code qui fonctionne pour le cas "normal" mais qui plante sur les cas rares : une liste vide, un nombre négatif, un fichier qui n'existe pas. Les tests forcent à vérifier ces cas.

3. **Elle vous donne confiance à tort.** Le code généré a l'air propre, les noms de variables sont parlants, la structure semble logique. Mais "a l'air de marcher" ≠ "marche". Les tests transforment une impression en certitude.

#### L'analogie du parachute

Imaginez que vous sautez d'un avion. L'IA, c'est quelqu'un qui vous a plié votre parachute. Il a l'air compétent, il vous dit que c'est bon, le sac a la bonne forme. Mais est-ce que vous sautez sans vérifier ?

Les tests, c'est la vérification du parachute. On ne saute pas sans.

Plus vous déléguez l'écriture du code à l'IA, plus vous avez besoin de tests pour vérifier le résultat. C'est contre-intuitif : on pourrait croire que l'IA rend les tests moins nécessaires. C'est l'inverse.

### Le message

L'IA est un multiplicateur, pas un remplaçant. Plus vous êtes compétent, plus l'IA vous est utile. Moins vous êtes compétent, plus elle est dangereuse. Et les tests sont ce qui vous permet de faire confiance au code — qu'il soit écrit par vous, par un collègue, ou par une IA.

---

<a id="j2-prep"></a>
## 11h45 – 12h : Préparation de l'exercice 2

### Objectif pédagogique
Les groupes appliquent immédiatement ce qu'ils viennent d'apprendre : rules, contexte, spec.

### Consignes

Chaque groupe doit, pendant cette demi-heure :

1. **Créer un fichier de rules** pour leur projet (en s'inspirant de l'exemple montré).
2. **Appliquer des rules existantes** : aller voir la collection de skills/rules d'Anthropic sur [github.com/anthropics/skills](https://github.com/anthropics/skills/tree/main/skills). Les étudiants choisissent celles qui sont pertinentes pour leur projet (par exemple des rules liées au PHP, à la qualité de code, au testing…) et les intègrent ou s'en inspirent pour enrichir leur propre fichier de rules.
3. **Ouvrir une session d'échange** avec l'IA pour explorer la fonctionnalité qu'ils veulent ajouter.
4. **Produire une spec** de la fonctionnalité en utilisant le template fourni.

**Ils ne codent PAS encore.** C'est de la préparation pure.

**Fonctionnalités suggérées** (chaque groupe en choisit une) :

- Système de **répétition espacée** (niveaux de maîtrise 0-5, priorisation des cartes urgentes, espacement progressif)
- Système de **statistiques de progression** (taux de réussite par paquet, par carte, évolution dans le temps, récap de session)
- Système d'**import/export** (importer des cartes depuis un fichier texte `question | réponse`, exporter un paquet, gestion des doublons)
- Système de **sessions chronométrées** (temps par carte, limite de temps optionnelle, score bonus si réponse rapide)
- Système de **quiz à choix multiples** (générer des mauvaises réponses à partir des autres cartes du paquet, mixer QCM et réponse libre)

> **Rôle de l'intervenant** : cette fois, circuler et aider. Vérifier que les rules sont pertinentes, que les specs sont claires, que les échanges avec l'IA sont constructifs.

---

*Pause déjeuner 12h – 13h*

---
