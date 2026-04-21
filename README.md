```
### Challora Laravel MVC Architecture
📁 Project Structure

challora-laravel/
├── app/
│   ├── Enums/              # 4 files - Type safety
│   ├── Http/
│   │   ├── Controllers/    # 13 controllers
│   │   └── Middleware/     # 1 middleware
│   ├── Models/             # 6 Eloquent models
│   └── Services/           # 2 services
├── resources/views/        # 19 blade templates
├── routes/web.php
└── database/migrations/    # 8 migrations
---
🗂️ MVC Layer Overview\

Layer	Location
Models	app/Models/
Views	resources/views/
Controllers	app/Http/Controllers/
Routes	routes/web.php
---

### 1. Models & Relationships ###

┌─────────────────────────────────────────────────────────────────┐
│                         USER                                     │
│  hasMany → jobPostings, applications, workExperiences, achievements│
│  belongsToMany → savedJobs (via saved_jobs pivot)               │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      JOBPOSTING                                  │
│  belongsTo → creator (User)                                      │
│  hasMany → applications                                         │
│  belongsToMany → savedByUsers (via saved_jobs pivot)            │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      APPLICATION                                 │
│  belongsTo → user, jobPosting                                    │
└──────────────────────────┬──────────────────────────────────────┘
                           │
         ┌─────────────────┴─────────────────┐
         ▼                                   ▼
┌─────────────────────┐         ┌─────────────────────┐
│ USERWORKEXPERIENCE  │         │  USERACHIEVEMENT    │
│ belongsTo → User    │         │  belongsTo → User   │
└─────────────────────┘         └─────────────────────┘
---

### 2. Controllers Organization ###

app/Http/Controllers/
├── Auth/
│   ├── LoginController.php
│   ├── RegisterController.php
│   └── ForgotPasswordController.php
│
├── User/
│   ├── ApplicationController.php
│   ├── ProfileController.php
│   └── SavedJobController.php
│
├── Hr/
│   ├── DashboardController.php
│   ├── JobController.php
│   └── ApplicationController.php
│
├── JobController.php         (shared)
└── DownloadController.php    (shared)
---

### 3. Views Structure ###

resources/views/
├── layouts/
│   ├── app.blade.php      # Main layout
│   ├── auth.blade.php     # Login/Register layout
│   └── hr.blade.php       # HR dashboard layout
│
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── passwords/
│       ├── email.blade.php
│       └── reset.blade.php
│
├── user/
│   ├── jobs/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   └── saved.blade.php
│   ├── applications/index.blade.php
│   └── settings/edit.blade.php
│
└── hr/
    ├── dashboard.blade.php
    ├── jobs/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── applications/
        ├── index.blade.php
        └── berkas.blade.php
---

### 4. Request Flow ###

┌─────────────┐     ┌──────────────┐     ┌─────────────┐
│   BROWSER   │────▶│   ROUTES    │────▶│ CONTROLLER │
└─────────────┘     │  web.php    │     └──────┬──────┘
                    └──────────────┘            │
                                                 ▼
                                         ┌─────────────┐
                                         │   SERVICE   │
                                         └──────┬──────┘
                                                │
                                                ▼
                                         ┌─────────────┐
                                         │    MODEL    │
                                         └──────┬──────┘
                                                │
                                                ▼
                                         ┌─────────────┐
                                         │  DATABASE   │
                                         └──────┬──────┘
                                                │
                                                ▼
                                         ┌─────────────┐
                                         │    VIEW     │
                                         │ (Blade)     │
                                         └─────────────┘
---

### 5. Middleware Pipeline ###

REQUEST
   │
   ▼
┌──────────────────┐
│  auth middleware │  ──▶ If not authenticated → login page
└────────┬─────────┘
         │ (authenticated)
         ▼
┌──────────────────┐
│ EnsureRole      │  ──▶ role:user OR role:hr
└────────┬─────────┘
         │ (authorized)
         ▼
   CONTROLLER
---

### 6. Routes Summary ###

Prefix	Middleware	Controller
/auth/*	guest	Login, Register, ForgotPassword
/jobs	auth	JobController
/user/*	auth, role:user	Profile, Application, SavedJob
/hr/*	auth, role:hr	Job, Application, Dashboard
/download/*	auth	DownloadController
---

### 7. Database Tables (Migrations) ###

Migration	Table
0001_01_01_000000_create_users_table.php	users
0001_01_01_000001_create_cache_table.php	cache
2026_04_20_133724_create_job_postings_table.php	job_postings
2026_04_20_133748_create_applications_table.php	applications
2026_04_20_133748_create_saved_jobs_table.php	saved_jobs
2026_04_20_133749_create_user_achievements_table.php	user_achievements
2026_04_20_133749_create_user_work_experiences_table.php	user_work_experiences
---
📊 Statistics Summary
Component	Count
Models	6
Controllers	13
Views	19
Migrations	8
Services	2
Enums	4
Middleware	1
