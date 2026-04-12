# Feature Specification: Dark Brutalist Job Board Redesign

## 1. Overview
Redesign the user-facing job matching interface (Find Jobs) to feature a minimalist, dark-brutalist aesthetic referencing the provided "worksearch" UI concepts. The aesthetic relies on an entirely dark background, lowercase functional typography, high-contrast flat layout elements without shadows, and loud orange accents.

*Note: All color changes mapping to the dark theme must be configured centrally in `public/assets/css/design-tokens.css` (e.g., updating `--color-surface` to `#111111` and `--color-accent` to `#ff4500`) rather than injecting hardcoded hex values into components.*

## 2. Architecture & Components

### 2.1 Layout Update (`app/views/layouts/user.php`)
- **Theme:** Convert background to rely on `var(--color-surface)` as defined in tokens (now dark `111111`). Ensure text colors bind to the updated `var(--color-text)` (white/light-gray).
- **Top Navigation:**
  - Logo on left: custom SVG shape + lowercase `worksearch` or `$appName`.
  - Links centered: `job search`, `messages`, `companies`, `about us`.
  - Right: `my profile` icon/avatar.
- **Typography:** Adopt a geometric sans-serif or grotesk font (e.g., Space Grotesk, Inter). All UI headers and labels will use lowercase syntax.

### 2.2 Search & Filters Implementation (`app/views/user/jobs/index.php`)
- **Hero Title:** `| find your perfect job` with an orange left border/accent.
- **Search Bar:** A sleek, borderless text input field (integrated tightly into the dark background, maybe underlined) to allow searching by keywords (`q`).
- **Filter Row (Dropdowns):**
  - Horizontal display of `select` elements or custom dropdowns mapping standard backend filters.
  - `job type` -> Full-time, Part-time, Internship, etc.
  - `grade / education` -> Maps to `$searchParams['min_education']`.
  - `experience` -> Maps to `$searchParams['experience_level']`.
  - `salary` -> Maps to `$searchParams['min_salary']`.
- **Job List:**
  - Standard grid cards are replaced by horizontal rows separated by 1px borders mapped to `var(--color-border)`.
  - Left side: Company thumbnail + `<lowercase company name>`, underneath `<lowercase job title in gray>`.
  - Right side: Large `<salary matched to --color-accent>` and metadata `<date> / <location> / <experience>`.

### 2.3 Job Detail Page (`app/views/user/jobs/show.php`)
- **Navigation:** Top left `<- back` button.
- **Header:** `<lowercase job title>` in gray, `<company name with icon>` in white constraint.
- **Skill/Tag Pills:** Simple transparent boxes with borders `border border-gray-700` displaying job type, remote possible, senior level, etc.
- **Content Blocks:** `description`, `responsibilities`, `requirements` titles followed by standard un-styled lists and body text spanning ~70% screen width.
- **Action Panel (Right):**
  - Fixed-width rectangular panel with a slightly lighter surface override if needed.
  - Large salary text at the top mapping to `var(--color-accent)`.
  - Bulleted list of context tags (company, location, experience required, job type, posted on).
  - Prominent, solid-color button mapped to `bg-accent` bridging the native Challora apply/status flow.

## 3. Error Handling & Data Flow
- **Data Variables:** Preserve existing PHP bindings (`$jobs`, `$searchParams`, `$job`, `$alreadyApplied`, `$isSaved`).
- No changes to `$jobModel` queries or `JobController` logic are strictly necessary; all mapping is visual in the views.

## 4. Testing Criteria
- Form submit via `<select>` changes triggers search query properly.
- All 3 page layouts compile without PHP parsing errors.
- Visual alignment matches the dark-brutalist prompt under responsive behavior.
