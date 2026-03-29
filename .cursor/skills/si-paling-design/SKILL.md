---
name: si-paling-design
description: Analyzes UI design from user-provided images with detailed color identification (primary, secondary, accent, and additional categories), design hierarchy mapping, and clean styling implementation guidance. Use when users request visual matching, styling refactors, palette extraction, UI hierarchy alignment, or design-to-code work. Also flags potential UI elements related to siPalingDatabase outputs that are missing from the requested design.
---

# siPalingDesign

## Purpose

siPalingDesign focuses on visual quality and styling implementation only:
- Observe and map color usage precisely.
- Understand design hierarchy from user-provided images.
- Translate design into neat, maintainable styling guidance.
- Suggest missing UI elements that may be needed for `siPalingDatabase` data visibility.

Do not change database logic or business logic unless explicitly requested in another task.

## When To Apply

Apply this skill when the user asks for:
- UI restyling based on screenshot/mockup/image.
- Palette alignment (primary/secondary/accent).
- Better visual hierarchy and spacing.
- Design consistency improvements.
- Identification of missing UI parts for data presentation.

## Core Rules

1. Styling-first scope:
   - Prioritize color, typography, spacing, layout, emphasis, and component states.
   - Avoid changing backend behavior.

2. Color taxonomy must be explicit:
   - Always classify: `primary`, `secondary`, `accent`.
   - Add other categories when relevant: `neutral`, `surface`, `success`, `warning`, `danger`, `info`, `overlay`, `border`, `text-primary`, `text-secondary`, `disabled`.

3. Hierarchy must be mapped before coding:
   - Identify focal point, reading flow, visual weight, grouping, and interaction priority.

4. Clean implementation:
   - Prefer reusable tokens/variables over hardcoded colors.
   - Keep naming consistent and scalable.
   - Keep changes localized and maintainable.

5. Database-aware design suggestions:
   - If design misses areas needed to display likely `siPalingDatabase` outputs (tables, metadata, status badges, filters, pagination, empty states), call them out as recommendations.
   - Mark these as suggestions, not assumptions.

## Required Workflow

Follow this sequence every time:

1. **Input Understanding**
   - Confirm target screen/component and desired visual direction.
   - If an image is provided, extract observable style cues only.
   - If no image is provided, infer from existing code and user intent.

2. **Color Audit**
   - List all distinct color roles used or required.
   - Map each color to semantic intent (CTA, emphasis, background, border, status, text).
   - Note contrast risks and readability concerns.

3. **Hierarchy Audit**
   - Identify page structure: header, content, supporting blocks, actions.
   - Define priority levels (`H1`, `H2`, `body`, `meta`, `action-secondary`).
   - Evaluate spacing rhythm and grouping clarity.

4. **Design-to-Code Mapping**
   - Propose token set (CSS variables or equivalent style constants).
   - Map tokens to components/states (`default`, `hover`, `active`, `focus`, `disabled`).
   - Keep style architecture coherent with the existing codebase.

5. **siPalingDatabase Coverage Check**
   - Inspect whether expected data UI patterns are represented:
     - data list/table/card
     - status indicators
     - sorting/filter/search controls
     - empty/loading/error states
     - pagination or infinite scroll cues
   - Report missing items under recommendations.

6. **Implementation Output**
   - Provide detailed, structured output using the template below.

## Output Template (Detailed)

Use this structure:

```markdown
## Design Analysis
- Target: [screen/component]
- Source: [image/code/both]
- Intent: [visual goal]

## Color System
- Primary: [hex/rgb + usage]
- Secondary: [hex/rgb + usage]
- Accent: [hex/rgb + usage]
- Additional categories:
  - Neutral:
  - Surface:
  - Text Primary:
  - Text Secondary:
  - Border:
  - Success/Warning/Danger/Info:
- Contrast notes: [pass/fail risks and fixes]

## Hierarchy Mapping
- Focal point:
- Reading flow:
- Priority levels:
  - High:
  - Medium:
  - Low:
- Spacing/grouping notes:

## Styling Implementation Plan
- Tokens/variables to define:
- Components to update:
- States to support (hover/active/focus/disabled):
- Responsive considerations:

## siPalingDatabase Design Coverage
- Already covered:
- Potentially missing in requested design:
  - [element]: [why it helps data usability]

## Actionable Styling Changes
1. [specific change]
2. [specific change]
3. [specific change]
```

## Implementation Standards

- Prefer semantic tokens (`--color-primary`) over raw values in repeated usage.
- Keep component styles predictable and avoid one-off hacks.
- Preserve accessibility:
  - Maintain readable contrast.
  - Keep visible focus states.
  - Avoid color-only meaning where possible.
- Keep naming and structure aligned with the project's existing style system.

## Boundaries

- In scope:
  - CSS/SCSS/Tailwind/style objects.
  - Class naming cleanup.
  - Visual hierarchy and spacing improvements.

- Out of scope (unless explicitly requested):
  - API changes.
  - Database schema changes.
  - Business logic refactors.
  - Data model rewrites.

## Quick Decision Heuristics

- If unsure between exact pixel-match and maintainability, prioritize maintainable consistency and call out the tradeoff.
- If a color role is ambiguous, classify by function (CTA/background/status) rather than by visual guess alone.
- If design omits data-related UI that impacts usability, include it under `siPalingDatabase Design Coverage` as recommendation.
