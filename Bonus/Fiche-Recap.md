# Fiche récap — L'IA dans le développement

> La règle n°1 : **Jamais une ligne de code que tu ne peux pas expliquer.**

---

## Quand utiliser l'IA (et quand ne pas)

```
                     Tu comprends le sujet
                     OUI                    NON
                 ┌───────────────────┬─────────────────┐
  Tâche          │  IA = accélérateur│  IA = béquille  │
  répétitive     │  FONCEZ           │  DANGEREUX      │
                 ├───────────────────┼─────────────────┤
  Tâche          │  IA = sparring    │  IA = poison    │
  d'apprentissage│  UTILE avec recul │  ÉVITEZ         │
                 └───────────────────┴─────────────────┘
```

**Utilise l'IA pour** : explorer un problème, générer du boilerplate, tester des approches, documenter, relire du code.

**N'utilise PAS l'IA pour** : apprendre un concept fondamental, corriger un bug que tu ne comprends pas, écrire du code critique sans le relire, remplacer la réflexion.

---

## Le workflow en 3 phases

```
1. SPEC MÉTIER          "Qu'est-ce qu'on construit et pourquoi ?"
   → Discuter avec l'IA du besoin côté utilisateur
   → Identifier les règles métier et les cas limites

2. PLAN D'IMPLÉMENTATION   "Comment on traduit ça en code ?"
   → Structures de données, liste des fonctions, ordre des étapes
   → Découpage en phases testables

3. IMPLÉMENTATION PAR PHASES   "On code, morceau par morceau."
   → Une phase à la fois, on TESTE après chaque phase
   → On ne passe à la suite que quand ça marche
```

---

## Les 5 réflexes du bon prompt

1. **Donne du contexte** — le code existant, les conventions, la stack technique.
2. **Sois précis** — "Crée une fonction `calculate_urgency($card)` qui retourne un float" plutôt que "ajoute un score".
3. **Itère** — petit à petit, pas tout d'un coup. Valide chaque étape.
4. **Dis ce que tu ne veux PAS** — pas d'OOP, pas de dépendances externes, pas d'anglais dans les commentaires.
5. **Utilise "pose-moi des questions"** — pour laisser l'IA compléter le contexte manquant.

---

## La checklist de relecture du code IA

Avant de copier du code généré, vérifie :

- [ ] **Fonctions inconnues** — est-ce que toutes les fonctions existent vraiment ? (vérifier sur php.net)
- [ ] **Structures cohérentes** — est-ce que les noms de clés, le style, les conventions sont les mêmes que dans le code existant ?
- [ ] **Pas de complexité inutile** — est-ce que j'ai besoin de tout ça ? L'IA over-engineer souvent.
- [ ] **Cas limites** — que se passe-t-il avec 0, -1, un tableau vide, une entrée invalide ?
- [ ] **Je peux expliquer chaque ligne** — si non, je ne copie pas.

---

## Quand ça plante — le bon réflexe

**Ne fais jamais** : "Ça marche pas, corrige."

**Fais toujours** :
```
Ce que j'attendais : [description du résultat attendu]
Ce qui se passe : [description du résultat obtenu]
Message d'erreur : [copier-coller exact, ou "pas d'erreur"]
Code concerné : [coller la fonction]
```

---

## Les pièges de l'IA à connaître

| Piège                     | Ce qui se passe                                    | Comment s'en protéger                        |
|---------------------------|----------------------------------------------------|----------------------------------------------|
| **Hallucination**         | L'IA invente des fonctions, des packages, des docs | Vérifier sur la doc officielle               |
| **Biais de confirmation** | L'IA dit "oui tout à fait" même quand c'est faux   | Ne pas poser de questions orientées          |
| **Over-engineering**      | L'IA génère de l'OOP avancée pour un besoin simple | Préciser le niveau dans les rules            |
| **Perte de cohérence**    | L'IA change de structure d'un prompt à l'autre     | Donner le contexte à chaque prompt           |
| **Code de tutoriel**      | L'IA reproduit des patterns datés ou simplistes    | Comparer avec les bonnes pratiques actuelles |
| **Failles de sécurité**   | Requêtes SQL sans protection, pas de validation    | Demander "ce code est-il vulnérable ?"       |

---

## Les fichiers de rules — le template minimal

```markdown
# Rules — [Nom du projet]

## Stack technique
- [Langage, version, environnement]
- [Dépendances autorisées]

## Conventions de code
- [Style de nommage]
- [Langue des commentaires]
- [Taille max des fonctions]

## Structure du projet
- [fichier1 : rôle]
- [fichier2 : rôle]

## Structures de données
- [Description des tableaux/variables principales]

## Ce que je ne veux PAS
- [Anti-patterns à éviter]
```

---

## L'IA en une phrase

**L'IA est un développeur intermédiaire.** Elle code vite et connaît la syntaxe. Mais elle ne connaît pas ton projet, elle ne challenge pas tes choix, et elle peut faire des erreurs subtiles. Ton rôle, c'est le lead technique : tu donnes la direction, tu spécifies, tu relis, tu valides.
