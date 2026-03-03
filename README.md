# HR Recruitment App

Aplikasi rekrutmen dengan 2 role: **HR** dan **User (kandidat)**. Satu app, satu MVC, pisah di controller, view, route prefix.

## Struktur

```
project-root/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── JobController.php
│   │   ├── ApplicationController.php
│   │   ├── HrJobController.php
│   │   ├── HrApplicationController.php
│   │   ├── UserController.php
│   │   └── DownloadController.php
│   ├── models/
│   │   ├── User.php
│   │   ├── Job.php
│   │   └── Application.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   ├── footer.php
│       │   ├── user.php    (layout clean, navbar)
│       │   └── hr.php      (layout admin, sidebar)
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── user/
│       │   ├── jobs/index.php, show.php
│       │   ├── applications/index.php
│       │   └── settings/index.php, edit.php
│       └── hr/
│           ├── jobs/index.php, create.php, edit.php
│           └── applications/index.php
├── core/
│   ├── Database.php
│   ├── Controller.php
│   └── helpers.php
├── config/
│   ├── database.php
│   └── app.php
├── database/       schema.sql, migration_cv_and_status.sql
├── storage/cv/
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── assets/css/, assets/js/
└── .htaccess (optional)
```

## Routing

| Method | URL | Controller |
|--------|-----|------------|
| GET | /jobs | JobController@index |
| GET | /jobs/show?id= | JobController@show |
| POST | /jobs/apply | ApplicationController@store |
| GET | /applications | ApplicationController@index |
| GET | /user/settings | UserController@profile |
| GET/POST | /user/settings/edit | UserController@profileEdit |
| GET | /hr/jobs | HrJobController@index |
| GET/POST | /hr/jobs/create | HrJobController@create |
| GET/POST | /hr/jobs/edit?id= | HrJobController@edit |
| POST | /hr/jobs/delete | HrJobController@delete |
| GET | /hr/jobs/applicants?id= | HrApplicationController@index |
| POST | /hr/applications/update-status | HrApplicationController@updateStatus |
| GET | /download/cv?id= | DownloadController@cv |

## Layout

- **user layout**: auth, jobs, applications, settings → navbar clean
- **hr layout**: hr/* → sidebar admin
- `render_view()` otomatis pilih layout berdasarkan path view (hr/* → hr, lain → user)

## Setup

1. Import `database/schema.sql`
2. Edit `config/database.php` dan `config/app.php` (BASE_URL)
3. Pastikan `storage/cv/` writable
4. Akses `http://localhost/challorav2/public/`

## Akun default

- HR: `hr@example.com` / `password123`
