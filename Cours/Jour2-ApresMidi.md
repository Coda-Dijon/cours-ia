<a id="j2-agents"></a>
## 13h30 – 14h15 : Du LLM à l'agent — rules, outils, orchestration

> **Note d'organisation** : section déplacée ici depuis le matin du Jour 2 pour accommoder le débrief jour 1 et la notion de contexte en ouverture de matinée.

### Objectif pédagogique
Faire la différence entre un **LLM nu** (une machine à texte) et un **agent** (un LLM qui agit dans un environnement). Comprendre que les rules, les outils et la boucle d'exécution sont les briques qui transforment l'un en l'autre. Donner un aperçu de l'orchestration multi-agents comme direction du métier.

### Découpage (45 min)

- **13h30 – 13h40** · LLM basique vs agent — les briques
- **13h40 – 13h55** · Rules = la mémoire long-terme de l'agent
- **13h55 – 14h10** · Orchestration multi-agents — le futur proche
- **14h10 – 14h15** · Transition vers l'exercice 2

---

### 13h30 – 13h40 · LLM basique vs agent (10 min)

#### Point de départ : un LLM, c'est quoi déjà ?

Jusqu'ici, dans ce cours, on a parlé des LLM comme de grosses machines à texte : `prompt → texte`. Pas d'état, pas d'outils, pas de mémoire entre deux appels. Un LLM "nu", c'est ça. C'est ce qu'il y a dans un chatbot comme ChatGPT en version basique : chaque question est traitée comme un tour de parole isolé, et la seule mémoire, c'est l'historique de la conversation qu'on lui re-fournit à chaque fois.

#### Un agent, c'est un LLM qui agit

Un **agent**, c'est un LLM branché sur trois choses en plus :

1. **Des outils** (tools) — des fonctions qu'il peut appeler : lire un fichier, écrire un fichier, exécuter une commande shell, faire une recherche web, etc.
2. **Une boucle de décision** — il observe le résultat d'une action, décide quoi faire ensuite, et recommence. Observe → décide → agit → re-observe.
3. **Une mémoire** — à court terme (la conversation en cours) et à long terme (des fichiers de rules, des préférences persistées).

Schématiquement :

```
LLM nu       : prompt → texte
Agent        : but → [observe → décide → agit → observe → décide → …] → résultat
```

#### Vous avez déjà utilisé un agent

Question directe aux étudiants : **"Hier après-midi, quand Gemini CLI a lu vos fichiers PHP, modifié votre code et exécuté vos scripts tout seul, c'était encore un chatbot ?"**

Non. C'était un agent. Gemini CLI, Claude Code, Cursor — ce ne sont pas des chatbots habillés en IDE. Ce sont des **agents de code** : des LLM qui ont des outils, une boucle, et accès à votre système de fichiers.

Ce qui a changé en deux ans, ce n'est pas les modèles — c'est qu'on a arrêté de les utiliser comme des chatbots et qu'on a commencé à leur donner les mains.

---

### 13h40 – 13h55 · Rules = la mémoire long-terme de l'agent (15 min)

Si un agent est un LLM avec des outils et une mémoire, alors les **rules** qu'on va voir maintenant, ce n'est pas un "truc en plus" — c'est **la mémoire long-terme de votre agent**. C'est ce qui lui dit qui vous êtes, sur quoi vous travaillez, et comment vous aimez coder, à chaque nouvelle session.

#### Les rules (fichiers de règles)

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

**Démo** : montrer comment créer un fichier `GEMINI.md` à la racine du projet et comment l'IA le prend en compte automatiquement.

#### Les skills et commandes

**Ce que c'est** : des instructions pré-enregistrées pour des tâches récurrentes. Au lieu de retaper le même prompt à chaque fois, on crée un "raccourci" réutilisable.

**Concrètement** : un skill, c'est un fichier texte qui contient un prompt + des instructions. Quand on l'invoque, l'IA reçoit ce contexte automatiquement.

**Exemples de skills qu'on pourrait créer pour notre projet FlashCards** :

