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

L'IA ne connaît rien de votre projet. À chaque prompt, elle part de zéro (ou presque). Si vous ne lui donnez pas de contexte, elle *invente* le contexte.

Hier, quand vous avez demandé "ajoute un système de répétition espacée" sans préciser :

- La structure de données existante
- Le langage et sa version
- Les conventions du projet
- Ce qui existe déjà

…l'IA a inventé tout ça. D'où les incohérences, les structures de données qui changent d'un prompt à l'autre, et le code qui ne s'intègre pas au reste.

> **Rappel du matin d'hier** : un LLM prédit le prochain token à partir de *tout ce qu'il voit* dans la fenêtre de contexte. Plus ce que vous fournissez est précis, plus les prédictions tombent juste. Moins vous fournissez, plus l'IA "moyenne" sur ses données d'entraînement — et on retombe dans les biais et les hallucinations.

### Démo side-by-side

**Même prompt, deux contextes différents.**

#### Sans contexte :

```
Ajoute un score à mon outil de flashcards PHP.
```

→ L'IA va probablement générer de l'OOP, choisir sa propre structure de stockage, inventer des classes `ScoreManager`, `ReviewSession`, etc. Exactement ce qu'on a vu hier.

#### Avec contexte :

```
Je travaille sur un outil de flashcards en PHP CLI.
Voici la structure de mes cartes (tableaux associatifs) :
$card = ['question' => '...', 'answer' => '...', 'deck' => 'PHP Bases'];

Les cartes sont stockées dans un fichier cards.json.
Les fonctions existantes sont dans functions.php :
- display_card($card, $show_answer) : affiche une carte
- get_user_input($prompt) : lit une saisie utilisateur

Crée une fonction record_answer(array &$cards, int $index, bool $correct) qui :
- Ajoute un champ 'times_correct' ou 'times_wrong' à la carte (incrémente)
- Ajoute un champ 'last_reviewed' avec la date du jour (format 'Y-m-d')
- Sauvegarde le fichier JSON après modification
- N'utilise que des fonctions PHP natives

Le code doit être simple, sans OOP, avec des commentaires en français.
```

→ Le résultat sera cohérent avec le projet existant, respectera les conventions, et sera compréhensible.

Faire la démo en live dans Gemini CLI : lancer les deux prompts dans des sessions séparées et afficher les résultats côte à côte. Le contraste est saisissant.

### Les composants d'un bon contexte

```
Un bon contexte =
    Qui je suis (niveau, objectif)
  + Ce qui existe déjà (code, structure, conventions)
  + Ce que je veux précisément (fonctionnalité, contraintes)
  + Ce que je ne veux PAS (limites, anti-patterns)
  + Le format attendu (style de code, langue des commentaires)
```

Chaque composant oublié, c'est une zone d'ombre que l'IA va combler à sa façon — et souvent mal.

### Mini-exercice comparatif (15 min)

Pour que la différence soit *vécue* et pas juste expliquée, on fait l'exercice en direct.

**Consigne (en binôme, 10 min)** :

> "Reprenez un des prompts que vous avez utilisés hier — celui dont vous êtes le moins fier. Réécrivez-le en deux versions :
>
> - **Version A** : le prompt d'origine, tel quel.
> - **Version B** : le même prompt, enrichi avec les 5 composants du contexte ci-dessus.
>
> Lancez les deux versions dans Gemini CLI, l'une après l'autre (session propre entre les deux). Observez les différences : longueur du résultat, cohérence avec votre projet, qualité du code."

**Mise en commun (5 min)** : deux ou trois groupes présentent leur comparaison à l'oral. Noter au tableau les différences les plus marquantes : est-ce que l'IA a inventé moins de choses ? Est-ce que le code colle mieux au projet ? Est-ce qu'il est plus court / plus long ? Pourquoi ?

L'objectif n'est pas d'écrire le "prompt parfait" — c'est que les étudiants *sentent* dans leur chair que deux prompts qui disent la même chose donnent des résultats radicalement différents selon le contexte fourni.

> **Transition** : "Vous voyez la différence ? Et encore, là on fait ça à la main, prompt par prompt. Dans la suite de la matinée, on va voir comment *structurer* ce contexte avec une méthode : prompts itératifs, spec-driven, rules. Et comment transformer un LLM en véritable agent de développement."

---

*Pause 10h30 – 10h45*

---

<a id="j2-iteratif"></a>
## 10h45 – 11h15 : Le prompt itératif vs le one-shot

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
