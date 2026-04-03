# Exercices alternatifs

> Ce document regroupe des exercices qui peuvent **remplacer** un des exercices du cours principal (exercice 1 "naïf" ou exercice 2 "structuré"), selon le public, le temps disponible, ou les objectifs pédagogiques visés.

---

## Exercice A — "Archéologue de code" : documenter un projet inconnu avec l'IA

### Résumé

Les étudiants reçoivent un projet PHP open-source volumineux qu'ils n'ont jamais vu. Leur mission : utiliser l'IA pour comprendre le projet, produire une documentation métier structurée, et rédiger une analyse priorisant les axes d'amélioration.

### Objectifs pédagogiques

- Utiliser l'IA comme outil d'**exploration et de compréhension** (pas seulement de génération).
- Apprendre à poser les bonnes questions à l'IA pour cartographier un projet inconnu.
- Produire une documentation métier lisible, en distinguant l'architecture technique du fonctionnement métier.
- Développer un regard critique sur du code existant — identifier les faiblesses, les prioriser, argumenter.
- Comprendre que l'IA peut halluciner sur du code qu'elle ne "voit" pas directement : il faut vérifier.

### Peut remplacer

- **L'exercice 1 (run "naïf")** — si on veut un premier contact avec l'IA orienté compréhension plutôt que génération.
- **L'exercice 2 (run "structuré")** — si les étudiants ont déjà une bonne pratique du prompting et qu'on veut les challenger différemment.

### Durée

1h à 1h30 selon le niveau du groupe.

---

### Projet proposé : PrestaShop

**Pourquoi PrestaShop** :

- Projet PHP open-source majeur (~9 000 fichiers PHP), utilisé en production par des milliers de boutiques.
- Logique métier riche : catalogue produits, panier, commandes, paiement, gestion clients, promotions.
- Architecture réelle avec ses qualités et ses défauts — pas un projet jouet.
- Assez gros pour qu'aucun étudiant ne puisse le lire intégralement, mais assez structuré pour qu'on puisse s'y repérer avec de la méthode.
- En PHP — les étudiants reconnaissent la syntaxe même s'ils n'ont jamais vu un projet de cette taille.

**Dépôt** : https://github.com/PrestaShop/PrestaShop

