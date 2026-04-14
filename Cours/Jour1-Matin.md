# Jour 1 — Comprendre l'IA et se confronter à ses limites

**Objectif de la journée** : les étudiants découvrent concrètement ce qu'une IA générative peut (et ne peut pas) faire en développement. Ils produisent du code avec l'IA sans méthode, puis analysent ensemble les problèmes. En fin de journée, ils comprennent pourquoi le contexte et la rigueur sont indispensables.

---

<a id="j1-intro"></a>
## 9h30 – 10h00 : Introduction

### Objectif pédagogique
Poser le cadre, créer un climat de confiance, évaluer le niveau de la classe vis-à-vis de l'IA.

### Déroulé

**Présentation (5 min)**

Se présenter brièvement : parcours freelance, rapport personnel à l'IA au quotidien. Un exemple où l'IA a fait gagner du temps, un où elle a fait perdre du temps. L'idée : ce cours vient du terrain, pas d'un manuel.

**Prise de température collective (10 min)**

Pas de tour de table — on pose des questions ouvertes à la classe, ceux qui veulent répondre prennent la parole.

Questions à poser (dans l'ordre) :

1. **"Qui utilise déjà l'IA pour coder ?"** — à main levée, pour jauger le niveau global.
2. **"Ceux qui l'utilisent : vous utilisez quoi, et pour faire quoi ?"** — laisser 3-4 réponses spontanées (ChatGPT, Copilot, "je copie-colle le code"…).
3. **"Et ceux qui ne l'utilisent pas — c'est un choix, ou juste pas eu l'occasion ?"** — ouvrir la parole à ceux qui n'osent pas.
4. **"Si je vous dis 'IA dans le dev', quel est le premier mot qui vous vient ?"** — noter 5-6 mots-clés au tableau.

> **Note pour l'intervenant** : les mots-clés notés seront repris en fin de jour 2 pour mesurer l'évolution des perceptions.

**Cadrage du cours (5 min)**

Expliquer clairement l'approche :

- Ce n'est pas un cours *sur* l'IA, c'est un cours *avec* l'IA.
- On va coder, se tromper, analyser, recommencer.
- Il n'y a pas de "bonne réponse" unique — l'objectif est de développer un regard critique.
- Règle du cours : **on a le droit de galérer, c'est même le but du jour 1.**

---

<a id="j1-fonctionnement"></a>
## 10h00 – 10h45 : Comment ça fonctionne

### Objectif pédagogique
Donner une compréhension intuitive puis progressivement technique du fonctionnement des LLM. On part de ce que les étudiants connaissent déjà (ChatGPT, Netflix, FaceID...), on montre le paysage complet, puis on plonge dans la mécanique. Ils doivent repartir en sachant *pourquoi* l'IA se comporte comme elle le fait, pourquoi elle se trompe, et pourquoi le contexte est si important.

### Déroulé détaillé

---

#### 1. L'IA, vous la connaissez déjà (5 min)

On ne commence pas par la théorie — on commence par ce qu'ils vivent tous les jours.

**Question ouverte à la classe** : "Donnez-moi des exemples d'IA que vous utilisez au quotidien, sans forcément le savoir."

Laisser les réponses fuser, puis compléter si besoin :

- **Netflix / Spotify / YouTube** qui recommandent des contenus → IA prédictive
- **FaceID / déverrouillage facial** → vision par ordinateur
- **Filtres Instagram / Snapchat** → vision par ordinateur + génération d'images
- **Google Traduction** → modèle de langage
- **Anti-spam Gmail** → classification de texte
- **Navigation GPS (Waze, Google Maps)** → optimisation en temps réel
- **Siri / Google Assistant** → reconnaissance vocale + LLM
- **ChatGPT / Gemini / Copilot** → LLM (modèles de langage)

> **Point clé à faire passer** : l'IA n'est pas un truc nouveau qui est arrivé avec ChatGPT. Ça fait des années que vous l'utilisez. Ce qui a changé en 2022-2023, c'est qu'elle est devenue *conversationnelle* — on peut lui parler en langage naturel.

---

#### 2. Les grandes familles d'IA — on ne parle pas tous de la même chose (5 min)

Le mot "intelligence artificielle" est un terme parapluie. Quand quelqu'un dit "l'IA va remplacer les développeurs", il faut savoir de quelle IA on parle. Voici les grandes familles :

**L'IA prédictive / Machine Learning classique** — c'est l'IA "invisible" : recommandation Netflix/Spotify, détection de fraude bancaire, filtres anti-spam, prédiction de prix. Elle analyse des données structurées (tableaux, chiffres) pour faire des prédictions. Quand votre banque bloque une transaction suspecte, c'est du ML classique.

**La vision par ordinateur (Computer Vision)** — l'IA qui "voit" : reconnaissance faciale, voitures autonomes, contrôle qualité en usine, diagnostic médical par imagerie. Quand votre téléphone reconnaît votre visage, c'est de la computer vision.

**L'IA générative d'images/audio/vidéo** — Midjourney, DALL-E, Stable Diffusion pour les images ; Suno, Udio pour la musique ; Sora (OpenAI), Runway pour la vidéo. Ces modèles génèrent du contenu multimédia à partir de texte.

**La robotique et l'IA embarquée** — robots industriels, drones autonomes, bras chirurgicaux. L'IA contrôle des actions physiques en temps réel.

**Les LLM — modèles de langage (ce qu'on va utiliser)** — ChatGPT, Gemini, Claude, Copilot... C'est ce qui nous intéresse parce que c'est ce qui a révolutionné le développement logiciel.

> Un modèle de détection de fraude ne va pas écrire votre code PHP. Et un LLM ne va pas piloter une voiture. Chaque type d'IA a son domaine — et ses limites.

---

#### 3. Le paysage des LLM — qui fait quoi dans le monde ? (10 min)

Maintenant qu'on sait que ce cours porte sur les LLM, regardons qui les fabrique. Il existe des dizaines de modèles, développés sur trois grands pôles géographiques. C'est une course mondiale.

**Les acteurs américains — les pionniers**

Ce sont eux qui ont lancé la course. Les plus gros budgets, les plus gros datacenters.

| Entreprise | Modèles phares | Ce qui les distingue | Fenêtre de contexte |
|---|---|---|---|
| **OpenAI** | GPT-4o, o3, o4-mini | Le plus connu, écosystème ChatGPT massif, modèles raisonneurs (o3) | 128K tokens |
| **Google** | Gemini 2.5 Pro, 2.5 Flash | Contexte gigantesque, multimodal natif (texte + image + vidéo + audio) | Jusqu'à 1M tokens |
| **Anthropic** | Claude Sonnet 4, Opus 4 | Suivi d'instructions très précis, excellent en code structuré, focus sécurité | 200K tokens |
| **Meta** | Llama 4 | Open source, exécutable en local, énorme communauté de contributeurs | Variable |
| **xAI (Elon Musk)** | Grok | Intégré à X (Twitter), moins de filtres, accès temps réel | 128K tokens |

**Les acteurs européens — souveraineté et open source**

L'Europe a ses propres champions, avec un focus sur le multilinguisme, la conformité au règlement européen sur l'IA (EU AI Act), et la souveraineté numérique.

| Entreprise | Pays | Modèles phares | Ce qui les distingue |
|---|---|---|---|
| **Mistral AI** | 🇫🇷 France | Mistral Large, Medium 3, Codestral | Le champion français. Fort en français, modèle code dédié (Codestral). Interface "Le Chat" comme alternative européenne à ChatGPT |
| **Aleph Alpha** | 🇩🇪 Allemagne | Pharia | Focus entreprise et gouvernement, conformité RGPD native |
| **LightOn** | 🇫🇷 France | Alfred | IA souveraine pour entreprises européennes, déploiement sur infrastructure française |
| **BLOOM** | 🇪🇺 Consortium | BLOOM (176B) | Premier LLM open source massif, 1000+ chercheurs, entraîné sur le supercalculateur français Jean Zay. 46 langues |

> **Point pour la discussion** : quand vous utilisez ChatGPT ou Gemini, vos prompts et vos données transitent par des serveurs américains. Avec Mistral, elles peuvent rester en Europe. Pour une entreprise qui manipule des données sensibles (santé, finance, défense), ce n'est pas anodin.

**Les acteurs chinois — l'ascension fulgurante**

La Chine a rattrapé son retard à une vitesse impressionnante. Certains de ses modèles rivalisent avec les meilleurs modèles américains — souvent à un coût très inférieur.

| Entreprise | Modèles phares | Ce qui les distingue |
|---|---|---|
| **DeepSeek** | DeepSeek V3, R1 | L'électrochoc de 2025 : performances proches de GPT-4 pour une fraction du coût. Open source |
| **Alibaba** | Qwen 3.5 | Famille de modèles la plus téléchargée au monde en 2025, surpassant Llama de Meta |
| **Zhipu AI** | GLM-5 | Open source, orienté raisonnement et agents |
| **Moonshot AI** | Kimi K2 | Se rapproche de Claude Opus sur certains benchmarks. Spécialisé longs contextes |
| **Baichuan** | Baichuan 4 | Orienté entreprise, fort en chinois et en anglais |

> **Anecdote** : en janvier 2025, DeepSeek sort R1, entraîné pour une fraction du budget d'OpenAI. Le Nasdaq perd plusieurs centaines de milliards de dollars en une journée. Un modèle open source chinois a fait trembler Wall Street.

**Open source vs fermé**

- **Fermé** (GPT, Gemini, Claude) : accessible via API ou interface web. Vous ne pouvez pas voir le code du modèle. Souvent plus performants, mais vous dépendez du fournisseur.
- **Open source** (Llama, Mistral, DeepSeek, Qwen) : le modèle est téléchargeable. Vous pouvez l'exécuter sur votre propre machine, le modifier, le fine-tuner. Plus de contrôle, mais demande des compétences techniques.

> **Message clé** : le modèle n'est que le moteur. Ce qui fait la différence, c'est comment vous l'utilisez — le contexte, les instructions, la méthode. Un mauvais prompt sur le meilleur modèle donnera un résultat médiocre. Un bon prompt sur un modèle moyen peut donner un résultat excellent.

---

#### 4. Comment fonctionne un LLM — l'intuition avant la technique (10 min)

OK, on sait ce qu'est un LLM et qui les fabrique. Maintenant, comment ça marche ? On va commencer simple, puis creuser.

**L'idée fondamentale : la prédiction statistique**

Un LLM, c'est un programme qui a "lu" des milliards de pages web, de livres, de code source, de conversations. Il a appris à prédire **quel mot vient après quel mot**. C'est tout. Fondamentalement, c'est un système de prédiction statistique extrêmement sophistiqué.

**Analogie** : imaginez un ami qui a lu tous les livres du monde, tous les sites web, tout le code sur GitHub. Il a une mémoire incroyable des *patterns* qu'il a vus. Quand vous lui posez une question, il ne va pas "chercher la réponse" — il va *reconstituer* une réponse qui *ressemble* aux réponses qu'il a vues pour des questions similaires. Parfois c'est brillant. Parfois c'est complètement à côté. Et il ne sait pas faire la différence.

**Ce que ça implique tout de suite** :

- Ce n'est pas un moteur de recherche (il ne "cherche" pas l'information — il la *génère*).
- Ce n'est pas une base de données (il ne "stocke" pas des faits — il a appris des *patterns*).
- Ce n'est pas un être pensant (il ne "comprend" pas — il produit du texte *statistiquement vraisemblable*).

**Démo en live — le côté aléatoire**

Ouvrir ChatGPT, Gemini ou n'importe quel LLM et poser deux fois exactement la même question :

> "Écris un poème de 4 vers sur la programmation."

Montrer que les deux réponses sont différentes : mots différents, structure différente, rimes différentes. Demander aux étudiants : "Comment est-ce possible si c'est le même programme qui reçoit la même entrée ?"

La réponse : à chaque mot, l'IA calcule une probabilité pour le mot suivant. Au lieu de toujours prendre le plus probable, elle "lance un dé pondéré". C'est ce qu'on appelle le **sampling**. Le paramètre qui contrôle ça s'appelle la **température** :

- **Température basse** (0.0 - 0.3) : l'IA choisit presque toujours le mot le plus probable → réponses prévisibles, idéal pour du code.
- **Température haute** (0.8 - 1.0+) : l'IA prend des chemins moins probables → réponses créatives, parfois incohérentes, idéal pour du brainstorming.

> **Punchline** : "L'IA ne 'sait' rien. Elle calcule des probabilités. Et à chaque mot, elle joue aux dés. Parfois le dé tombe bien, parfois non. C'est pour ça que relancer le même prompt peut donner un meilleur résultat."

---

#### 5. L'entraînement — comment on construit un LLM (5 min)

Comment on passe d'un programme vide à un assistant capable de coder ?

**3 grandes étapes** :

```
╔═══════════════════════════════════════════════════════════════╗
║  ÉTAPE 1 : PRÉ-ENTRAÎNEMENT                                   ║
║                                                               ║
║  Données : des milliards de pages web, livres, code source    ║
║  Objectif : apprendre les "règles" du langage                 ║
║  Méthode : on cache un mot, le modèle doit le deviner         ║
║                                                               ║
║  "Le chat dort sur le ___"  → "canapé", "lit", "tapis"        ║
║                                                               ║
║  Résultat : un modèle qui sait compléter du texte,            ║
║  mais qui n'est pas encore "utile" comme assistant            ║
║  Coût : des millions de dollars en GPU                        ║
╚═══════════════════════════════════════════════════════════════╝
                          ↓
╔═══════════════════════════════════════════════════════════════╗
║  ÉTAPE 2 : FINE-TUNING SUPERVISÉ                              ║
║                                                               ║
║  Des humains écrivent des exemples de conversations :         ║
║  Q: "Comment trier un tableau en PHP ?"                       ║
║  R: "Utilisez sort() pour un tri croissant..."                ║
║                                                               ║
║  Le modèle apprend à répondre comme un assistant              ║
╚═══════════════════════════════════════════════════════════════╝
                          ↓
╔═══════════════════════════════════════════════════════════════╗
║  ÉTAPE 3 : - RLHF (apprentissage par feedback humain)         ║
║  Reinforcement learning from human feedback                   ║
║                                                               ║
║  Le modèle génère plusieurs réponses                          ║
║  Des humains classent : A > B > C                             ║
║  Le modèle apprend à produire ce que les humains préfèrent    ║
║                                                               ║
║  C'est ici qu'il apprend la prudence, la structure,           ║
║  et le suivi d'instructions                                   ║
╚═══════════════════════════════════════════════════════════════╝
```

**3 points à retenir** :

**a) La date de coupure** — les données d'entraînement ont une date limite. Le modèle ne "sait" rien de ce qui s'est passé après. Si vous lui demandez quelque chose de très récent, il va inventer une réponse plausible mais fausse.