- `/review` → "Analyse ce code PHP et liste les problèmes potentiels : bugs, failles de sécurité, conventions non respectées"
- `/spec` → "Génère une spécification technique à partir de cette discussion, au format du template qu'on a vu ce matin"
- `/test` → "Écris des cas de test pour cette fonction en utilisant des assertions PHP simples"

**Le même concept existe chez tous les outils** :

| Outil | Nom du concept | Comment ça marche |
|---|---|---|
| **Gemini CLI** | Skills (`.gemini/skills/`) | Dossier avec un fichier prompt + config, invocable par `/nom_du_skill` |
| **GitHub Copilot CLI** | Skills | Même logique — des commandes personnalisées enregistrées dans la config |
| **Claude Code** | Slash commands (`.claude/commands/`) | Fichier markdown avec le prompt, invocable par `/nom_de_commande` |
| **Cursor** | Custom commands | Prompts personnalisés accessibles depuis la palette de commandes |

#### Le fichier GEMINI.md — le cœur du contexte

Le fichier `GEMINI.md` est le mécanisme principal de Gemini CLI pour donner du contexte persistant à l'IA. Système hiérarchique :

- **Global** : `~/.gemini/GEMINI.md` → instructions par défaut pour TOUS vos projets
- **Projet** : `GEMINI.md` à la racine → instructions spécifiques au projet
- **Sous-dossier** : un `GEMINI.md` dans n'importe quel dossier → instructions ultra-spécifiques

Trois commandes mémoire à connaître :

- `/memory show` → affiche le contexte complet chargé
- `/memory reload` → force le rechargement de tous les fichiers GEMINI.md
- `/memory add <texte>` → ajoute du texte au GEMINI.md global sans quitter la session

> **Équivalents chez les concurrents** : Claude Code utilise `CLAUDE.md`, Cursor utilise `.cursor/rules`, GitHub Copilot utilise `.github/copilot-instructions.md`. Le concept est identique partout.

#### Les outils intégrés (tools) de Gemini CLI

Quand on dit que Gemini CLI est un "agent", c'est parce qu'il a des **outils** qu'il utilise de manière autonome : lecture/écriture de fichiers, exécution de commandes shell, recherche Google (grounding), fetch web. C'est cette combinaison lecture + écriture + exécution qui fait la différence avec un simple chatbot.

---

### 13h55 – 14h10 · Orchestration multi-agents — le futur proche (15 min)

#### Pourquoi un seul agent ne suffit pas

Un agent unique, c'est déjà puissant, mais ça touche vite ses limites :

1. **Le contexte sature.** Plus l'agent lit de fichiers, plus son contexte se remplit.
2. **Pas de spécialisation.** Un agent "touche-à-tout" est moyen partout. Un agent dédié à la sécurité, un autre aux tests, chacun peut être bien meilleur dans son domaine.
3. **Pas de parallélisation.** Un seul agent fait les choses en série.

D'où l'idée de faire tourner **plusieurs agents qui collaborent** sur un même projet.

#### Les patterns d'orchestration

Quelques patterns qu'on voit émerger ([claude.com/blog/multi-agent-coordination-patterns](https://claude.com/blog/multi-agent-coordination-patterns)) :

- **Orchestrateur / workers** — un agent "chef de projet" décompose et dispatche les sous-tâches à des agents "workers" spécialisés.
- **Sub-agents** — l'agent principal "appelle" un sous-agent pour une tâche ciblée, avec un contexte isolé. C'est déjà dans Gemini CLI et Claude Code aujourd'hui.
- **Hand-offs** — un agent passe la main à un autre selon l'étape : spec → dev → reviewer.
- **Parallélisation** — plusieurs agents bossent en parallèle sur des modules indépendants.

#### Exemple illustratif

```
Tâche : "Ajoute le système de répétition espacée aux flashcards."

Orchestrateur décompose :
  ┌─ Agent "analyste"      → lit le code existant, fait un résumé de l'archi
  ├─ Agent "spec"           → écrit une spec métier de la fonctionnalité
  ├─ Agent "dev"            → implémente en suivant la spec et l'archi
  └─ Agent "testeur"        → écrit et exécute les tests
           ↓
  Orchestrateur assemble, vérifie la cohérence, livre le résultat
```