> **Alternatives possibles** selon le profil du groupe :
> - **Bagisto** (https://github.com/bagisto/bagisto) — e-commerce Laravel, plus moderne, moins massif.
> - **OctoberCMS** (https://github.com/octobercms/october) — CMS sur Laravel, architecture propre mais riche.
> - **Drupal** (https://github.com/drupal/drupal) — CMS très gros, architecture à hooks, plus complexe.

---

### Mise en place

**Avant le cours** :

1. Cloner le dépôt du projet choisi sur les machines des étudiants (ou fournir une archive ZIP).
2. S'assurer que Gemini CLI (ou l'outil utilisé) a accès au dossier du projet.
3. Préparer un document vierge avec le template de livrable (voir plus bas).

**Constitution des groupes** : 2 à 3 étudiants par groupe. Chaque groupe travaille sur le **même projet** mais sur un **périmètre métier différent** (voir répartition ci-dessous).

---

### Consignes données aux étudiants

#### Phase 1 — Cartographie globale (20 min)

> "Vous venez d'arriver en stage dans une entreprise qui utilise ce projet. Personne n'a le temps de vous expliquer le code. Votre mission : comprendre ce que fait ce projet, comment il est organisé, et documenter ça."

Chaque groupe commence par explorer la **structure globale** du projet avec l'IA :

- Quels sont les dossiers principaux ? À quoi servent-ils ?
- Quel framework ou pattern d'architecture est utilisé (MVC, modules, services…) ?
- Où se trouve le point d'entrée de l'application ?
- Quelles sont les dépendances majeures ?

**Prompts suggérés pour démarrer** (à afficher au tableau) :

```
"Voici l'arborescence du projet [coller le tree].
 Donne-moi une vue d'ensemble de l'architecture :
 quels sont les modules principaux et à quoi servent-ils ?"
```

```
"Lis le fichier composer.json et le README.
 Résume en 5 lignes ce que fait ce projet,
 les technologies utilisées, et l'architecture globale."
```

> **Point d'attention** : rappeler aux étudiants de **vérifier** ce que l'IA affirme. Elle peut inventer des modules qui n'existent pas ou mal interpréter la structure. Ouvrir les fichiers pour confirmer.

#### Phase 2 — Plongée dans un périmètre métier (30 min)

Chaque groupe se voit attribuer un périmètre métier à documenter en profondeur :

| Groupe | Périmètre métier | Points d'entrée suggérés |
|--------|-------------------|--------------------------|
| A | **Catalogue produits** | Modèles Product, Category ; controllers associés |
| B | **Panier et commande** | Cart, Order ; le workflow d'achat |
| C | **Gestion clients** | Customer, Address ; authentification |
| D | **Paiement** | Modules de paiement, hooks de validation |
| E | **Promotions et réductions** | CartRule, SpecificPrice ; application des remises |

Pour leur périmètre, les étudiants doivent :

1. **Identifier les classes/fichiers clés** — pas tous les fichiers, mais les 5-10 plus importants.
2. **Comprendre le flux métier** — par exemple pour le panier : comment un produit est ajouté, comment le total est calculé, comment on passe à la commande.
3. **Documenter les relations entre les classes** — qui appelle qui, qui dépend de qui.

**Prompts suggérés** :

```
"Lis le fichier [chemin]. Explique-moi :
 1. Quel est le rôle de cette classe ?
 2. Quelles sont ses méthodes publiques principales ?
 3. Avec quelles autres classes interagit-elle ?"
```

```
"Décris le workflow complet quand un client ajoute
 un produit à son panier jusqu'à la validation de commande.
 Quelles classes interviennent, dans quel ordre ?"
```

#### Phase 3 — Analyse critique et recommandations (20 min)

Maintenant que le groupe comprend son périmètre, il doit porter un regard critique :

1. **Points forts** — qu'est-ce qui est bien fait dans ce code ? (séparation des responsabilités, nommage clair, patterns reconnus…)
2. **Points faibles** — qu'est-ce qui pose problème ? (classes trop longues, couplage fort, code dupliqué, manque de validation, nommage incohérent…)
3. **Priorisation** — parmi les problèmes identifiés, lesquels traiter en priorité et pourquoi ?

**Prompt suggéré** :

```
"En te basant sur les fichiers que tu as lus dans le périmètre [X],
 identifie les 5 principaux problèmes de qualité de code.
 Pour chaque problème :
 - Décris-le concrètement (fichier, ligne, exemple)
 - Explique pourquoi c'est un problème
 - Évalue sa criticité (bloquant / gênant / cosmétique)
 - Propose une piste d'amélioration"
```

> **Point d'attention critique** : l'IA va souvent proposer des "problèmes" génériques (manque de tests, pas assez de commentaires…). Pousser les étudiants à demander des exemples **précis** avec des noms de fichiers et de lignes, puis à **vérifier** que ces exemples existent vraiment.

---

### Livrable attendu

Un fichier **Markdown** structuré selon ce template :

```markdown
# Documentation — [Nom du projet] / [Périmètre métier]

## 1. Vue d'ensemble du projet
- Objectif du projet (en 2-3 phrases)
- Stack technique
- Architecture globale (pattern, organisation des dossiers)

## 2. Périmètre documenté : [nom du périmètre]

### 2.1 Classes et fichiers clés
Pour chaque classe importante :
- **Nom** : [Classe]
- **Fichier** : [chemin]
- **Rôle** : [description en 1-2 phrases]
- **Méthodes principales** : [liste des méthodes publiques clés]
- **Dépendances** : [classes dont elle dépend]

### 2.2 Flux métier principal
Description pas-à-pas du workflow métier principal du périmètre.
(Exemple : "1. Le client clique sur Ajouter au panier →
 2. Le CartController reçoit la requête → 3. ...")

### 2.3 Schéma des relations
Diagramme simplifié (texte ou ASCII) montrant les relations
entre les classes principales du périmètre.

## 3. Analyse critique

### 3.1 Points forts
- [Point fort 1 — avec exemple concret]
- [Point fort 2]

### 3.2 Problèmes identifiés (par ordre de priorité)

#### Problème 1 : [titre]
- **Fichier(s) concerné(s)** : [chemins]
- **Description** : [explication concrète]
- **Impact** : [bloquant / gênant / cosmétique]
- **Piste d'amélioration** : [suggestion]

#### Problème 2 : [titre]
...

## 4. Ce que l'IA a bien fait / mal fait
- Quelles informations l'IA a-t-elle données correctement ?
- Où a-t-elle halluciné ou donné des infos fausses ?
- Quelles questions ont donné les meilleurs résultats ?
```

> La section 4 ("ce que l'IA a bien fait / mal fait") est volontairement incluse : elle force les étudiants à garder un regard critique sur l'outil.

---

### Grille d'évaluation

| Critère | 0 | 1 | 2 | 3 |
|---------|---|---|---|---|
| **Vue d'ensemble** | Absente ou fausse | Vague, erreurs | Correcte mais superficielle | Claire, précise, vérifiée |
| **Classes clés** | Non identifiées | Quelques classes listées sans explication | Classes principales identifiées et décrites | Description complète avec rôles, méthodes, dépendances |
| **Flux métier** | Absent | Incomplet ou incorrect | Flux décrit mais avec des trous | Flux complet, vérifié, cohérent |
| **Analyse critique** | Pas d'analyse | Critiques génériques (copié de l'IA) | Problèmes concrets avec exemples | Problèmes concrets, priorisés, avec pistes argumentées |
| **Vérification de l'IA** | Aucune vérification | A mentionné des vérifications sans les faire | A vérifié quelques affirmations | A systématiquement croisé les infos et documenté les erreurs de l'IA |
| **Qualité des prompts** | Prompts vagues ou copiés-collés | Quelques bons prompts | Prompts ciblés et itératifs | Stratégie de prompting claire, progression logique des questions |

---

### Rôle de l'intervenant pendant l'exercice

**Phase 1** : vérifier que les groupes ne se noient pas dans l'arborescence. Les orienter vers les bons points d'entrée (composer.json, README, dossier src/ ou app/).

**Phase 2** : le moment critique. Passer dans les groupes pour :
- Demander "Comment tu sais que c'est vrai ?" quand un étudiant affirme quelque chose → forcer la vérification.
- Pousser les étudiants qui restent en surface : "OK, tu sais que cette classe gère le panier. Mais *comment* elle calcule le total ? Montre-moi."
- Recadrer les groupes qui partent dans tous les sens : "Concentre-toi sur ton périmètre, pas sur tout le projet."

**Phase 3** : challenger les analyses trop superficielles. "Manque de tests" n'est pas une analyse — "La méthode `calculateTotal()` dans `Cart.php` fait 200 lignes et mélange calcul de prix, application de remises et gestion de TVA" en est une.

---

### Variante : comparaison run naïf / run structuré

Si cet exercice remplace l'exercice 1 (run naïf), on peut le structurer en deux temps :

1. **Première tentative (30 min)** : les étudiants explorent le projet avec l'IA sans méthode. Un gros prompt du type "Explique-moi tout ce projet". Ils notent ce qu'ils obtiennent.
2. **Deuxième tentative (45 min)** : après un débrief collectif sur les limites de l'approche naïve, ils reprennent avec la méthode structurée (phases 1-2-3 ci-dessus).

La comparaison entre les deux livrables parle d'elle-même et rejoint le message central du cours : **la méthode change tout**.

---

### Pourquoi cet exercice est complémentaire aux exercices du cours

Les exercices 1 et 2 du cours principal portent sur la **génération de code** avec l'IA. Cet exercice porte sur la **compréhension de code existant** — une compétence tout aussi essentielle dans le métier, et souvent plus fréquente (on passe plus de temps à lire du code qu'à en écrire).

Il permet aussi d'aborder un angle différent des hallucinations : quand l'IA génère du code, on voit vite si ça marche ou pas. Quand elle *explique* du code, les erreurs sont plus insidieuses — elle peut affirmer avec assurance qu'une classe fait quelque chose qu'elle ne fait pas du tout.

---
---

## Exercice B — "Détective de bugs" : débugger avec l'IA

### Résumé

Les étudiants reçoivent une version "cassée" du projet de jeu RPG — un code qui s'exécute mais qui contient **10 bugs subtils** (pas des erreurs de syntaxe, mais des erreurs de logique). Ils doivent utiliser l'IA pour identifier, comprendre et corriger chaque bug, tout en documentant le processus.

### Objectifs pédagogiques

