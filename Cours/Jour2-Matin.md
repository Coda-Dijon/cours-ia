<a id="jour-2"></a>
# Jour 2 — Structurer, itérer et maîtriser

**Objectif de la journée** : les étudiants apprennent à utiliser l'IA de manière méthodique. Ils découvrent le prompt itératif, les fichiers de règles, la spécification assistée, et les agents. Ils refont le même exercice et constatent l'écart de qualité.

---

<a id="j2-debrief-j1"></a>
## 9h30 – 9h50 : Débrief du jour 1

### Objectif pédagogique
Prendre un moment posé pour verbaliser ce qui a été vécu la veille, réancrer les grands messages, et amorcer la journée avec un esprit clair. Ce n'est pas un simple récap par l'intervenant — c'est un moment d'échange où les étudiants formulent leurs surprises et leurs doutes.

### 1. Récap guidé (8 min)

Reprendre au tableau les grands moments du jour 1, en ordre chronologique, et laisser les étudiants compléter à l'oral.

- Le matin : comment fonctionne un LLM. Prédiction statistique, tokens, embeddings, attention, auto-régression. L'IA n'est pas un cerveau — c'est une machine à probabilités.
- L'exercice 1 : le run naïf sur les flashcards. Ce qu'ils ont ressenti, ce qui a foiré, ce qui les a surpris dans le code produit.
- L'après-midi : les patterns d'échec (hallucinations, biais, confiance mal calibrée), les limites éthiques (propriété intellectuelle, confidentialité, impact environnemental, responsabilité), et les cas où NE PAS utiliser l'IA.

**Les 4 grands messages du jour 1** (à réénoncer clairement) :

1. Un LLM est un calculateur statistique — il ne comprend pas, il prédit.
2. L'IA hallucine, confirme vos erreurs, et ne dit jamais "je ne sais pas".
3. Sans méthode, l'IA produit du code vraisemblable mais incohérent.
4. Le métier change, mais les fondamentaux restent : lire, comprendre, vérifier.

### 2. Tour de table express (10 min)

Format court : ~30 secondes par étudiant, l'intervenant distribue la parole et relance si besoin. Une seule question au choix :

- **Ce qui m'a le plus surpris hier** — un moment précis où ils se sont dit "ah, je n'avais pas vu ça comme ça".
- **Ce qui m'inquiète** — un doute, une peur, un truc qui leur est resté en travers. C'est normal d'être secoué, il faut que ça puisse sortir.
- **Ce que je vais faire différemment dès aujourd'hui** — l'intention concrète.

**Rôle de l'intervenant** : écouter, noter au tableau les thèmes récurrents, pas juger. Si un étudiant dit quelque chose de faux ou déformé, reformuler doucement sans le reprendre frontalement.

### 3. Cadrage du jour 2 (2 min)

> "Hier, on a secoué votre idée de l'IA. Aujourd'hui, on vous donne les outils pour *vraiment* travailler avec elle. Pas en chatbot, pas en stackoverflow++. En vrai outil de travail.
>
> On reprend le même projet de flashcards. Mais cette fois, avec une méthode : **contexte**, **rules**, **specs**, **prompts itératifs**, **agents**. Vous allez revoir votre code d'hier avec de nouveaux yeux — et livrer quelque chose dont vous serez vraiment fiers.
>
> Et ça commence maintenant, par le concept pivot : le **contexte**."

---

<a id="j2-contexte"></a>
## 9h50 – 10h30 : La notion de contexte

### Objectif pédagogique
Comprendre que le contexte est *la* variable clé qui détermine la qualité des réponses de l'IA. C'est le concept pivot qui relie le jour 1 (ce qu'on a vécu) au jour 2 (ce qu'on va mettre en place).

### Pourquoi le contexte est la clé

L'IA ne connaît rien de votre projet. Sans contexte, elle invente — structure de données, conventions, périmètre. D'où les incohérences d'hier.

> **Rappel** : un LLM prédit le prochain token à partir de ce qu'il voit. Plus le contexte est précis, plus les prédictions tombent juste.