#### Ce que ça veut dire pour votre futur métier

- **Les agents deviennent de plus en plus autonomes.** C'est la trajectoire claire de l'industrie.
- **Le rôle du dev se déplace.** De "celui qui tape le code" vers "celui qui définit les rules, cadre les specs, orchestre les agents, et vérifie les résultats". Vous devenez lead technique d'une équipe d'agents.
- **Les compétences fondamentales ne changent pas.** Comprendre, spécifier, tester, relire — tout ce qu'on apprend dans ce cours reste la base.

#### Les limites — à ne pas cacher

Plus l'agent est autonome, plus il faut vérifier. Les vrais problèmes aujourd'hui : **coût** (chaque agent consomme des tokens), **debugging** (trouver quel agent a merdé dans une chaîne est un casse-tête), **fiabilité** (boucles infinies, décisions absurdes), **coordination** (deux agents qui éditent le même fichier sans se parler).

---

### 14h10 – 14h15 · Transition vers l'exercice 2 (5 min)

Phrase de transition à dire aux étudiants :

> "Vous n'allez plus parler à un chatbot. Vous allez **configurer un agent**. Ses rules, c'est sa mémoire. Sa spec, c'est sa feuille de route. Ses outils, c'est ce qu'il peut faire dans votre projet. Et vous, vous êtes son lead tech. Vous lui dites où aller, vous vérifiez ce qu'il produit, vous le reprenez quand il dérape.
>
> C'est exactement le métier qui vous attend dans 2 ou 3 ans. Autant commencer maintenant."

---

<a id="j2-prep-am"></a>
## 14h15 – 14h30 : Préparation de l'exercice 2

> **Note d'organisation** : phase déplacée ici depuis le matin pour permettre l'intégration du débrief jour 1 et de la notion de contexte en ouverture de matinée.

**Rappel express des consignes** :

Chaque groupe doit, pendant ces 15 minutes :