- Utiliser l'IA comme outil de **diagnostic**, pas seulement de génération.
- Apprendre à formuler un problème observé pour que l'IA puisse aider à le résoudre ("quand je fais X, il se passe Y au lieu de Z").
- Développer le réflexe de **tester après chaque correction** — un fix peut en casser un autre.
- Comprendre que l'IA peut proposer des corrections qui masquent le bug au lieu de le résoudre.
- Renforcer la lecture et la compréhension de code PHP.

### Peut remplacer

- **L'exercice 1 (run "naïf")** — bon premier contact car les étudiants travaillent sur un code qu'ils connaissent déjà (le projet de base), ce qui réduit la charge cognitive.
- **L'exercice 2 (run "structuré")** — si on veut insister sur le debug et la rigueur plutôt que sur l'ajout de fonctionnalités.

### Durée

1h à 1h15.

---

### Préparation par l'intervenant

L'intervenant distribue une version modifiée des trois fichiers du projet de base. Les bugs sont volontairement **subtils** : le code tourne, le jeu se lance, mais des comportements sont incorrects.

#### Les 10 bugs à injecter

Voici les bugs à introduire dans le code de base, classés par difficulté. L'intervenant choisit d'en garder 7 à 10 selon le niveau du groupe.

**Bug 1 — La défense ne marche pas (functions.php)**
```php
// ORIGINAL
$base_damage = max(1, $attacker['atk'] - $defender['def']);

// BUGGÉ — on additionne au lieu de soustraire
$base_damage = max(1, $attacker['atk'] + $defender['def']);
```
*Symptôme* : les monstres et le héros font beaucoup trop de dégâts. La stat DEF est inutile.
*Difficulté* : facile — très visible en jeu.

**Bug 2 — Les coups critiques sont trop fréquents (functions.php)**
```php
// ORIGINAL
if (rand(1, 100) <= 10) {

// BUGGÉ — 10% est devenu 70%
if (rand(1, 100) <= 70) {
```
*Symptôme* : presque chaque coup est critique. Le jeu est chaotique.
*Difficulté* : facile — mais l'étudiant doit lire le code pour le trouver, pas juste demander à l'IA.

**Bug 3 — Le heal entre les étages dépasse max_hp (game.php)**
```php
// ORIGINAL
$hero['hp'] = min($hero['hp'] + $heal, $hero['max_hp']);

// BUGGÉ — le min est remplacé par max
$hero['hp'] = max($hero['hp'] + $heal, $hero['max_hp']);
```
*Symptôme* : le héros a toujours pile ses PV max entre les étages, ni plus ni moins. Subtil car le résultat semble "normal" au premier coup d'œil.
*Difficulté* : moyen — le comportement est plausible.

**Bug 4 — Le scaling des monstres est inversé (data.php)**
```php
// ORIGINAL
$scale = 1 + ($floor - 1) * 0.15;

// BUGGÉ — le scaling diminue au lieu d'augmenter
$scale = 1 - ($floor - 1) * 0.15;
```
*Symptôme* : les monstres deviennent plus faibles à chaque étage. L'étage 5 est trivial.
*Difficulté* : moyen — il faut tester plusieurs étages pour s'en rendre compte.

**Bug 5 — Le monstre attaque même quand il est mort (game.php)**
```php
// ORIGINAL
if ($monster['hp'] > 0) {

// BUGGÉ — condition inversée
if ($monster['hp'] >= 0) {
```
*Symptôme* : quand le monstre tombe à exactement 0 PV, il attaque quand même une dernière fois. Intermittent et frustrant.
*Difficulté* : moyen — ne se produit pas à chaque combat.

**Bug 6 — La réduction de dégâts en défense s'applique à l'envers (game.php)**
```php
// ORIGINAL — on rend la moitié des dégâts au héros
$hero['hp'] += $reduced;

// BUGGÉ — on retire au lieu de rendre
$hero['hp'] -= $reduced;
```
*Symptôme* : défendre fait **plus** de dégâts que ne pas défendre. Le joueur ne comprend pas pourquoi sa défense semble inutile.
*Difficulté* : difficile — le joueur peut croire que la défense est juste mal équilibrée.

**Bug 7 — L'index du monstre est toujours le même (data.php)**
```php
// ORIGINAL
$index = min($floor - 1, count($monsters) - 1);

// BUGGÉ — on utilise $floor au lieu de $floor - 1 et on oublie la protection
$index = $floor;
```
*Symptôme* : à l'étage 1 on se bat contre le Gobelin (index 1 au lieu de 0), et à l'étage 5 on a un dépassement de tableau (erreur PHP ou monstre manquant).
*Difficulté* : difficile — l'erreur se manifeste différemment selon l'étage.

**Bug 8 — La barre de vie affiche n'importe quoi (functions.php)**
```php
// ORIGINAL
$hp_ratio = max(0, $character['hp'] / $character['max_hp']);

// BUGGÉ — division inversée
$hp_ratio = max(0, $character['max_hp'] / $character['hp']);
```
*Symptôme* : la barre de vie est pleine quand le personnage est presque mort, et déborde quand il est à pleine vie (si hp > 1, le ratio > 1). Affichage cassé.
*Difficulté* : facile visuellement, mais identifier la ligne exacte demande de la rigueur.

**Bug 9 — Le choix du personnage est décalé (game.php)**
```php
// ORIGINAL
$choice = intval($choice) - 1;

// BUGGÉ — on ne soustrait pas 1
$choice = intval($choice);
```
*Symptôme* : choisir "1" donne le deuxième personnage, choisir "3" provoque une erreur ou sélectionne le défaut.
*Difficulté* : facile — mais un classique du off-by-one.

**Bug 10 — La variance des dégâts est toujours nulle (functions.php)**
```php
// ORIGINAL
$variance = $base_damage * 0.2;

// BUGGÉ — variance fixée à 0
$variance = $base_damage * 0.0;
```
*Symptôme* : les dégâts sont toujours identiques (hors critiques). Le combat semble "robotique". Très subtil — beaucoup d'étudiants ne le remarqueront pas sans y prêter attention.
*Difficulté* : difficile — le jeu fonctionne, c'est juste ennuyeux.

---

### Consignes données aux étudiants

> "Vous avez reçu une version du jeu RPG qui a été modifiée par un stagiaire un peu trop pressé. Le jeu se lance, mais il contient **10 bugs**. Certains sont évidents, d'autres sont sournois. Votre mission : les trouver tous, les corriger, et documenter votre chasse aux bugs."

#### Étape 1 — Jouer et observer (10 min)

Les étudiants jouent au jeu buggé **sans regarder le code**. Ils notent tout ce qui semble bizarre :

