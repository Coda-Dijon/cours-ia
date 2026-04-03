<a id="j2-exercice2"></a>
## 13h – 14h15 : Exercice 2 — Le run "structuré"

### Mise en place

**Rappel des consignes (15 min)**

Chaque groupe a maintenant :
- Un fichier de rules ✓
- Une spec écrite ✓
- Un contexte clair ✓
 groupe se voit attribuer un composant à explorer en profondeur (en plus de la vue d'ensemble) :
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

### Phase 2 — Analyse technique approfondie (25 min)

**Consigne** :

> "Vous comprenez maintenant la structure. Passez en mode analyse : plongez dans le code de votre composant et décortiquez les choix d'architecture. Ce n'est pas un audit pour trouver des bugs — c'est du code écrit par des experts. L'objectif est de comprendre POURQUOI ils ont fait ces choix et ce que ça vous apprend."

**Livrable** : un mini-rapport d'analyse avec pour chaque choix d'architecture observé, le pourquoi de ce choix et une leçon à retenir pour leurs propres projets.

### Mise en commun (5 min)

Tour rapide : chaque groupe explique **son composant** aux autres en 1 minute. L'intervenant relie les morceaux pour montrer la vision d'ensemble.

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
