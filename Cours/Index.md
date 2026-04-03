# L'IA dans le développement — Cours complet (2 jours)

> **Public** : étudiants de 1ʳᵉ année en école supérieure, bases PHP acquises (variables, fonctions, boucles, conditions).
> **Outil principal** : Gemini CLI (les principes s'appliquent à Claude Code, GitHub Copilot, Cursor, etc.).
> **Projet fil rouge** : un outil de flashcards (type Anki simplifié) en PHP CLI.

---

## Structure du cours

Le cours est découpé en **4 demi-journées** + un fichier d'annexes. Chaque fichier est autonome et contient tout le déroulé détaillé de la demi-journée correspondante.

---

### Jour 1 — Comprendre l'IA et se confronter à ses limites

**Objectif** : les étudiants découvrent concrètement ce qu'une IA générative peut (et ne peut pas) faire en développement. Ils produisent du code avec l'IA sans méthode, puis analysent ensemble les problèmes.

| Demi-journée | Fichier | Contenu |
|---|---|---|
| **Matin (9h-12h)** | [Jour1-Matin.md](Jour1-Matin.md) | Introduction & tour de table, fonctionnement des LLM (tokens, embeddings, entraînement), prise en main de Gemini CLI, **Exercice 1 : le run "naïf"** (améliorer l'outil de flashcards sans méthode) |
| **Après-midi (13h-16h)** | [Jour1-ApresMidi.md](Jour1-ApresMidi.md) | Analyse collective des résultats, limites & enjeux éthiques de l'IA, quand ne PAS utiliser l'IA, le métier qui change, la notion de contexte, débrief jour 1 |

---

### Jour 2 — Structurer, itérer et maîtriser

**Objectif** : les étudiants apprennent à utiliser l'IA de manière méthodique. Ils découvrent le prompt itératif, les fichiers de règles, la spécification assistée et les agents. Ils refont le même exercice et constatent l'écart de qualité.

| Demi-journée | Fichier | Contenu |
|---|---|---|
| **Matin (9h-12h)** | [Jour2-Matin.md](Jour2-Matin.md) | Prompt itératif vs one-shot, spécifier avant de développer, sessions d'échange avec l'IA, panorama des agents IA (Gemini CLI, Claude Code, Cursor...), GEMINI.md & memory, outils/sandbox/MCP, agents & orchestration, workflow réel + tests comme garde-fou, préparation de l'exercice 2 |
| **Après-midi (13h-16h)** | [Jour2-ApresMidi.md](Jour2-ApresMidi.md) | **Exercice 2 : le run "structuré"**, **atelier Symfony Demo** (explorer & auditer une codebase existante avec l'IA), temps libre encadré, débrief final |

---

### Exercices alternatifs

| Fichier | Contenu |
|---|---|
| [Exercices-Alternatifs.md](Exercices-Alternatifs.md) | 4 exercices pouvant remplacer les exercices 1 ou 2 : **A. Archéologue de code** (documenter un projet open-source inconnu), **B. Détective de bugs** (trouver 10 bugs subtils), **C. Revue de code** (évaluer et refactorer du code sale), **D. Traducteur de langages** (migrer le jeu PHP vers Python) |

---

### Fiche récap (à distribuer)

| Fichier | Contenu |
|---|---|
| [Fiche-Recap.md](Fiche-Recap.md) | Fiche d'une page à distribuer aux étudiants : matrice de décision, workflow 3 phases, réflexes de prompting, checklist de relecture, pièges à connaître, template de rules |

---

### Annexes

| Fichier | Contenu |
|---|---|
| [Annexes.md](Annexes.md) | Code de base du projet FlashCards CLI (PHP), exemple de fichier rules, exemple de spec rédigée avec l'IA, grille d'évaluation formative, ressources pour aller plus loin |

---

## Planning synthétique

```
JOUR 1 — Comprendre l'IA et se confronter à ses limites
├── 9h-9h30    Introduction & tour de table
├── 9h30-10h15 Comment ça fonctionne (LLM, tokens, embeddings)
├── 10h15-10h30 ☕ Pause
├── 10h30-10h45 Prise en main Gemini CLI
├── 10h45-12h  🎮 Exercice 1 : le run "naïf" (flashcards)
├── 12h-13h    🍽️ Déjeuner
├── 13h-13h45  Analyse collective des résultats
├── 13h45-14h15 Limites & enjeux éthiques
├── 14h15-14h30 ☕ Pause
├── 14h30-14h50 Quand ne PAS utiliser l'IA
├── 14h50-15h20 Le métier qui change
├── 15h20-15h50 La notion de contexte
└── 15h50-16h  Débrief jour 1

JOUR 2 — Structurer, itérer et maîtriser
├── 9h-9h30    Prompt itératif vs one-shot
├── 9h30-10h   Spécifier avant de développer
├── 10h-10h15  ☕ Pause
├── 10h15-10h45 Sessions d'échange avec l'IA
├── 10h45-11h15 Rules, outils et agents (panorama, GEMINI.md, memory, MCP, orchestration)
├── 11h15-11h45 Workflow réel (démo) + les tests comme garde-fou
├── 11h45-12h  Préparation exercice 2
├── 12h-13h    🍽️ Déjeuner
├── 13h-14h15  🎮 Exercice 2 : le run "structuré" (flashcards)
├── 14h15-14h30 ☕ Pause
├── 14h30-15h30 🔍 Atelier Symfony Demo (explorer & auditer)
├── 15h30-15h50 Temps libre encadré (appliquer la méthodologie)
└── 15h50-16h  Débrief final
```

---

## Fichier source original

Le fichier [Base.md](Base.md) contient l'intégralité du cours en un seul document, si besoin de référence.
