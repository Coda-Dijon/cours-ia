# Analyse de cohérence du cours

> Dernière vérification : 3 avril 2026

---

## État général

La structure pédagogique est solide : le Jour 1 fait volontairement vivre le chaos (IA sans méthode), le Jour 2 apporte la méthode et fait refaire le même exercice. Ce contraste avant/après est le cœur du cours. Les timings sont réalistes, les transitions entre blocs sont fluides, et les rappels inter-sessions (mots du tour de table repris en fin de Jour 2, teaser Jour 2 en fin de Jour 1) bouclent bien l'ensemble. L'ordre des sections du Jour 2 matin et le planning de l'Index sont synchronisés.

---

## Problèmes à corriger

### 🔴 Références résiduelles au "jeu de combat" (6 occurrences)

Le projet fil rouge est les FlashCards, mais plusieurs passages font encore référence à l'ancien projet (jeu de combat tour par tour). Chaque occurrence doit être remplacée par un scénario FlashCards.

| Fichier | Ligne | Contenu problématique | Suggestion de remplacement |
|---|---|---|---|
| **Jour1-ApresMidi.md** | ~517 | *"ajoute un système de combat"* | → *"ajoute un système de répétition espacée"* |
| **Jour2-Matin.md** | ~323 | Scénario *"Je veux ajouter de la magie dans le jeu"* | → *"Je veux ajouter un système de statistiques de progression"* |
| **Jour2-Matin.md** | ~211-212 | Template spec : *"Un sort consomme des points de mana"*, *"joueur n'a pas assez de MP"* | → *"Une bonne réponse monte le niveau de maîtrise"*, *"Si toutes les cartes sont au niveau max, proposer une révision aléatoire"* |
| **Jour2-Matin.md** | ~526 | Exemple agent : *"heal_player qui restaure des PV"* | → *"reset_card_level qui remet une carte en révision"* |
| **Jour2-Matin.md** | ~532 | Suite de l'exemple agent : *"Écrit la fonction heal_player dans functions.php"* | → Adapter avec la nouvelle fonction FlashCards |
| **Jour2-Matin.md** | ~548, ~555 | Exemple sub-agents : *"système de magie au jeu"*, *"fonctions de magie"* | → *"système de répétition espacée aux flashcards"*, *"fonctions de répétition espacée"* |

### 🟠 Fichiers manquants référencés dans Index.md

L'Index.md référence 4 fichiers qui n'existent pas dans le dossier Cours :

| Référence dans Index.md | Statut | Action suggérée |
|---|---|---|
| `Base.md` (ligne ~99) | ❌ N'existe pas | Supprimer la référence ou créer le fichier |
| `Exercices-Alternatifs.md` (ligne ~41) | ❌ N'existe pas | Créer le fichier ou retirer la section |
| `Fiche-Recap.md` (ligne ~49) | ❌ N'existe pas | Créer le fichier ou retirer la section |
| `Annexes.md` (ligne ~57) | ❌ N'existe pas | Créer le fichier ou retirer la section |

### 🟠 Lien interne cassé

**Jour1-Matin.md**, ligne ~503 : le lien `(voir [Annexe — Code de base](#annexe-code))` pointe vers une ancre `#annexe-code` qui n'existe dans aucun fichier du cours. Le code de base des FlashCards se trouve dans le dossier `Projet-FlashCards/` à la racine.

### 🟡 Incohérence terminologique "Symfony Demo"

L'Index.md (ligne ~33) parle d'*"Atelier Symfony Demo"*, mais le contenu de Jour2-ApresMidi.md travaille avec le vrai framework Symfony (`github.com/symfony/symfony`), pas l'application Symfony Demo. L'Index devrait dire *"Atelier Symfony"* pour être cohérent avec le contenu.

### 🟡 TODO.md à nettoyer

Le fichier TODO.md contient 3 lignes peu explicites :
- *"Mettre du contexte mutualisé"* — vague, à préciser ou intégrer
- Deux URLs (Mistral environmental standard, MIT Sloan article sur les coûts cachés) — à intégrer dans le cours ou à supprimer

---

## Ce qui a été corrigé (historique)

- ✅ Ancres HTML `j2-sessions` / `j2-specifier` dans Jour2-Matin.md — étaient inversées suite au swap de sections, corrigées le 3 avril 2026
- ✅ Ordre des sections Jour 2 matin dans Index.md — synchronisé avec Jour2-Matin.md (Spécifier → Sessions)
- ✅ Timings — vérifiés et cohérents entre Index.md et tous les fichiers Jour

---

## Vérifications passées avec succès

- ✅ **Timings** : les horaires des sections dans chaque fichier Jour correspondent au planning synthétique de l'Index
- ✅ **Ordre des sections** : Index.md et Jour2-Matin.md sont synchronisés
- ✅ **Ancres HTML** : chaque ancre correspond bien à sa section
- ✅ **Fil rouge FlashCards** : le projet est correctement référencé dans toutes les consignes d'exercice et la majorité du cours (sauf les 6 occurrences "combat" listées ci-dessus)
- ✅ **Progression pédagogique** : Jour 1 chaos → Jour 2 méthode, avec contraste explicite
- ✅ **Section démystification** (vecteurs/statistiques) bien intégrée dans Jour1-Matin.md après les embeddings