### Les composants d'un bon contexte

```
Un bon contexte =
    Qui je suis (niveau, objectif)
  + Ce qui existe déjà (code, structure, conventions)
  + Ce que je veux précisément (fonctionnalité, contraintes)
  + Ce que je ne veux PAS (limites, anti-patterns)
  + Le format attendu (style de code, langue des commentaires)
```

Chaque composant oublié = une zone d'ombre que l'IA va combler à sa façon.

### Exercice : le one-shot parfait (20 min)

**Objectif** : refaire l'outil de flashcards d'hier **en un seul prompt**, depuis une session vierge.

**Consigne** :

> "Un seul prompt, un seul résultat. Deux exigences :
>
> 1. **Périmètre fonctionnel complet** — toutes les fonctionnalités d'hier.
> 2. **Qualité du code** — ce que vous auriez aimé produire à la main (conventions, lisibilité, pas de sur-ingénierie).
>
> Si le résultat ne satisfait pas les deux critères, repartez d'une session vierge et itérez sur le *prompt*, pas sur le code."

**Règles** :

- Session vierge par tentative.
- Pas de correction manuelle ni de prompt de rattrapage.
- Entre deux tentatives : noter ce qui manquait dans le prompt précédent.

#### Bien formuler un retour entre deux tentatives

Ne dites pas "c'était pas ça". Utilisez le triptyque **ce que j'attendais / ce que l'IA a produit / l'écart** :

```
Attendu : boucle de jeu simple en procédural.
Produit : classes OOP avec un FlashcardManager.
Écart : j'avais oublié de dire "pas d'OOP, code procédural uniquement".
```

Ce cadre force à identifier ce qui manquait — c'est exactement ce qu'il faut ajouter au prompt suivant.

### Réflexion et discussion (10 min)

Tour de table. Questions pour guider :

- Combien de tentatives avant un résultat satisfaisant ?
- **Qu'est-ce qui a bien marché** dans le prompt final ? Quels composants du contexte étaient présents ?
- Qu'est-ce qui manquait systématiquement au début ?
- Des patterns récurrents entre étudiants ?

> **Transition** : "Quand le contexte est bon, un seul prompt suffit. Mais l'écrire demande de la méthode. Voyons comment la structurer."

---

*Pause 10h30 – 10h45*

---

<a id="j2-iteratif"></a>
## 10h45 – 11h15 : Le prompt itératif vs le one-shot

### Objectif pédagogique
Comprendre qu'un bon prompt est une conversation, pas une commande unique.

### Le problème du one-shot

Un prompt unique qui spécifie tout d'un coup oublie toujours quelque chose : format des données, conventions, cas limites, gestion d'erreurs. Et on ne le voit qu'après, quand le code ne fait pas ce qu'on voulait. L'IA génère beaucoup de code d'un seul tenant, impossible à vérifier. Si un morceau est mauvais, on jette tout.

### L'approche itérative

```
Prompt 1 : "Je veux un système de score. Quels éléments faut-il ?"
        → On discute la structure.
Prompt 2 : "OK, écris record_answer($card, $correct)."
        → Une petite fonction à vérifier.
Prompt 3 : "Maintenant get_card_stats, avec le taux de réussite."
        → Incrémental, vérifiable.
Prompt 4 : "Refactorise pour persister le score dans le JSON."
        → Amélioration, pas réécriture totale.
```

Chaque oubli est rattrapé au prompt suivant. Chaque morceau est vérifiable.

### Les bénéfices

- **Compréhension** : chaque morceau est demandé individuellement.
- **Contrôle** : on corrige tôt au lieu de découvrir les problèmes à la fin.
- **Qualité** : l'IA produit mieux quand le scope est réduit.

### Exercice : itératif ou one-shot ? (20 min)

On part d'un outil de flashcards simple déjà fourni : créer/lister des decks, ajouter/supprimer des cartes, session de révision basique.

**Mission** : ajouter les 7 fonctionnalités suivantes.