- "Les dégâts sont énormes"
- "La défense ne sert à rien"
- "Le monstre m'a frappé alors qu'il était mort"
- etc.

> **Règle** : noter les **symptômes**, pas les causes. On ne touche pas au code encore.

#### Étape 2 — Diagnostic avec l'IA (30-40 min)

Pour chaque symptôme observé, les étudiants utilisent l'IA pour identifier le bug :

**Approche recommandée** :

1. Décrire le symptôme à l'IA avec le contexte du code.
2. L'IA propose des hypothèses.
3. L'étudiant vérifie dans le code si l'hypothèse est correcte.
4. Si oui → corriger. Si non → reformuler le problème.

**Prompts suggérés** :

```
"Dans ce jeu de combat PHP, quand je choisis 'Défendre',
 je prends PLUS de dégâts au lieu de moins.
 Voici le code de la boucle de combat : [coller le code]
 Où pourrait être le problème ?"
```

```
"Le monstre à l'étage 5 semble plus faible que celui de l'étage 1.
 Voici la fonction generate_monster : [coller]
 Est-ce que le scaling est correct ?"
```

```
"J'ai corrigé le bug X, mais maintenant le bug Y apparaît.
 Voici ce que j'ai changé : [diff].
 Est-ce que ma correction a pu introduire un nouveau problème ?"
```

> **Point d'attention** : l'IA va parfois proposer de réécrire toute une fonction plutôt que de corriger la ligne fautive. Insister : "Montre-moi la ligne exacte qui pose problème et pourquoi."

#### Étape 3 — Vérification croisée (10 min)

Les étudiants rejouent au jeu corrigé et vérifient que :

- Chaque bug identifié est bien corrigé.
- Aucun nouveau bug n'a été introduit.
- Le jeu se comporte normalement du début à la fin.

---

### Livrable attendu

Un fichier **Markdown** — le rapport de chasse aux bugs :

```markdown
# Rapport de debug — RPG Combat

## Bugs trouvés : X / 10

## Bug 1 : [titre court]
- **Symptôme observé** : [ce qu'on voit en jouant]
- **Fichier et ligne** : [emplacement exact]
- **Cause** : [explication technique]
- **Correction** : [le changement effectué]
- **Comment l'IA a aidé** : [ce qu'elle a bien/mal proposé]

## Bug 2 : [titre court]
...

## Bugs non trouvés
[Si certains bugs n'ont pas été identifiés, les lister honnêtement]

## Bilan
- Nombre de bugs trouvés par observation : X
- Nombre de bugs trouvés grâce à l'IA : X
- Nombre de faux positifs de l'IA (bugs qu'elle a "trouvés" mais qui n'existaient pas) : X
- Cas où l'IA a proposé une mauvaise correction : [décrire]
```

---

### Grille d'évaluation

| Critère | 0 | 1 | 2 | 3 |
|---------|---|---|---|---|
| **Bugs trouvés** | 0-2 bugs | 3-5 bugs | 6-8 bugs | 9-10 bugs |
| **Qualité du diagnostic** | Bugs listés sans explication | Symptômes décrits mais causes floues | Causes identifiées avec localisation | Causes précises, expliquées, avec fichier et ligne |
| **Corrections** | Pas de correction ou corrections fausses | Corrections partielles (masquent le bug) | Corrections correctes mais brutales | Corrections minimales et chirurgicales |
| **Utilisation de l'IA** | Copier-coller aveugle des réponses | Quelques échanges avec vérification | Dialogue itératif, vérification systématique | Stratégie claire : observer → décrire → diagnostiquer → corriger → vérifier |
| **Vérification** | Pas de test après correction | A testé le cas principal | A testé plusieurs scénarios | A rejoué le jeu complet et vérifié chaque correction |
| **Honnêteté** | Prétend avoir tout trouvé | A omis les faux positifs | Rapport transparent | Documente aussi les erreurs de l'IA et les fausses pistes |

---

### Rôle de l'intervenant pendant l'exercice

**Étape 1** : s'assurer que les groupes jouent vraiment au jeu et ne sautent pas directement dans le code. L'observation des symptômes est une compétence clé.

**Étape 2** : les pièges à surveiller :
- Un groupe qui demande à l'IA "trouve tous les bugs dans ce code" et copie-colle la réponse → recadrer : "L'IA ne peut pas jouer au jeu. Elle ne voit que le code. Toi tu as vu le symptôme, c'est ton avantage."
- Un groupe qui corrige en réécrivant tout → intervenir : "Tu as changé 15 lignes. Le bug était sur une seule. Quelle ligne exactement ?"
- Un groupe bloqué → donner un indice sous forme de symptôme : "Avez-vous essayé de jouer les 5 étages ? Les monstres vous ont semblé de plus en plus durs ?"

**Étape 3** : vérifier que le jeu fonctionne vraiment. Si un groupe dit "c'est corrigé" mais n'a pas rejoué → "Montre-moi."

---

### Variante : compétition chronométrée

Chaque bug trouvé et correctement corrigé rapporte 1 point. Un bug mal corrigé (fix qui masque au lieu de résoudre) rapporte 0. Le premier groupe à atteindre 8/10 avec un jeu qui tourne correctement gagne. Ça ajoute un peu de pression et d'émulation, ce qui fonctionne bien avec ce type d'exercice.

---

### Pourquoi cet exercice est complémentaire aux exercices du cours

Le debug est l'activité quotidienne n°1 des développeurs. Utiliser l'IA pour débugger est un use case concret et immédiatement utile. Contrairement à la génération de code où le risque est "le code ne marche pas", ici le risque est plus subtil : l'IA peut proposer un fix qui **semble** corriger le problème mais qui introduit un effet de bord. Ça entraîne les étudiants à ne jamais accepter une correction sans la comprendre.

---
---

## Exercice C — "Revue de code" : évaluer et refactorer avec l'IA

### Résumé

Les étudiants reçoivent une version "fonctionnelle mais sale" du projet de jeu — un code qui marche parfaitement mais qui viole toutes les bonnes pratiques : fonctions de 80 lignes, nommage incohérent, code dupliqué, valeurs magiques, absence de validation. Leur mission : produire une revue de code professionnelle avec l'IA, puis refactorer les parties les plus critiques.

### Objectifs pédagogiques

