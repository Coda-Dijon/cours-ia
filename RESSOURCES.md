## Ressources additionnelles
- [Installer un LLM dans un bunker numérique](https://www.theodo.com/blog/integration-assistants-ia)

### Outils
- [Vibe-Kanban](https://www.vibekanban.com/)
- [LLM fit - Identifier LLMs qui pourraient tourner sur ma machine](https://github.com/AlexsJones/llmfit?tab=readme-ov-file)
- [Coding Agents - Matrix by Promyze](https://coding-agents-matrix.dev/)
- [Build AI Agents Visually](https://github.com/FlowiseAI/Flowise)
- [NWave - Craft your code](https://nwave.ai/)
- [AI Penetration tool](https://github.com/KeygraphHQ/shannon)
- [AI design tool](https://stitch.withgoogle.com/)
- [Code review graph](https://github.com/tirth8205/code-review-graph)
- [Pixel Agents - The game interface where AI agents build real things](https://github.com/pablodelucca/pixel-agents)

### Claude Code
- [Everything Claude Code](https://github.com/affaan-m/everything-claude-code)
- [Autonomous Claude Agent Team](https://github.com/NTCoding/autonomous-claude-agent-team)
- [Best Practices](https://github.com/shanraisshan/claude-code-best-practice)

### Optimizer
- [RTK - Reduce Token usage](https://github.com/rtk-ai/rtk)
- [Claude mem](https://github.com/thedotmack/claude-mem)

### Concepts
- [Spec-Driven Development](https://github.com/github/spec-kit)
- [Semantic Anchors](https://github.com/LLM-Coding/Semantic-Anchors)
- [Context Engineering for Coding Agents](https://martinfowler.com/articles/exploring-gen-ai/context-engineering-coding-agents.html)
- [Socratic prompting](https://pub.towardsai.net/the-socratic-prompt-how-to-make-a-language-model-stop-guessing-and-start-thinking-07279858abad)

### Ethique
- [Impact de l’IA](https://www.lemonde.fr/economie/article/2025/12/26/comment-l-ia-devore-la-planete_6659449_3234.html)
- [Intelligence artificielle - le vrai coût environnemental de la course à l’IA](https://bonpote.com/intelligence-artificielle-le-vrai-cout-environnemental-de-la-course-a-lia/)
- [Software Crafsmanship in the AI Era](https://www.codurance.com/publications/software-craftsmanship-in-the-ai-era)
- [Linux AI Coding Policy](https://github.com/torvalds/linux/blob/master/Documentation/process/coding-assistants.rst)
- [Your Brain on ChatGPT: Accumulation of Cognitive Debt when Using an AI Assistant for Essay Writing Task](https://www.brainonllm.com/)

### Frugalité
- [Référentiel de bonnes pratiques d'utilisation de l'IA générative](https://ria.greenit.fr/fr)
- [trackcarbon](https://fondation-sahar.fr/trackcarbon)
- [Ecologits - Impact des IA](https://ecologits.ai/latest/)

### Etudes sur l’IA
- [The Hidden Costs of Coding With Generative AI](https://sloanreview.mit.edu/article/the-hidden-costs-of-coding-with-generative-ai/)
- [Mistral et empreinte environnemental](https://mistral.ai/news/our-contribution-to-a-global-environmental-standard-for-ai)

### Learning

- Cours + certification :
    - Complete guide to Building Skill for Claude : https://resources.anthropic.com/hubfs/The-Complete-Guide-to-Building-Skill-for-Claude.pdf
    - AI Engineering hub : https://github.com/patchy631/ai-engineering-hub

https://x.com/EloiLJF/status/2031718851004465177

The creator of Claude Code just published a thread that's going viral.

4 million views. 35,000 likes.

Boris Cherny and his team shared how they use Claude Code daily. Here are the key learnings – for anyone looking to get more out of AI coding agents:

𝟭. 𝗪𝗼𝗿𝗸 𝗶𝗻 𝗽𝗮𝗿𝗮𝗹𝗹𝗲𝗹

Set up 3-5 git worktrees, each with its own Claude session. "Single biggest productivity unlock" according to the team.

𝟮. 𝗣𝗹𝗮𝗻 𝗺𝗼𝗱𝗲 𝗳𝗶𝗿𝘀𝘁

Complex tasks always start with a plan. Pour energy into planning → Claude implements in one shot. Pro tip: Have a second session review the plan as a "Staff Engineer."

𝟯. 𝗠𝗮𝗶𝗻𝘁𝗮𝗶𝗻 𝗖𝗟𝗔𝗨𝗗𝗘.𝗺𝗱

After every correction: "Update your

[**CLAUDE.md**](http://claude.md/)

so you don't make that mistake again." Claude writes excellent rules for itself. Mistake rate drops measurably over time.

𝟰. 𝗕𝘂𝗶𝗹𝗱 𝘆𝗼𝘂𝗿 𝗼𝘄𝗻 𝘀𝗸𝗶𝗹𝗹𝘀

Repetitive tasks → skill or slash command. The team uses /techdebt at the end of every session to find duplicated code. Commit skills to git and reuse across projects.

𝟱. 𝗔𝘂𝘁𝗼𝗺𝗮𝘁𝗲 𝗯𝘂𝗴 𝗳𝗶𝘅𝗲𝘀

Enable Slack MCP, paste a bug thread, say "fix." Or: "Go fix the failing CI tests." Don't micromanage – Claude finds the way.

𝟲. 𝗕𝗲𝘁𝘁𝗲𝗿 𝗽𝗿𝗼𝗺𝗽𝘁𝘀

→ "Grill me on these changes – no PR until I pass your test"

→ "Knowing everything you know now, scrap this and implement the elegant solution"

→ Detailed specs = better output

𝟳. 𝗨𝘀𝗲 𝘀𝘂𝗯𝗮𝗴𝗲𝗻𝘁𝘀

Append "use subagents" to requests for more compute. Offload tasks to subagents to keep main context clean.

𝟴. 𝗗𝗮𝘁𝗮 & 𝗔𝗻𝗮𝗹𝘆𝘁𝗶𝗰𝘀

Claude + bq CLI = metrics on the fly. Boris: "I haven't written a line of SQL in 6+ months."

𝟵. 𝗩𝗼𝗶𝗰𝗲 𝗗𝗶𝗰𝘁𝗮𝘁𝗶𝗼𝗻

You speak 3x faster than you type. Prompts automatically get more detailed. (fn x2 on macOS)

𝟭𝟬. 𝗟𝗲𝗮𝗿𝗻 𝘄𝗶𝘁𝗵 𝗖𝗹𝗮𝘂𝗱𝗲

Enable "Explanatory" output style, generate HTML presentations or ASCII diagrams. Claude explains the why behind changes.

![claude-cheat-sheet.jpeg](attachment:fd023a94-db1b-449c-a638-9b56372561d6:claude-cheat-sheet.jpeg)