1. **Créer un fichier de rules** pour leur projet (en s'inspirant de l'exemple vu juste avant).
2. **Appliquer des rules existantes** : piocher dans la collection [github.com/anthropics/skills](https://github.com/anthropics/skills/tree/main/skills) ce qui colle à leur contexte (PHP, qualité de code, testing…).
3. **Ouvrir une session d'échange** avec l'IA pour explorer la fonctionnalité qu'ils veulent ajouter.
4. **Produire une spec** de la fonctionnalité en utilisant le template fourni le matin.

**Fonctionnalités suggérées** (chaque groupe en choisit une) :

- Système de **répétition espacée** (niveaux de maîtrise 0-5, priorisation des cartes urgentes, espacement progressif)
- Système de **statistiques de progression** (taux de réussite par paquet, par carte, évolution dans le temps, récap de session)
- Système d'**import/export** (importer des cartes depuis un fichier texte `question | réponse`, exporter un paquet, gestion des doublons)
- Système de **sessions chronométrées** (temps par carte, limite de temps optionnelle, score bonus si réponse rapide)
- Système de **quiz à choix multiples** (générer des mauvaises réponses à partir des autres cartes du paquet, mixer QCM et réponse libre)

**Ils ne codent PAS encore.** C'est de la préparation pure — on enchaîne immédiatement sur l'exercice.

> **Rôle de l'intervenant** : circuler et aider. Vérifier que les rules sont pertinentes, que les specs sont claires, que les échanges avec l'IA sont constructifs.

---

<a id="j2-exercice2"></a>
## 14h30 – 15h30 : Exercice 2 — Le run "structuré"

### Mise en place

Chaque groupe a maintenant :
- Un fichier de rules ✓
- Une spec écrite ✓
- Un contexte clair ✓

**Présentation du challenge** :

> "Vous allez implémenter la fonctionnalité que vous avez spécifiée ce matin. La méthode est libre, mais vous DEVEZ utiliser vos rules, votre spec, et l'approche itérative. Chaque membre du groupe doit pouvoir expliquer chaque ligne de code produite."

**Critères d'évaluation** (affichés au tableau) :

1. **Le code fonctionne** (pas de bug bloquant)
2. **Le code est cohérent** avec le code de base existant (même structure, même style)
3. **Le code est compris** par tous les membres du groupe
4. **Les prompts** sont structurés et itératifs (pas de one-shot)
5. **La spec est respectée**

### Pendant l'exercice (1h)

**Rôle de l'intervenant** : circuler activement cette fois. Observer et noter :

- Comment les groupes utilisent leurs rules
- La qualité des prompts itératifs
- Comment ils gèrent les erreurs de l'IA (est-ce qu'ils comprennent et corrigent, ou est-ce qu'ils re-promptent aveuglément ?)
- La différence flagrante de qualité avec le jour 1

**Points d'attention** :

- Si un groupe revient au mode "one-shot", les rappeler à l'ordre gentiment.
- Si un groupe a une spec trop vague, les aider à la préciser.
- Encourager la discussion *entre* membres du groupe avant chaque prompt.

---

*Pause 15h30 – 15h45*

---

<a id="j2-workflow"></a>
## 15h45 – 16h15 : Ton workflow réel

### Objectif pédagogique
Les étudiants viennent de vivre le run "structuré". C'est le moment parfait pour leur montrer à quoi ressemble ce même workflow **chez un praticien expérimenté, sur de vrais projets client**. On relie ce qu'ils viennent de faire (rules + spec + itératif sur un petit projet) à ce qu'ils feront en stage ou en job (rules + spec + itératif sur une vraie codebase métier).

### Démo courte — Projet client (10 min)

Montrer (en floutant les infos confidentielles si nécessaire) :

1. **Le fichier de rules** d'un vrai projet — montrer la richesse du contexte donné à l'IA : stack, conventions, patterns, anti-patterns, règles métier.
2. **Une session de spec** — comment une discussion avec l'IA aboutit à un document technique clair qu'on peut relire à froid.
3. **Un prompt de développement** — avec le contexte, les rules, la spec → le code produit.

L'idée est qu'ils voient que ce qu'ils ont fait ce matin à petite échelle, c'est **exactement** ce qui se fait en pro — juste avec plus de volume et des enjeux plus lourds.

### Ce que j'automatise au quotidien — 3 exemples (10 min)

**Exemple 1 : Génération de CRUD**
> "Quand j'ai une nouvelle entité à créer (ex : un système de facturation), l'IA me génère le squelette complet en suivant mes rules : migration, modèle, contrôleur, routes, validation. Je passe de 2h à 15 min — mais je relis tout."

**Exemple 2 : Revue de code**
> "Avant de committer, je fais relire mon diff par l'IA. Elle détecte les incohérences, les oublis de validation, les failles de sécurité basiques. Ça ne remplace pas une vraie revue humaine, mais ça attrape 80% des erreurs bêtes."

**Exemple 3 : Rédaction de tests**
> "J'écris la fonction, je demande à l'IA de générer les tests unitaires. Elle couvre souvent des cas limites auxquels je n'aurais pas pensé. Je vérifie et j'ajuste, mais ça me fait gagner un temps considérable."

### Les tests : le vrai garde-fou (10 min)

Vous n'avez pas encore appris à écrire des tests automatisés — et ce n'est pas le sujet du cours. Mais il faut comprendre dès maintenant **pourquoi les tests deviennent encore plus importants** quand on utilise l'IA pour coder.

#### Le problème fondamental

Quand vous écrivez du code vous-même, ligne par ligne, vous comprenez chaque décision. Si un bug arrive, vous avez une intuition de où chercher parce que vous avez construit le raisonnement.

Quand l'IA écrit du code pour vous, vous recevez un bloc de 50 lignes d'un coup. Même si vous le relisez, vous n'avez pas le même niveau de compréhension que si vous l'aviez écrit. Et c'est là que les bugs se cachent — dans les détails que vous n'avez pas questionnés.

**Sans tests, comment savoir que le code fait ce qu'il prétend faire ?** On ne le sait pas. On fait confiance. Et la confiance, en développement, c'est le meilleur moyen de livrer des bugs.

#### Pourquoi c'est crucial avec l'IA

L'IA fait trois choses qui rendent les tests indispensables :

1. **Elle modifie du code existant sans le vouloir.** Une régression passe inaperçue jusqu'à ce qu'un utilisateur tombe dessus.
2. **Elle gère mal les cas limites.** Code qui marche sur le cas "normal" et qui plante sur les cas rares (liste vide, nombre négatif, fichier manquant).
3. **Elle vous donne confiance à tort.** "A l'air de marcher" ≠ "marche". Les tests transforment une impression en certitude.

#### L'analogie du parachute

L'IA, c'est quelqu'un qui vous a plié votre parachute. Il a l'air compétent, il vous dit que c'est bon. Mais est-ce que vous sautez sans vérifier ? Les tests, c'est la vérification du parachute. On ne saute pas sans.

Plus vous déléguez l'écriture du code à l'IA, plus vous avez besoin de tests pour vérifier le résultat. C'est contre-intuitif : on pourrait croire que l'IA rend les tests moins nécessaires. C'est l'inverse.

### Le message final de la section

L'IA est un multiplicateur, pas un remplaçant. Plus vous êtes compétent, plus l'IA vous est utile. Moins vous êtes compétent, plus elle est dangereuse. Et les tests sont ce qui vous permet de faire confiance au code — qu'il soit écrit par vous, par un collègue, ou par une IA.

---

<a id="j2-symfony"></a>
## 16h15 – 16h45 : Atelier — Explorer une codebase Symfony avec l'IA *(format compressé)*

> **Note d'organisation** : atelier compressé de 1h à 30 min suite au déplacement de "Du LLM à l'agent" et de la "Préparation exercice 2" en début d'après-midi. On garde uniquement la **Phase 1 — Comprendre la codebase** ; la Phase 2 (analyse approfondie par composant) est laissée en ressource pour l'autoformation des étudiants. Si le rythme de la journée le permet, l'intervenant peut basculer sur la version longue.

### Objectif pédagogique
Apprendre à utiliser l'IA pour **comprendre rapidement un projet existant qu'on découvre**, puis y **détecter des axes d'amélioration**. C'est exactement la situation d'un développeur qui arrive sur un projet en entreprise : une codebase inconnue, des milliers de lignes, et il faut être opérationnel vite.

### Pourquoi cet exercice

Jusqu'ici, les étudiants ont travaillé sur *leur* code — un petit projet qu'ils connaissent. En entreprise, le cas le plus courant, c'est l'inverse : on hérite d'un projet écrit par d'autres, souvent mal documenté, et il faut le comprendre pour le faire évoluer.

L'IA est un outil redoutable pour ça — à condition de savoir lui poser les bonnes questions.

### Le projet : Symfony (le framework)

On ne travaille pas sur une petite app de démo — on travaille sur **le code source du framework Symfony lui-même** : [github.com/symfony/symfony](https://github.com/symfony/symfony).

**Pourquoi ce projet** :

- C'est un **vrai projet open-source massif** : ~80 000 commits, 98% PHP, des centaines de fichiers répartis en dizaines de composants
- C'est exactement le genre de codebase intimidante qu'on rencontre en entreprise — impossible à lire fichier par fichier, il *faut* une stratégie
- Les étudiants utilisent Symfony (ou le feront bientôt) — comprendre ses entrailles est un vrai atout professionnel
- C'est le même pour tout le monde → on pourra comparer les approches
- C'est du code de très haute qualité — écrit par des experts, relu par des centaines de contributeurs

**Ce qu'il contient** :

- Des dizaines de **composants** indépendants (HttpFoundation, HttpKernel, Routing, Console, Security, DependencyInjection, EventDispatcher, Form, Validator, Mailer…)
- Des **bundles** (FrameworkBundle, SecurityBundle, TwigBundle…) qui assemblent les composants
- Un système de **Contracts** (interfaces partagées entre composants)
- Des milliers de **tests** PHPUnit
- Une architecture pensée pour la **décorrélation** et la **réutilisabilité**

**Structure principale** :

```
symfony/
├── src/
│   └── Symfony/
│       ├── Bridge/          → Ponts vers des libs tierces (Doctrine, Twig, Monolog…)
│       ├── Bundle/          → Bundles (assemblage de composants pour une app Symfony)
│       │   ├── FrameworkBundle/
│       │   ├── SecurityBundle/
│       │   └── TwigBundle/
│       ├── Component/       → ★ Le cœur : chaque composant est indépendant
│       │   ├── HttpFoundation/   → Request/Response
│       │   ├── HttpKernel/       → Le cycle requête → réponse
│       │   ├── Routing/          → Résolution des routes
│       │   ├── DependencyInjection/  → Le conteneur de services
│       │   ├── Console/          → Commandes CLI
│       │   ├── Security/         → Authentification, autorisation
│       │   ├── EventDispatcher/  → Système d'événements
│       │   └── ... (40+ composants)
│       └── Contracts/       → Interfaces communes entre composants
└── tests/                   → Tests miroir de src/
```

### Mise en place (3 min)

L'intervenant met à disposition le repo (clone rapide sur les postes ou partage réseau / clé USB, idéalement préparé avant le cours) :

```bash
# Cloner le repo (sans installer les dépendances — on veut juste lire le code)
git clone --depth 1 https://github.com/symfony/symfony.git
```

> **Note** : pas besoin d'installer quoi que ce soit. L'objectif est de lire et analyser le code source, pas de l'exécuter. Le `--depth 1` évite de télécharger l'historique complet (80 000 commits).

### Phase 1 — Comprendre la codebase (22 min)

**Consigne** :

> "Vous débarquez en tant que contributeur junior sur le framework Symfony. Votre mission : comprendre comment ce monstre de 40+ composants est organisé, et être capable d'expliquer le cycle de vie d'une requête HTTP. Vous avez ~20 minutes et l'IA comme guide. Vous devez COMPRENDRE ce que l'IA vous explique, pas juste copier sa réponse."

### Mise en commun (5 min)

Tour rapide : chaque groupe restitue en 1 minute **un élément d'architecture qu'il a compris**. L'intervenant relie les morceaux pour montrer la vision d'ensemble.

> **Pour aller plus loin (hors créneau)** : la Phase 2 — Analyse technique approfondie (plonger dans le code d'un composant pour décortiquer les choix d'architecture) est disponible en ressource d'autoformation. Les étudiants les plus curieux peuvent l'enchaîner après le cours en reprenant la méthodologie acquise.

---

<a id="j2-debrief"></a>
## 16h45 – 17h : Débrief final

### La règle à retenir

> **"Jamais une ligne de code que tu ne peux pas expliquer."**

C'est LA phrase du cours. Si les étudiants ne retiennent qu'une chose, c'est celle-ci.

### Récap des apprentissages

**Jour 1** : L'IA est puissante mais pas magique. Sans méthode, elle produit du code qu'on ne maîtrise pas.

**Jour 2** : Avec une méthode (rules, spec, itératif, contexte), l'IA devient un vrai partenaire de développement. Et elle est aussi précieuse pour *comprendre* du code existant que pour en *générer* du nouveau.

### Ce qu'ils repartent avec

1. **Leurs fichiers de rules** — réutilisables sur n'importe quel projet.
2. **Le template de spec** — workflow applicable immédiatement.
3. **L'expérience du contraste** — ils ont *vécu* la différence entre le chaos et la méthode.
4. **Un regard critique** — ils savent maintenant lire et critiquer du code IA.
5. **Le réflexe d'exploration** — ils savent utiliser l'IA pour débarquer sur un projet inconnu.

### Reprise des mots du tour de table (jour 1)

Rappeler les mots que les étudiants avaient donnés en début de cours (magique, flippant, triche…). Leur demander : "Est-ce que votre mot a changé ? Quel mot utiliseriez-vous maintenant ?"

### Questions ouvertes pour finir

- "Qu'est-ce qui vous a le plus surpris ?"
- "Est-ce que vous allez changer votre façon d'utiliser l'IA ?"
- "Quelle est la chose la plus importante que vous avez apprise ?"

---
