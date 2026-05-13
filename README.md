# Challora — AI-Powered HR Recruitment Platform

> **Challora** is a smart recruitment platform that connects job seekers with employers through AI-driven candidate matching, automated screening, and intelligent insights — all in one place.

---

## 💡 What Challora Does

Challora replaces manual, time-consuming recruitment processes with intelligent automation:

- **For Job Seekers:** Get AI-curated job recommendations, track application status, and receive personalized profile feedback.
- **For HR & Employers:** Post jobs, manage a visual pipeline of candidates, receive AI-scored candidate ratings with strengths/weaknesses analysis, and access an intelligence dashboard for quick hiring decisions.

---

## ⚙️ Tech Stack

### Frontend
- **React 19** — modern component-based UI
- **Vite** — fast build tooling
- **Tailwind CSS 4** — utility-first styling with custom design system
- **shadcn/ui** — accessible component library
- **Three.js + GSAP** — landing page visual effects
- **Swup.js** — smooth page transitions

### Backend
- **Laravel 12** — PHP framework with MVC architecture
- **MySQL** — relational database
- **Redis** — caching (optional)
- **Queue Workers (database driver)** — async job processing

### AI Services (Python Microservice)
- **FastAPI** — Python async web framework
- **Groq API** — LLM inference (`llama-3.3-70b-versatile`)
- Handles: CV scoring, candidate summaries, job recommendations

### Infrastructure
- **Railway** — cloud deployment for both Laravel app and AI Python service
- **GitHub** — two repos: main app + AI backend

---

## 🏗️ How It Works

```
User (Job Seeker)                  HR (Employer)
     │                                  │
     ▼                                  ▼
[Challora Web App]            [Challora Web App]
     │                                  │
     ▼                                  ▼
[Laravel API] ────────────▶ [AI Python Service]
     │                        (Groq LLM)
     │                                  │
     ▼                                  ▼
[MySQL Database]            [AI Scores & Summaries]
```

### For Candidates
1. Register and complete profile (experience, education, skills, achievements)
2. Browse jobs and apply with one click
3. Receive **AI job recommendations** tailored to their profile
4. Track application status in real time
5. Get AI-generated profile feedback to improve visibility

### For HR / Employers
1. Post jobs with required skills, experience level, and education
2. View all applications in a visual pipeline
3. Click **"Refresh AI"** to trigger AI scoring on any candidate
4. AI analyzes the candidate's CV against the job requirements:
   - **Score (0–100)** — overall fit rating
   - **Strengths** — top qualifications
   - **Weaknesses** — gaps to address
   - **Summary** — 2-3 sentence overall assessment
5. Filter by AI score, sort candidates, and make faster hiring decisions

### AI Processing Flow
```
User triggers AI → Job dispatched → Queue worker picks up →
Python AI service calls Groq → Response stored in DB →
UI polls for completion → HR sees updated scores
```

---

## 🔑 Key Features

| Feature | Description |
|---|---|
| Job Listing & Search | Public job board with location, skills, and experience filtering |
| One-Click Apply | Candidates apply to jobs with saved profile data |
| AI Job Picks | Personalized top-5 job recommendations per candidate |
| AI CV Scoring | Rates candidates 0–100 on job fit with breakdown per category |
| AI Candidate Summary | Pros, cons, and recommendation (Highly Recommended → Not Recommended) |
| HR Pipeline Dashboard | Visual application management with status tracking |
| HR Intelligence Dashboard | Top candidates per job + AI insights sidebar |
| Profile Builder | Rich candidate profiles with work history, achievements, skills |
| Resume Upload | CV, diploma, and photo storage |
| Social Media Links | Candidate social profiles displayed in profile |
| Save Jobs | Candidates can bookmark jobs for later |

---

## 👥 User Roles

- **`user`** — Job seeker. Can browse jobs, apply, save jobs, manage profile.
- **`hr`** — Employer/recruiter. Can post jobs, manage applications, trigger AI scoring, view intelligence dashboard.

---

## 📦 Database Schema (Core Entities)

```
users
  ├── job_postings (created_by)
  ├── applications
  ├── work_experiences
  ├── achievements
  ├── organizational_experiences
  └── saved_jobs

job_postings
  └── applications

applications
  ├── ai_candidate_scores
  └── ai_candidate_summaries
```

---

## 🔧 Environment Variables

| Variable | Description |
|---|---|
| `AI_SERVICE_BASE_URL` | URL of the AI Python service (default: Railway AI URL) |
| `AI_TIMEOUT_MS` | HTTP timeout for AI calls (default: 15000ms) |
| `AI_RETRY_COUNT` | Number of retries on AI failure (default: 1) |
| `QUEUE_CONNECTION` | Queue driver (`sync` for local, `database` for production) |

---

## 🚀 Deployment

### Laravel App (Railway)
```
git push origin master
```
Railway auto-deploys from the main branch.

### AI Python Service (Railway)
```
git push origin main
```
Separate repo, auto-deploys independently.

### Queue Worker (Production)
Add a worker process on Railway:
```
php artisan queue:work database --tries=2 --timeout=60
```

---

## 📁 Project Structure

```
challorav2/                    # Laravel main app
├── app/
│   ├── Console/Commands/     # Artisan commands (AI tools, seeding)
│   ├── Http/Controllers/     # Auth, User, HR controllers
│   ├── Jobs/Ai/             # AI job dispatchers (CV rating, summary)
│   ├── Middleware/           # Role-based access control
│   ├── Models/              # Eloquent models
│   └── Services/            # Business logic + AI gateway
├── resources/views/          # Blade templates
│   ├── auth/                 # Login, register, password reset
│   ├── hr/                   # HR dashboard, pipeline, intelligence
│   ├── user/                 # Job listing, applications, settings
│   └── landing.blade.php     # Public landing page
└── config/ai.php             # AI service configuration

CHALLY_HR_AI/                 # Python AI microservice
├── src/
│   ├── api.py                # FastAPI endpoints
│   ├── assistant_v2.py       # AI logic (CV rating, summaries, recommendations)
│   └── config.py             # Groq client setup
└── requirements.txt
```

---

## 🎯 Status

**Active development.** All core features are implemented and deployed.