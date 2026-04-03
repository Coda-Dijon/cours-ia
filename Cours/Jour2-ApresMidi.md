<a id="j2-exercice2"></a>
## 13h – 14h15 : Exercice 2 — Le run "structuré"

### Mise en place

**Rappel des consignes (15 min)**

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

*Pause 14h15 – 14h30*

---

<a id="j2-symfony"></a>
## 14h30 – 15h30 : Atelier — Explorer une codebase Symfony avec l'IA

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

### Mise en place (5 min)

L'intervenant clone le repo sur les postes (ou le met à disposition via un partage réseau / clé USB) :

```bash
# Cloner le repo (sans installer les dépendances — on veut juste lire le code)
git clone --depth 1 https://github.com/symfony/symfony.git

# Ou si pas de réseau : fournir un zip pré-téléchargé
```

> **Note** : pas besoin d'installer quoi que ce soit. L'objectif est de lire et analyser le code source, pas de l'exécuter. Le `--depth 1` évite de télécharger l'historique complet (80 000 commits).

### Phase 1 — Comprendre la codebase (25 min)

**Consigne** :

> "Vous débarquez en tant que contributeur junior sur le framework Symfony. Votre mission : comprendre comment ce monstre de 40+ composants est organisé, et être capable d'expliquer le cycle de vie d'une requête HTTP. Vous avez 25 minutes et l'IA comme guide. Mais attention : vous devez COMPRENDRE ce que l'IA vous explique, pas juste copier sa réponse."

**Chaque groupe se voit attribuer un composant à explorer en profondeur** (en plus de la vue d'ensemble) :

- Groupe A : **HttpKernel** — le cœur du framework (cycle requête → réponse)
- Groupe B : **Routing** — comment une URL devient un contrôleur
- Groupe C : **DependencyInjection** — le conteneur de services
- Groupe D : **Security** — authentification et autorisation
- Groupe E : **Console** — le système de commandes CLI
- Groupe F : **EventDispatcher** — le système d'événements

**Démarche guidée** — les étudiants doivent, avec l'aide de l'IA :

1. **Cartographier l'architecture globale** : comprendre l'organisation Component / Bundle / Bridge / Contracts et pourquoi cette séparation
2. **Plonger dans leur composant** : lire les classes principales, comprendre les interfaces clés, identifier les design patterns utilisés
3. **Tracer le parcours d'une requête HTTP** : de l'entrée dans `public/index.php` → Kernel → EventDispatcher → Router → Controller → Response — chaque groupe éclaire la partie qui correspond à son composant
4. **Identifier les design patterns** : observer comment le framework utilise Strategy, Observer, Factory, Decorator, etc. dans du vrai code de production

**Prompts suggérés** (à afficher au tableau) :

```
"Voici l'arborescence du projet Symfony [coller un tree du dossier src/Symfony/].
Explique-moi l'architecture : quelle est la différence entre Component, Bundle,
Bridge et Contracts ? Pourquoi cette organisation ?"

"Voici le fichier src/Symfony/Component/HttpKernel/HttpKernel.php [coller le code].
Explique-moi étape par étape ce qui se passe quand la méthode handle() est appelée.
Quels événements sont dispatchés et dans quel ordre ?"

"Voici le fichier src/Symfony/Component/Routing/Router.php [coller le code].
Comment le Router fait-il pour transformer une URL en contrôleur ?
Quels design patterns sont utilisés ici ?"

"Je vais te montrer plusieurs fichiers du composant [ton composant].
Dessine-moi la chaîne de responsabilité : quelles classes appellent quelles autres,
et dans quel ordre ?"
```

**Livrable** : un document de synthèse (Markdown) qui explique :
- L'architecture globale de Symfony (dans les mots de l'étudiant)
- Le rôle détaillé du composant attribué au groupe
- Un schéma (même textuel) du parcours d'une requête HTTP, en mettant en valeur la partie correspondant à leur composant

### Phase 2 — Analyse technique approfondie (25 min)

**Consigne** :

> "Vous comprenez maintenant la structure. Passez en mode analyse : plongez dans le code de votre composant et décortiquez les choix d'architecture. Ce n'est pas un audit pour trouver des bugs — c'est du code écrit par des experts. L'objectif est de comprendre POURQUOI ils ont fait ces choix et ce que ça vous apprend."

**Chaque groupe analyse son composant sous ces angles** :