1. **Score par carte** : compteurs bonnes/mauvaises, persistés.
2. **Historique de révision** : liste des dernières révisions par carte (date + résultat).
3. **Statistiques par deck** : taux de réussite global, carte la mieux/moins maîtrisée.
4. **Révision intelligente** : priorité aux cartes faibles et à celles oubliées depuis longtemps.
5. **Niveau de maîtrise** 0-5 : monte/descend selon la réponse ; les cartes au niveau 5 apparaissent moins souvent.
6. **Export CSV** des stats d'un deck.
7. **Réinitialisation** des stats d'un deck (avec confirmation).

**Consigne** :

> "À vous de choisir : un seul gros prompt qui liste tout, ou itératif, fonctionnalité par fonctionnalité. Faites ce qui vous semble naturel. Débrief dans 20 min."

**Observation (silencieuse) pendant l'exercice** :

- Qui fonce sur un gros prompt ? Qui découpe ?
- Chez les one-shot : les 7 fonctionnalités sont-elles présentes et cohérentes (le niveau de maîtrise influe-t-il vraiment sur la révision intelligente ? score et historique non redondants ?) ?
- Chez les itératifs : combien de fonctionnalités finies ? Qualité ?

**Debrief (5 min)** : à main levée, qui a fait quoi. Puis faire remonter les oublis/incohérences du one-shot et les rattrapages des itératifs.

Le piège est volontaire : 7 fonctionnalités interdépendantes sont presque impossibles à spécifier d'un seul jet.

---

<a id="j2-specifier"></a>
## 11h15 – 11h45 : Spécifier avant de développer

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

[Spec-Driven Development](https://github.com/github/spec-kit)

### Pourquoi ce workflow change tout

**Phase 1 (spec métier)** : on clarifie ce qu'on veut *avant* de penser au code. L'IA est excellente pour aider à explorer un besoin, poser les bonnes questions, identifier les cas limites qu'on aurait oubliés.

**Phase 2 (plan d'implémentation)** : on a une carte routière. On sait exactement quelles fonctions créer, dans quel ordre, et comment elles s'articulent. Plus de surprise en cours de route.

**Phase 3 (implémentation par phases)** : chaque morceau est petit, testable, vérifiable. Si l'IA génère du code bugué, on le détecte immédiatement — pas à la fin quand tout est entremêlé.

**Le test après chaque phase est non négociable.** C'est ce qui fait la différence entre "ça a l'air de marcher" et "ça marche".

### Pourquoi deux contextes séparés

- Le contexte d'exploration (phases 1 et 2) est "sale" : on tâtonne, on change d'avis, on explore.
- Le contexte de dev (phase 3) doit être "propre" : spec claire, rules en place, code existant fourni.
- Mélanger les deux pollue le contexte et dégrade la qualité des réponses.

### Exercice : ajouter une fonctionnalité en spec-driven (15 min)

On reprend l'outil de flashcards et on ajoute **une seule** nouvelle fonctionnalité (au choix : mode examen chronométré, système de tags sur les cartes, import d'un deck depuis un CSV, statistiques hebdomadaires, ou une idée personnelle).

**Étape 1 — Spec métier (5 min)** : dans un premier contexte Gemini CLI, produire un document de spécification (en markdown, sans code) qui décrit le comportement attendu, les règles métier et les cas limites. Utiliser le template ci-dessous.

**Étape 2 — Plan d'implémentation (3 min)** : dans le même contexte, demander à l'IA de transformer la spec en plan découpé en phases testables.

**Étape 3 — Implémentation phase 1 (7 min)** : ouvrir un **nouveau contexte** vierge, coller le code existant + la spec + le plan, demander uniquement la phase 1. Tester avant d'aller plus loin.

L'objectif n'est pas de finir la fonctionnalité — c'est de vivre le workflow complet au moins une fois et de ressentir la différence avec le prompt direct.

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

<a id="j2-sessions"></a>
## 11h45 – 12h00 : Sessions d'échange avec l'IA

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

*Pause déjeuner 12h – 13h30*

---