**b) Les données ne sont pas neutres** — le modèle a vu beaucoup de vieux tutoriels (Stack Overflow, Medium). Il peut suggérer `mysql_query()` (déprécié depuis PHP 7.0) parce que des milliers de tutos l'utilisent. Il a un biais vers le *populaire*, pas le *correct*.

**c) Le modèle n'a PAS accès à votre environnement** — l'IA ne voit pas votre code, votre terminal, vos fichiers. Elle ne sait que ce que vous lui dites dans le prompt.

---

*À ce stade, les étudiants comprennent : ce qu'est un LLM, qui les fabrique, comment on le construit, et le principe de la prédiction statistique. On passe maintenant aux notions plus techniques qui expliquent son comportement au quotidien.*

---

#### 6. Les tokens — l'alphabet de l'IA (10 min)

Pour comprendre un LLM, il faut comprendre comment il "voit" le texte. Un humain lit des mots et des phrases. Un LLM, lui, travaille avec des **tokens**.

**Qu'est-ce qu'un token ?**

Un token est un morceau de texte — parfois un mot entier, parfois un bout de mot, parfois un caractère. Le texte que vous envoyez à l'IA est d'abord découpé en tokens avant d'être traité.

**Démo interactive** : aller sur [platform.openai.com/tokenizer](https://platform.openai.com/tokenizer) et montrer en live comment des phrases sont découpées.

**Exemples à montrer** :

```
"Hello world"           → ["Hello", " world"]                    → 2 tokens
"Bonjour le monde"      → ["Bon", "jour", " le", " monde"]      → 4 tokens
"anticonstitutionnel"   → ["anti", "constit", "ution", "nel"]    → 4 tokens
"$var = 42;"            → ["$", "var", " =", " 42", ";"]         → 5 tokens
"function test() {"     → ["function", " test", "()", " {"]      → 4 tokens
```

**Observations clés à faire remarquer** :

1. **Le français est "plus cher" que l'anglais.** "Hello world" = 2 tokens. "Bonjour le monde" = 4 tokens. Le tokenizer a été entraîné majoritairement sur de l'anglais, donc un même texte en français consomme environ 30 à 40% de tokens en plus.

2. **Le code a son propre découpage.** Les symboles (`$`, `=`, `{`, `()`) sont des tokens à part entière. L'IA "voit" le code comme une succession de tokens, pas comme des lignes.

3. **Les mots rares sont découpés en sous-mots.** Un terme technique spécifique à votre projet sera "vu" par l'IA comme un assemblage de syllabes, pas comme un concept unifié.

**Pourquoi c'est crucial** :

Chaque LLM a une **fenêtre de contexte** — un nombre maximum de tokens qu'il peut traiter en une seule conversation. 
C'est comme la `mémoire de travail` du modèle.

```
Modèle                  Fenêtre de contexte     ≈ Équivalent texte
─────────────────────────────────────────────────────────────────────
GPT-4o                  128 000 tokens          ~ 96 000 mots
Gemini 2.5 Pro          1 000 000 tokens        ~ 750 000 mots
Claude Sonnet/Opus      200 000 tokens          ~ 150 000 mots
Modèles locaux (petit)  4 000 - 8 000 tokens    ~ 3 000 - 6 000 mots
```

**Ce que ça implique concrètement** :

- Si vous collez un fichier PHP de 2 000 lignes dans votre prompt, vous "consommez" une grosse partie de la fenêtre.
- Plus le contexte est rempli, moins l'IA a de "place" pour raisonner.
- Si la conversation devient très longue, l'IA peut "oublier" le début.
- Un code très verbeux consomme du contexte pour rien.

> **Punchline** : "Les tokens, c'est la monnaie de l'IA. Chaque token que vous gaspillez en contexte inutile, c'est un token en moins pour la qualité de la réponse."

---

#### 7. Les embeddings — comment l'IA "comprend" le sens (10 min)

OK, l'IA découpe le texte en tokens. Mais comment elle passe de tokens (qui sont juste des bouts de texte) à quelque chose qui *ressemble* à de la compréhension ?

**La réponse : les embeddings (ou vecteurs plongés).**

Chaque token est converti en un **vecteur** — une liste de nombres. Pas 2 ou 3 nombres : dans les modèles modernes, chaque token est représenté par un vecteur de **4 096 à 12 288 dimensions** (nombres à virgule).

**Analogie en 2D pour comprendre** :

Imaginez une carte géographique très spéciale. Au lieu de placer des villes, on place des mots. Les mots qui ont un sens proche sont placés près les uns des autres.

```
        ↑ Noblesse
        |
  reine •    • roi
        |
        |  • prince
        |
  femme •    • homme
        |
        +──────────────→ Genre
```

Sur cette carte (simplifiée à 2 dimensions), on peut observer quelque chose de fascinant :

- Le vecteur qui va de "homme" à "femme" est à peu près le même que celui qui va de "roi" à "reine".
- Autrement dit : `roi - homme + femme ≈ reine`

C'est le fameux résultat de Word2Vec (2013), qui a montré qu'on pouvait faire de l'**arithmétique sur le sens des mots**.

**En pratique, avec des embeddings modernes** :

```
  "PHP"    est proche de → "Laravel", "Symfony", "Composer", "MySQL"
  "Python" est proche de → "Django", "Flask", "pip", "numpy"
  "bug"    est proche de → "error", "fix", "debug", "issue"
  "array"  est proche de → "list", "collection", "tableau", "foreach"
```

**Ce que ça implique pour le prompting** :

- Si vous écrivez "tableau PHP", l'IA rattache ça au concept d'array PHP, pas à un meuble.
- Si vous écrivez "gère les erreurs", l'IA va mobiliser tout l'espace sémantique autour de try/catch, validation, error handling.
- Si vous êtes vague ("fais le truc"), l'IA ne peut pas savoir vers quel espace sémantique se diriger — elle choisit le plus probable, qui n'est pas forcément ce que vous vouliez.

> **Punchline** : "Quand vous écrivez un prompt, vous donnez des coordonnées GPS à l'IA dans un espace à 12 000 dimensions. Plus les coordonnées sont précises, plus elle arrive au bon endroit."

---

#### 7b. Derrière le rideau — rien de magique, que des maths (5 min)

On vient de voir les embeddings, les vecteurs, les dimensions… Ça peut paraître abstrait, voire impressionnant. C'est le moment de casser le mythe.

**Comment sont stockés les vecteurs concrètement ?**

Un vecteur, c'est juste une ligne de nombres à virgule dans un fichier. C'est tout. Pas de cerveau numérique, pas de conscience cachée — un tableau de `float`.

```
"chat"   → [0.012, -0.834, 0.291, 0.567, ..., -0.103]   (4096 nombres)
"dog"    → [0.008, -0.812, 0.305, 0.542, ..., -0.098]   (4096 nombres)
"voiture"→ [0.743, 0.021, -0.654, 0.112, ..., 0.887]    (4096 nombres)
```

Le modèle entier — ses milliards de paramètres — c'est un énorme fichier de nombres. Quand vous téléchargez un modèle Llama de 8 milliards de paramètres, vous téléchargez un fichier de ~16 Go rempli de nombres à virgule. Ces nombres sont organisés dans des **matrices** (des grands tableaux à deux dimensions). L'inférence — le moment où l'IA "réfléchit" — c'est une succession de multiplications de matrices.

```
Entrée (votre prompt en tokens)
    ↓
Multiplication de matrices × 32 couches
    ↓
Sortie (probabilités pour le prochain token)
```

**Il n'y a rien de magique derrière.**

Quand quelqu'un dit "l'IA comprend", "l'IA réfléchit", "l'IA est intelligente" — il utilise des métaphores humaines pour décrire un processus purement mathématique. Le modèle ne comprend rien. Il multiplie des matrices de nombres, extrêmement vite, sur des cartes graphiques (GPU) qui font des milliards de calculs par seconde.

C'est comme dire que votre calculatrice "comprend" les maths quand elle affiche `2 + 2 = 4`. Elle ne comprend rien — elle applique des règles. Un LLM fait pareil, mais avec des règles apprises statistiquement sur des milliards de textes, plutôt que programmées à la main.

> **L'IA, c'est uniquement de la statistique.**

C'est le message le plus important de cette partie du cours. Tout ce qu'on a vu — les tokens, les embeddings, l'entraînement — peut se résumer en une phrase :

> **Un LLM est un programme qui calcule la probabilité statistique du prochain mot, en se basant sur les patterns qu'il a vus dans ses données d'entraînement.**

Il n'y a pas de raisonnement. Il n'y a pas de compréhension. Il n'y a pas d'intention. Il y a des statistiques sur des mots, transformés en nombres, traités par des multiplications de matrices.

**Pourquoi c'est important de le savoir ?**

Parce que ça change complètement la façon dont on utilise l'outil :

- On arrête de lui faire confiance aveuglément ("l'IA a dit que…").
- On comprend *pourquoi* elle se trompe (patterns statistiques rares ou contradictoires dans ses données).
- On comprend *pourquoi* le prompt est si important (c'est lui qui oriente les statistiques dans la bonne direction).
- On comprend *pourquoi* elle hallucine (quand aucun pattern clair ne domine, elle "moyenne" et produit du plausible mais faux).

> **Punchline** : "L'IA ne pense pas. Elle calcule des moyennes sur l'ensemble de tout ce qu'elle a lu. C'est un perroquet statistique extraordinairement sophistiqué — mais ça reste un perroquet."

---

#### 8. L'attention — la notion clé (2 min)

Le mécanisme d'**attention** est le concept central de l'architecture Transformer (la techno derrière tous les LLM modernes, inventée par Google en 2017). En résumé : chaque mot du texte peut "regarder" tous les autres mots et décider lesquels sont importants pour lui. C'est ce qui permet à l'IA de relier des éléments éloignés — par exemple, comprendre que dans "Le chat qui dormait sur le canapé a renversé le vase", c'est bien *le chat* qui a renversé le vase, pas le canapé.

Ce qu'il faut retenir : l'attention a une portée limitée (la fenêtre de contexte). Plus le contexte est long, plus l'IA peut perdre le lien entre des éléments éloignés. C'est pour ça que les **rules** (qu'on verra demain) sont si importantes : elles mettent le contexte essentiel *au début* de chaque interaction.

---

#### 9. La génération — comment l'IA produit du texte (5 min)

Maintenant qu'on sait comment l'IA "voit" le texte (tokens), "comprend" le sens (embeddings) et relie les éléments (attention), voyons comment elle génère une réponse.

**Le processus** :

```
Votre prompt : "Écris une fonction PHP qui additionne deux nombres"

L'IA traite tout le prompt → calcule l'attention entre tous les tokens
→ prédit le PREMIER token de la réponse

Token 1 : "```"     (elle "sait" qu'on attend du code)
Token 2 : "php"     (le token le plus probable après ```)
Token 3 : "\n"      (retour à la ligne)
Token 4 : "function" (début d'une fonction PHP)
Token 5 : " add"    (nom le plus probable vu le contexte)
...et ainsi de suite, token par token
```

**Concept crucial — l'auto-régression** : chaque nouveau token est prédit en fonction de TOUS les tokens précédents (le prompt + ce qui a déjà été généré). Le modèle se nourrit de sa propre sortie.

**Conséquence importante** : si l'IA génère un token erroné au début de sa réponse, toute la suite dérive. Le modèle ne "revient" pas en arrière. C'est comme écrire un texte sans jamais utiliser la touche Suppr.

> C'est pour ça que les LLM modernes utilisent parfois le "chain of thought" — ils "réfléchissent" étape par étape avant de donner la réponse finale.

---

*Pause 10h15 – 10h30*

---

<a id="j1-gemini"></a>
## 10h30 – 10h45 : Prise en main de Gemini CLI

### Objectif pédagogique
Que chaque étudiant ait un outil fonctionnel pour interagir avec l'IA en ligne de commande, prêt pour l'exercice.

### Déroulé

#### Installation (10 min)

**Prérequis** : Node.js installé (version 20+).

```bash
npm install -g @google/gemini-cli
```

Ou en mode "one-shot" sans installation permanente :

```bash
npx @google/gemini-cli
```

> **Note** : vérifier avant le cours que l'installation fonctionne sur les machines de la salle. La version gratuite offre 60 requêtes/min et 1 000 requêtes/jour avec un compte Google personnel — largement suffisant pour le cours.

**Alternatives si problème d'installation** :

- Utiliser l'interface web de Gemini / ChatGPT / Claude comme fallback.
- L'important est que chaque groupe ait au moins un outil IA fonctionnel.

#### Et les autres outils CLI ? (2 min)

Gemini CLI n'est pas le seul outil de ce type. Il en existe d'autres qui fonctionnent sur le même principe — un agent IA dans le terminal, capable de lire vos fichiers, d'écrire du code et d'exécuter des commandes :

- **GitHub Copilot CLI** — l'équivalent de Microsoft/GitHub. Même logique : on lui parle, il lit le projet, il code. Il a ses propres "skills" (des capacités spécialisées) et peut lui aussi enchaîner des actions automatiquement. Un Dockerfile est fourni dans le dossier `Docker/` si vous voulez le tester.
- **Claude Code** (Anthropic) — même approche, avec Claude comme modèle sous-jacent.
- **Cursor, Windsurf, Cline…** — des éditeurs de code avec IA intégrée, qui font la même chose mais dans une interface graphique plutôt qu'un terminal.

Ce qu'il faut retenir : les **principes** qu'on va apprendre (contexte, itération, spécification, relecture critique) s'appliquent à *tous* ces outils. On utilise Gemini CLI parce qu'il est gratuit et simple à installer, mais tout ce que vous apprendrez ici est transférable.

#### Premier prompt (5 min)

Démo live : ouvrir un terminal, lancer Gemini CLI, et taper :

```
Écris une fonction PHP qui inverse une chaîne de caractères.
```

Montrer le résultat. Faire remarquer :

- La réponse est instantanée et a l'air correcte.
- Mais est-ce qu'on sait si elle gère les caractères spéciaux ? Les accents ? Le UTF-8 ?
- **Premier réflexe à acquérir : ne jamais faire confiance aveuglément.**

> **Transition** : "OK, l'outil marche. Maintenant on va vous lâcher dessus un vrai projet. Aucune consigne de méthode. Débrouillez-vous."

---

<a id="j1-exercice1"></a>
## 11h00 – 12h : Exercice 1 — Le run "naïf"

### Objectif pédagogique
Faire vivre aux étudiants l'expérience d'utiliser l'IA sans méthode pour qu'ils constatent eux-mêmes les limites. C'est l'expérience fondatrice du cours.

### Mise en place

**Formation des groupes** : 3-4 étudiants par groupe. Mélanger les niveaux si possible.

**Distribution du code de base** : chaque groupe reçoit les fichiers PHP du projet de flashcards (voir [Annexe — Code de base](../Bonus/Annexes.md#annexe-code)).

Le code de base contient :

- `flashcards.php` : point d'entrée principal, menu et boucle principale.
- `functions.php` : fonctions utilitaires (affichage, saisie utilisateur, listing).
- `data.php` : données d'exemple, chargement/sauvegarde JSON.

Le programme fourni est fonctionnel mais très basique : on peut ajouter des cartes, les lister, et lancer une révision simple (question → réponse, sans score). C'est un Anki du pauvre — il y a beaucoup à améliorer.

**La consigne (volontairement vague)** :

> « Vous avez un outil de flashcards basique en PHP CLI. Utilisez l'IA pour en faire un vrai outil de révision utile et agréable à utiliser. Vous avez 1h15. »

**Ce qu'on ne leur dit PAS** (volontairement) :

- Pas de fichier rules
- Pas de contexte à donner à l'IA
- Pas de méthode de prompt
- Pas de spec à écrire avant
- Pas de consigne sur la qualité du code

### Pendant l'exercice

**Rôle de l'intervenant** : circuler, observer, *ne pas aider*. C'est important. Noter mentalement :

- Les groupes qui copient-collent tout sans lire
- Ceux qui demandent tout en un seul prompt géant ("ajoute un score, des stats, de l'import, de la répétition espacée")
- Ceux qui ont des erreurs et redemandent à l'IA de corriger sans comprendre
- Les conflits de code (l'IA qui réécrit la structure de données des cartes d'un prompt à l'autre)
- Les hallucinations (fonctions PHP qui n'existent pas, syntaxe inventée)
- Le piège classique : l'IA qui casse le JSON de sauvegarde en modifiant la structure sans migrer les données existantes

> **Astuce** : prendre des screenshots/notes des prompts les plus intéressants (bons ou mauvais) pour l'analyse de l'après-midi.

### Résultat attendu

À la fin, la plupart des groupes auront :

- Du code qui fonctionne partiellement ou pas du tout
- Du code qu'ils ne comprennent pas entièrement
- Des incohérences entre les parties générées (structure de carte qui change, champs ajoutés à un endroit mais pas utilisés ailleurs)
- Des patterns over-engineered pour un besoin simple (classe `Card` avec héritage, pattern Observer pour les scores…)
- Un système de scoring ou de stats qui ne persiste pas correctement dans le JSON
- Possiblement de l'OOP alors qu'ils n'en maîtrisent pas les bases

**C'est exactement le but.** Ce chaos va servir de matière première pour l'après-midi.

---

*Pause déjeuner 12h – 13h30*

---