- **Design patterns** : quels patterns sont utilisés, pourquoi, et comment ils sont implémentés concrètement (pas la théorie — le vrai code)
- **Extensibilité** : comment le composant est pensé pour être étendu sans être modifié (interfaces, événements, points d'extension)
- **Découplage** : comment le composant reste indépendant des autres — quelles sont ses dépendances, comment utilise-t-il les Contracts
- **Tests** : comment les tests sont organisés, quelles stratégies de test sont employées (mocks, fixtures, tests fonctionnels vs unitaires)
- **Conventions** : nommage, organisation des fichiers, documentation inline — quelles conventions peut-on en tirer pour ses propres projets

**Prompts suggérés** :

```
"Voici les fichiers du composant HttpKernel [coller les principaux].
Quels design patterns sont utilisés ? Pour chacun, montre-moi le code exact
qui l'implémente et explique pourquoi ce pattern a été choisi ici."

"Voici l'interface RouterInterface.php et la classe Router.php [coller].
Pourquoi avoir séparé l'interface du code ? Quels avantages concrets ça apporte
pour quelqu'un qui utilise Symfony dans son projet ?"

"Voici un fichier de test du composant Security [coller].
Analyse la stratégie de test : qu'est-ce qui est testé, comment, et quels cas
limites sont couverts ? Qu'est-ce que ça nous apprend sur la façon d'écrire
de bons tests ?"

"Compare l'organisation du composant Console avec celle du composant Routing.
Quels points communs dans la structure ? Quelles conventions Symfony peut-on
en déduire pour organiser son propre code ?"
```

**Livrable** : un mini-rapport d'analyse avec pour chaque point :
- Le **choix d'architecture** observé (avec référence au code)
- Le **pourquoi** de ce choix (avantage technique concret)
- Une **leçon à retenir** pour leurs propres projets

### Mise en commun (5 min)

Tour rapide : chaque groupe explique **son composant** aux autres en 1 minute. L'objectif : qu'en assemblant les présentations de tous les groupes, tout le monde ait une vision complète du parcours d'une requête dans Symfony.

**L'intervenant relie les morceaux** : "Le groupe A nous a montré comment HttpKernel orchestre tout, le groupe B comment le Routing trouve le bon contrôleur, le groupe C comment le conteneur injecte les dépendances… Vous voyez comment chaque composant fait une seule chose, mais qu'ensemble ils forment un framework complet."

**Points à souligner** :

- Sans l'IA, explorer une codebase de cette taille prendrait des jours. Avec l'IA et les bonnes questions, vous avez compris l'essentiel en 25 minutes — c'est ça le vrai gain de productivité
- Mais attention : l'IA vous a-t-elle parfois donné des explications que vous avez acceptées sans vérifier ? C'est le piège — sur un gros projet, les erreurs subtiles de l'IA sont plus difficiles à repérer
- Les design patterns que vous avez observés (Strategy, Observer, Factory…) ne sont pas de la théorie abstraite — vous venez de voir comment ils sont utilisés dans du vrai code de production qui tourne sur des millions de sites
- Ce workflow (explorer → comprendre → analyser) est exactement ce que vous ferez en arrivant en stage ou en alternance

---

<a id="j2-appliquer"></a>
## 15h30 – 15h50 : Appliquer la méthodologie — Temps libre encadré

### Objectif pédagogique
Laisser les étudiants appliquer librement les outils et la méthodologie sur un sujet de leur choix, pour ancrer les réflexes.

### Consigne

> "Vous avez 20 minutes. Choisissez un des défis ci-dessous et appliquez la méthodologie complète : rules, spec, itératif. C'est du temps pour VOUS — expérimentez."

**Défis au choix** :

1. **Améliorer votre projet de flashcards** : ajoutez une fonctionnalité bonus en suivant le workflow complet (spec → plan → implémentation)
2. **Refactorer du code du jour 1** : reprenez le code "naïf" du jour 1 et refactorez-le proprement avec l'aide de l'IA, en utilisant vos rules
3. **Explorer un autre projet open-source** : prenez un repo GitHub de votre choix et faites-en une analyse rapide comme avec Symfony
4. **Créer un outil CLI** : un petit script PHP qui fait quelque chose d'utile (convertisseur, générateur de mot de passe, tracker...) en partant de zéro avec la méthode

**Rôle de l'intervenant** : disponible pour les questions, observe les réflexes acquis (ou pas), note les bonnes pratiques spontanées.

---

<a id="j2-debrief"></a>
## 15h50 – 16h : Débrief final

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