- Comprendre la différence entre "ça marche" et "c'est du bon code".
- Utiliser l'IA pour identifier des problèmes de **qualité** (pas des bugs fonctionnels).
- Apprendre le vocabulaire de la revue de code : couplage, cohésion, dette technique, valeur magique, code smell…
- Prioriser les améliorations : tout ne se refactorise pas en même temps.
- Refactorer **sans casser** — le code doit continuer à fonctionner après chaque modification.

### Peut remplacer

- **L'exercice 2 (run "structuré")** — si les étudiants ont déjà codé avec l'IA et qu'on veut travailler sur la qualité plutôt que sur l'ajout de fonctionnalités.

### Durée

1h15 à 1h30.

---

### Préparation par l'intervenant

L'intervenant distribue une version "sale mais fonctionnelle" du projet. Le code fait la même chose que le code de base, mais il est écrit de manière délibérément mauvaise. Voici le code à distribuer.

#### Fichier `game_dirty.php`

```php
<?php
require_once 'f.php';
require_once 'd.php';

// Tout le jeu
echo "\033[2J\033[H";
echo "╔══════════════════════════════════════╗\n";
echo "║        ⚔  RPG COMBAT  ⚔             ║\n";
echo "║      Combat tour par tour            ║\n";
echo "╚══════════════════════════════════════╝\n\n";

echo "Choisissez votre personnage :\n\n";
echo "1. Guerrier (PV: 120 | ATK: 18 | DEF: 12)\n";
echo "2. Mage (PV: 80 | ATK: 22 | DEF: 6)\n";
echo "3. Voleur (PV: 90 | ATK: 20 | DEF: 8)\n";

echo "\nVotre choix (1-3) : ";
$c = trim(fgets(STDIN));

if ($c == 1) { $n = 'Guerrier'; $hp = 120; $a = 18; $d = 12; }
elseif ($c == 2) { $n = 'Mage'; $hp = 80; $a = 22; $d = 6; }
elseif ($c == 3) { $n = 'Voleur'; $hp = 90; $a = 20; $d = 8; }
else { $n = 'Guerrier'; $hp = 120; $a = 18; $d = 12; }

$mhp = $hp;

echo "\nVous incarnez $n !\n";
echo "Préparez-vous au combat...\n\n";
echo "\nAppuyez sur Entrée pour continuer...";
trim(fgets(STDIN));

$f = 1;
$go = false;

while (!$go && $f <= 5) {
    echo "\033[2J\033[H";
    echo "=== ÉTAGE $f / 5 ===\n\n";

    // Monstre
    if ($f == 1) { $mn = 'Slime'; $mhp2 = 30; $ma = 6; $md = 2; }
    if ($f == 2) { $mn = 'Gobelin'; $mhp2 = 45; $ma = 9; $md = 4; }
    if ($f == 3) { $mn = 'Squelette'; $mhp2 = 55; $ma = 12; $md = 6; }
    if ($f == 4) { $mn = 'Orc'; $mhp2 = 70; $ma = 14; $md = 8; }
    if ($f == 5) { $mn = 'Dragon'; $mhp2 = 100; $ma = 20; $md = 10; }

    $s = 1 + ($f - 1) * 0.15;
    $mhp2 = intval($mhp2 * $s);
    $ma = intval($ma * $s);
    $md = intval($md * $s);
    $mmhp2 = $mhp2;

    echo "Un $mn apparaît !\n\n";

    $co = false;
    while (!$co) {
        // Affichage héros
        $r1 = max(0, $hp / $mhp);
        $f1 = intval($r1 * 20);
        $e1 = 20 - $f1;
        echo "  " . str_pad($n, 15) . "  [" . str_repeat('█', $f1) . str_repeat('░', $e1) . "] " . max(0, $hp) . "/$mhp PV\n";

        // Affichage monstre
        $r2 = max(0, $mhp2 / $mmhp2);
        $f2 = intval($r2 * 20);
        $e2 = 20 - $f2;
        echo "  " . str_pad($mn, 15) . "  [" . str_repeat('█', $f2) . str_repeat('░', $e2) . "] " . max(0, $mhp2) . "/$mmhp2 PV\n";

        echo "\n";
        echo "Actions :\n";
        echo "1. Attaquer\n";
        echo "2. Défendre\n";
        echo "\nQue faites-vous ? ";
        $act = trim(fgets(STDIN));

        $def = false;

        if ($act == '1') {
            // Attaque du héros
            $dmg = max(1, $a - $md);
            $v = $dmg * 0.2;
            $dmg = rand(max(1, intval($dmg - $v)), max(1, intval($dmg + $v)));
            if (rand(1, 100) <= 10) { $dmg *= 2; echo "\n★ COUP CRITIQUE ! "; }
            $mhp2 -= $dmg;
            echo "\n$n inflige $dmg dégâts à $mn.\n";
        } elseif ($act == '2') {
            $def = true;
            echo "\nVous adoptez une posture défensive !\n";
        } else {
            echo "\nAction invalide !\n";
            continue;
        }

        // Tour du monstre
        if ($mhp2 > 0) {
            $dmg2 = max(1, $ma - $d);
            $v2 = $dmg2 * 0.2;
            $dmg2 = rand(max(1, intval($dmg2 - $v2)), max(1, intval($dmg2 + $v2)));
            if (rand(1, 100) <= 10) { $dmg2 *= 2; }
            $hp -= $dmg2;
            if ($def) {
                $red = intval($dmg2 / 2);
                $hp += $red;
                echo "$mn inflige $dmg2 dégâts à $n. (Défense : -$red dégâts)\n";
            } else {
                echo "$mn inflige $dmg2 dégâts à $n.\n";
            }
        }

        if ($mhp2 <= 0) {
            echo "\n★ $mn est vaincu !\n";
            $co = true;
            $heal = intval($mhp * 0.3);
            $hp = min($hp + $heal, $mhp);
            echo "Vous récupérez $heal PV.\n";
        } elseif ($hp <= 0) {
            $go = true;
            $co = true;
            echo "\n✖ Vous avez été vaincu par $mn...\n";
        }

        if (!$co) {
            echo "\nAppuyez sur Entrée pour continuer...";
            trim(fgets(STDIN));
        }
    }

    if (!$go) {
        $f++;
        if ($f <= 5) {
            echo "\nVous montez à l'étage suivant...\n";
            echo "\nAppuyez sur Entrée pour continuer...";
            trim(fgets(STDIN));
        }
    }
}

echo "\n";
if (!$go) {
    echo "╔══════════════════════════════════════╗\n";
    echo "║    VICTOIRE ! Vous avez survécu      ║\n";
    echo "║    aux 5 étages du donjon !          ║\n";
    echo "╚══════════════════════════════════════╝\n";
} else {
    echo "╔══════════════════════════════════════╗\n";
    echo "║         GAME OVER                    ║\n";
    echo "║   Vous êtes tombé à l'étage $f.       ║\n";
    echo "╚══════════════════════════════════════╝\n";
}
echo "\nMerci d'avoir joué !\n";
```

> **Note** : ce fichier unique regroupe TOUT le jeu. Il n'y a plus de séparation en fichiers, plus de fonctions, plus de structure. Les fichiers `f.php` et `d.php` sont vides (ils existent pour ne pas provoquer d'erreur de require).

**Inventaire des problèmes volontairement injectés** (pour l'intervenant) :

1. **Tout dans un seul fichier** — aucune séparation des responsabilités.
2. **Pas de fonctions** — tout est procédural et linéaire.
3. **Nommage cryptique** — `$c`, `$n`, `$a`, `$d`, `$f`, `$co`, `$go`, `$mn`, `$mhp2`, `$mmhp2`…
4. **Valeurs magiques** — `5`, `20`, `0.3`, `0.15`, `0.2`, `10` (le % de critique) apparaissent en dur dans le code sans explication.
5. **Données en dur** — les personnages et les monstres sont codés directement dans le flux, pas dans une structure de données.
6. **Code dupliqué** — l'affichage de la barre de vie est copié-collé deux fois (héros et monstre), le calcul d'attaque est dupliqué.
7. **Pas de validation robuste** — le `else` du choix de personnage assigne silencieusement le Guerrier.
8. **Chaîne de `if` au lieu d'un tableau** — la sélection du monstre par étage utilise 5 `if` séparés.
9. **Mélange logique/affichage** — le calcul de dégâts et l'affichage sont entrelacés.
10. **Fichiers importés vides** — `f.php` et `d.php` sont requis mais ne contiennent rien.
11. **Pas de docblocks, pas de commentaires utiles** — le seul commentaire est "Tout le jeu".
12. **Constantes absentes** — `MAX_FLOORS`, `CRITICAL_CHANCE`, `HEAL_RATIO` etc. devraient exister.

---

### Consignes données aux étudiants

> "Vous venez de rejoindre une équipe. Le développeur précédent a quitté l'entreprise en laissant ce code. Le jeu fonctionne (vous pouvez le vérifier), mais le code est inmaintenable. Votre chef vous demande deux choses : une revue de code documentée, puis un refactoring des points les plus critiques."

#### Phase 1 — Jouer et confirmer (5 min)

Les étudiants lancent le jeu pour vérifier qu'il fonctionne. Ça leur prouve que "ça marche" ne veut pas dire "c'est bien".

#### Phase 2 — Revue de code avec l'IA (25-30 min)

Les étudiants soumettent le code à l'IA et lui demandent une revue structurée.

**Prompt de départ suggéré** :

```
"Voici le code d'un jeu de combat en PHP. Il fonctionne correctement.
 Fais-moi une revue de code professionnelle :
 - Liste les problèmes de qualité par catégorie
   (nommage, structure, duplication, maintenabilité, etc.)
 - Pour chaque problème, donne un exemple concret avec la ligne
 - Évalue la gravité (critique / important / mineur)
 - Propose une solution"
```

**Travail attendu** : les étudiants ne se contentent pas de copier la sortie de l'IA. Ils doivent :

1. **Vérifier** chaque problème identifié — l'IA dit "nommage cryptique" ? Lister concrètement quelles variables sont mal nommées et proposer un meilleur nom.
2. **Prioriser** — parmi tous les problèmes, lesquels empêchent concrètement de faire évoluer le code ? Ce sont ceux-là qu'on traite en premier.
3. **Catégoriser** — regrouper les problèmes (structure, nommage, duplication, configuration…).

> **Point d'attention** : l'IA va probablement lister 20+ problèmes. Le vrai travail, c'est la priorisation. "Si tu ne pouvais corriger que 3 choses, lesquelles ?" — c'est la question qui distingue un développeur junior d'un développeur senior.

#### Phase 3 — Refactoring guidé (30-40 min)

Chaque groupe choisit les **3 problèmes les plus critiques** de sa revue et les corrige avec l'aide de l'IA.

**Règle absolue** : après chaque modification, le jeu doit **toujours fonctionner**. On refactorise pas-à-pas, pas d'un coup.

**Approche recommandée** :

```
Étape 1 : "Renomme toutes les variables avec des noms explicites.
           Ne change RIEN d'autre. Le comportement doit être identique."

Étape 2 : "Extrais le calcul d'attaque dans une fonction attack().
           Montre-moi la signature et le code."

Étape 3 : "Maintenant, sépare les données (personnages, monstres)
           dans un fichier data.php avec des fonctions dédiées."
```

> **Point d'attention critique** : l'IA va vouloir tout refactorer d'un coup. Insister sur l'approche incrémentale. Un refactoring qui casse le jeu est pire que le code sale.

---

### Livrable attendu

Un fichier **Markdown** — la revue de code et le plan de refactoring :

```markdown
# Revue de code — RPG Combat (version "sale")

## 1. Résumé exécutif
[En 3 phrases : état du code, risques principaux, priorités]

## 2. Problèmes identifiés

### Catégorie : Structure et organisation
#### Problème : [titre]
- **Gravité** : critique / important / mineur
- **Exemple** : [ligne(s) concernée(s)]
- **Pourquoi c'est un problème** : [explication]
- **Solution proposée** : [approche]

### Catégorie : Nommage
...

### Catégorie : Duplication
...

## 3. Priorisation
Les 3 problèmes à traiter en premier :
1. [Problème] — parce que [justification]
2. [Problème] — parce que [justification]
3. [Problème] — parce que [justification]

## 4. Refactoring effectué
Pour chaque modification réalisée :
- **Avant** : [extrait du code original]
- **Après** : [extrait du code refactorisé]
- **Test** : le jeu fonctionne toujours ? [oui/non + détails]

## 5. Bilan IA
- L'IA a-t-elle identifié les bons problèmes ?
- A-t-elle manqué quelque chose d'évident ?
- Ses propositions de refactoring étaient-elles applicables directement ?
```

---

### Grille d'évaluation

| Critère | 0 | 1 | 2 | 3 |
|---------|---|---|---|---|
| **Identification des problèmes** | Peu ou pas de problèmes identifiés | Liste copiée de l'IA sans vérification | Problèmes identifiés, vérifiés, illustrés | Problèmes catégorisés, illustrés, avec impact expliqué |
| **Priorisation** | Pas de priorisation | Priorités arbitraires | Priorités justifiées | Priorisation argumentée avec impact sur la maintenabilité |
| **Qualité du refactoring** | Pas de refactoring ou code cassé | Refactoring partiel, jeu cassé | 1-2 refactorings fonctionnels | 3+ refactorings propres, jeu intact, code amélioré |
| **Approche incrémentale** | Tout modifié d'un coup | Modifications par gros blocs | Étapes identifiables | Chaque modification est isolée, testée, documentée |
| **Vocabulaire technique** | Pas de vocabulaire spécifique | Quelques termes ("c'est moche") | Utilise le bon vocabulaire (couplage, cohésion, DRY…) | Vocabulaire précis et bien employé dans le contexte |
| **Regard critique sur l'IA** | Aucun recul | Mentionne que l'IA a aidé | Compare propositions IA vs réalité | Documente les limites de l'IA dans l'exercice |

---

### Rôle de l'intervenant pendant l'exercice

**Phase 2** : c'est là que l'intervenant apporte le plus de valeur. Introduire le vocabulaire quand les étudiants décrivent un problème sans le nommer :
- "Ce que tu décris, ça s'appelle le *principe DRY* — Don't Repeat Yourself."
- "Quand tout est dans un seul fichier, on parle de manque de *séparation des responsabilités* ou *separation of concerns*."
- "Une variable qui s'appelle `$a`, c'est ce qu'on appelle un *code smell* — un signe que quelque chose ne va pas."

**Phase 3** : surveiller que le refactoring reste incrémental. Un groupe qui dit "on a tout réécrit" a probablement perdu le fil — vérifier que le jeu tourne encore.

---

### Pourquoi cet exercice est complémentaire aux exercices du cours

Les exercices 1 et 2 partent d'un code propre pour y ajouter des fonctionnalités. Cet exercice part d'un code sale pour l'améliorer. C'est une situation ultra-fréquente en entreprise — on hérite de code legacy et on doit le maintenir. L'IA est un excellent compagnon de refactoring, mais elle peut aussi proposer des transformations trop ambitieuses qui cassent tout. L'exercice enseigne la discipline du changement progressif.

---
---

## Exercice D — "Traducteur de langages" : migrer du code avec l'IA

### Résumé

Les étudiants prennent le code de base du projet RPG (en PHP) et doivent le porter dans un **autre langage** (Python ou JavaScript/Node.js) en utilisant l'IA. Ils découvrent que la traduction de code n'est pas un simple remplacement syntaxique : chaque langage a ses idiomes, ses structures de données préférées, et ses conventions.

### Objectifs pédagogiques

- Comprendre que l'IA peut traduire du code entre langages, mais que le résultat n'est pas du code **idiomatique** sans guidage.
- Découvrir un nouveau langage par contraste avec PHP — les étudiants apprennent Python ou JS "par le code", pas par un cours théorique.
- Développer le sens critique : la traduction littérale (PHP → Python ligne à ligne) produit du code qui marche mais qui ne ressemble pas à ce qu'un développeur Python écrirait.
- Apprendre à spécifier des contraintes idiomatiques dans les prompts ("écris ça de manière pythonique").

### Peut remplacer

- **L'exercice 2 (run "structuré")** — si les étudiants maîtrisent déjà bien le prompting et qu'on veut élargir leur horizon technique.

### Durée

1h15 à 1h30.

---

### Mise en place

**Prérequis** : Python 3 ou Node.js installé sur les machines des étudiants.

**Choix du langage cible** : l'intervenant peut soit imposer un langage unique (plus simple pour le débrief collectif), soit laisser choisir (plus de richesse dans la comparaison).

| Langage cible | Avantages pour l'exercice | Difficultés |
|---|---|---|
| **Python** | Syntaxe très différente de PHP, écosystème riche, idiomes forts (listes en compréhension, f-strings, dictionnaires) | Les étudiants ne connaissent pas Python → l'IA fait tout ? |
| **JavaScript (Node.js)** | Plus proche de PHP en syntaxe, readline pour le CLI, utile pour leur carrière | Moins de contraste → moins de découvertes |

> **Recommandation** : Python, car le contraste est plus riche et les idiomes sont très différents de PHP. Ça crée plus de moments "ah, on peut faire ça autrement".

---

### Consignes données aux étudiants

> "Votre client veut migrer son jeu RPG de PHP vers [Python/JavaScript]. Le jeu doit fonctionner exactement pareil — même gameplay, même affichage, mêmes règles. Mais le code doit être écrit dans le style du nouveau langage, pas juste une traduction mot-à-mot."

#### Phase 1 — Traduction naïve (20 min)

Les étudiants demandent à l'IA de traduire le code tel quel.

**Prompt de départ** :

```
"Traduis ce code PHP en Python. Le programme doit fonctionner
 exactement de la même manière (jeu de combat en CLI).
 Voici le fichier functions.php : [coller]
 Voici le fichier data.php : [coller]
 Voici le fichier game.php : [coller]"
```

Le résultat va probablement :
- Fonctionner (l'IA est plutôt bonne pour ça).
- Ressembler à du "PHP écrit en Python" — pas idiomatique.
- Utiliser des patterns PHP dans un contexte Python (ex : `intval()` → `int()`, mais aussi des structures de données non-pythoniques).

**Les étudiants testent** : est-ce que le jeu tourne ? Est-ce qu'il se comporte comme l'original ?

#### Phase 2 — Analyse des différences (20 min)

Maintenant, les étudiants analysent la traduction avec un regard critique :

**Prompts suggérés** :

```
"Voici le code Python que tu viens de générer.
 Est-ce du code idiomatique Python, ou est-ce
 du 'PHP traduit en Python' ?
 Montre-moi les endroits où un développeur Python
 ferait les choses différemment."
```

```
"En PHP, on utilise des tableaux associatifs pour tout.
 En Python, quelles structures de données seraient
 plus appropriées pour représenter un personnage ?
 Un dictionnaire ? Une dataclass ? Un namedtuple ?
 Explique les avantages de chaque approche."
```

```
"Compare la gestion de la saisie utilisateur
 en PHP (fgets/STDIN) et en Python (input()).
 Y a-t-il des différences de comportement à gérer ?"
```

**Ce que les étudiants doivent identifier** :

| Aspect | PHP (original) | Python (idiomatique) |
|--------|---------------|---------------------|
| Structure de données | Tableaux associatifs | Dictionnaires, dataclasses, ou namedtuples |
| Affichage formaté | Concaténation de strings | f-strings |
| Boucle sur un tableau | `foreach ($arr as $i => $v)` | `for i, v in enumerate(arr)` |
| Valeur max/min | `max()`, `min()` | `max()`, `min()` (identique !) |
| Hasard | `rand(1, 100)` | `random.randint(1, 100)` |
| Lecture clavier | `fgets(STDIN)` | `input()` |
| Clear screen | `echo "\033[2J\033[H"` | `os.system('clear')` ou ANSI |
| Typage | Dynamique faible | Dynamique fort (pas de cast implicite) |

#### Phase 3 — Réécriture idiomatique (30-40 min)

Les étudiants reprennent leur traduction et l'améliorent pour la rendre **idiomatique** :

**Approche recommandée** : fichier par fichier, pas tout d'un coup.

```
"Réécris data.py de manière idiomatique Python.
 Utilise des dataclasses pour les personnages et les monstres
 au lieu de dictionnaires.
 Garde exactement les mêmes valeurs et le même comportement."
```

```
"Maintenant réécris functions.py. Utilise des type hints,
 des f-strings, et la convention de nommage Python (snake_case
 — ah tiens, c'est pareil qu'en PHP ici).
 Assure-toi que chaque fonction a un docstring."
```

```
"Enfin, réécris game.py. Sépare la boucle de jeu
 dans une fonction main() et utilise if __name__ == '__main__'.
 Pourquoi les développeurs Python font-ils ça ?"
```

> **Point d'attention** : l'IA va proposer des choses que les étudiants ne connaissent pas (dataclasses, type hints, list comprehensions…). C'est voulu — ça ouvre des portes. Mais il faut qu'ils **comprennent** ce qu'elle propose, pas juste qu'ils copient.

---

### Livrable attendu

Deux choses :

**1. Le code traduit et fonctionnel** — le jeu complet dans le nouveau langage, qui tourne et se comporte comme l'original.

**2. Un fichier Markdown** — le journal de migration :

```markdown
# Journal de migration — RPG Combat (PHP → Python)

## 1. Traduction naïve
- Le code a-t-il fonctionné du premier coup ? [oui/non]
- Problèmes rencontrés : [liste]
- Temps de l'IA pour traduire : [estimation]

## 2. Différences PHP / Python identifiées

### Structures de données
- PHP : [comment c'est fait]
- Python : [comment ça devrait être fait et pourquoi]

### Conventions de code
- [Différence 1]
- [Différence 2]

### Gestion des entrées/sorties
- [Différences observées]

## 3. Réécriture idiomatique
Pour chaque fichier modifié :
- **Changement principal** : [description]
- **Avant** : [extrait PHP-style Python]
- **Après** : [extrait idiomatique]
- **Pourquoi c'est mieux** : [explication]

## 4. Ce que j'ai appris sur Python
- [3-5 concepts ou idiomes Python découverts pendant l'exercice]

## 5. Bilan IA
- La traduction naïve était-elle utilisable ?
- Qu'est-ce que l'IA a bien géré dans la traduction ?
- Où a-t-elle produit du code non-idiomatique ?
- A-t-elle introduit des bugs pendant la traduction ?
```

---

### Grille d'évaluation

| Critère | 0 | 1 | 2 | 3 |
|---------|---|---|---|---|
| **Code fonctionnel** | Ne tourne pas | Bugs majeurs | Quelques bugs mineurs | Jeu complet, fonctionnel, comportement identique |
| **Idiomaticité** | Traduction littérale brute | Quelques éléments idiomatiques | Code majoritairement idiomatique | Code qu'un développeur Python validerait en revue |
| **Compréhension** | Aucun membre ne peut expliquer le code Python | Explication superficielle | Un membre explique les choix | Tous les membres comprennent les idiomes utilisés |
| **Analyse des différences** | Pas d'analyse | "PHP et Python c'est différent" | Différences concrètes identifiées et illustrées | Analyse approfondie avec exemples, avantages/inconvénients |
| **Qualité des prompts** | Un seul prompt "traduis tout" | Quelques prompts séparés | Approche fichier par fichier, itérative | Prompts précis avec contraintes idiomatiques |
| **Apprentissage** | Rien appris sur le nouveau langage | 1-2 notions mentionnées | Concepts clés identifiés et compris | Découvertes documentées avec enthousiasme et précision |

---

### Rôle de l'intervenant pendant l'exercice

**Phase 1** : aider si la traduction naïve ne tourne pas (problèmes d'environnement Python, modules manquants…). L'objectif n'est pas de bloquer sur l'installation.

**Phase 2** : le moment le plus riche pédagogiquement. Faire le tour des groupes et poser des questions :
- "L'IA a traduit ton tableau associatif PHP en dictionnaire Python. C'est OK, mais un développeur Python pourrait utiliser quoi d'autre ?" (→ dataclass)
- "Pourquoi l'IA a gardé `intval()` sous forme de `int()` ? Est-ce que Python en a vraiment besoin ici ?" (→ typage dynamique fort)
- "Regarde comment l'IA a traduit `echo`. Est-ce que `print()` se comporte exactement pareil ?" (→ retour à la ligne automatique)

**Phase 3** : vérifier que les étudiants ne se contentent pas de demander à l'IA "rends ça idiomatique" et de copier. Demander : "Explique-moi ce que fait `@dataclass` et pourquoi c'est mieux qu'un dictionnaire ici."

---

### Variante : traduction croisée

Si le groupe est avancé, on peut faire traduire le même code dans **deux langages différents** par deux sous-groupes, puis comparer :
- Groupe A traduit en Python, Groupe B traduit en JavaScript.
- Ils comparent leurs résultats : quel langage a été le plus facile à traduire ? Pourquoi ?
- Ça ouvre une discussion sur les familles de langages et les paradigmes.

---

### Pourquoi cet exercice est complémentaire aux exercices du cours

La migration de code est un use case réel de l'IA en entreprise — et c'est aussi un piège classique. L'IA traduit vite, mais elle produit souvent du code "accent étranger" : syntaxiquement correct dans le nouveau langage, mais écrit avec les réflexes de l'ancien. Cet exercice enseigne aux étudiants que **la traduction n'est pas la compréhension**, et qu'il faut guider l'IA vers les idiomes du langage cible. C'est aussi une manière détournée et motivante de découvrir un nouveau langage.
