<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Application;
use App\Models\UserWorkExperience;
use App\Models\UserAchievement;
use App\Enums\UserRole;
use App\Enums\JobType;
use App\Enums\EducationLevel;
use App\Enums\ExperienceLevel;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    private function pick(array $arr): mixed
    {
        return $arr[array_rand($arr)];
    }

    public function run(): void
    {
        // No Faker — fully static data, works in production with --no-dev

        // 1. Create HR User (skip if already exists)
        $hr = User::firstOrCreate(
            ['email' => 'hr@challora.com'],
            [
                'name'         => 'Budi Santoso (HR Manager)',
                'password'     => Hash::make('password'),
                'role'         => UserRole::HR,
                'phone'        => '081234567890',
                'address'      => 'Jl. Jenderal Sudirman No. 1, Jakarta Pusat',
                'user_summary' => 'HR Manager profesional dengan pengalaman lebih dari 10 tahun di bidang rekrutmen IT.',
            ]
        );

        // 2. Create 30 Job Listings
        $jobTitles = [
            'Software Engineer', 'Frontend Developer', 'Backend Developer', 'UI/UX Designer',
            'Product Manager', 'Data Analyst', 'Marketing Specialist', 'Sales Executive',
            'HR Generalist', 'Accounting Manager', 'DevOps Engineer', 'Mobile Developer',
            'Content Writer', 'Graphic Designer', 'Customer Service', 'Operations Manager',
            'QA Engineer', 'System Administrator', 'Network Engineer', 'Social Media Manager',
            'Business Development', 'Project Manager', 'Technical Lead', 'Cloud Architect',
            'Fullstack Developer', 'Data Scientist', 'Security Analyst', 'Legal Counsel',
            'Office Administrator', 'Warehouse Supervisor',
        ];

        $allSkills   = ['PHP', 'Laravel', 'React', 'Vue', 'Node.js', 'Python', 'SQL', 'AWS', 'Docker', 'Git', 'Figma', 'Agile'];
        $allBenefits = ['Gaji Kompetitif', 'Asuransi Kesehatan', 'Bonus Tahunan', 'Remote Work', 'Pelatihan & Sertifikasi', 'BPJS'];
        $cities      = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang', 'Makassar', 'Denpasar'];
        $provinces   = ['DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'Jawa Tengah', 'Bali'];
        $kecamatans  = ['Menteng', 'Kebayoran', 'Cibiru', 'Lowokwaru', 'Denpasar Utara'];
        $jobTypes    = JobType::cases();
        $eduLevels   = EducationLevel::cases();
        $expLevels   = ExperienceLevel::cases();
        $statuses    = ApplicationStatus::cases();

        $jobs = [];
        foreach ($jobTitles as $idx => $title) {
            shuffle($allSkills);
            shuffle($allBenefits);
            $jobs[] = JobPosting::create([
                'title'            => $title,
                'description'      => "Kami sedang mencari {$title} yang berbakat untuk bergabung dengan tim kami. Kandidat akan bertanggung jawab atas pengembangan, pemeliharaan, dan peningkatan sistem yang ada. Kami mencari individu yang proaktif, mampu bekerja dalam tim, dan memiliki semangat belajar tinggi.",
                'short_description' => "Lowongan kerja {$title} di perusahaan teknologi terkemuka.",
                'location'         => $this->pick($cities),
                'salary_range'     => 'Rp ' . rand(5, 10) . 'jt - Rp ' . rand(11, 25) . 'jt',
                'min_salary'       => rand(5000000, 10000000),
                'max_salary'       => rand(11000000, 30000000),
                'job_type'         => $this->pick($jobTypes),
                'min_education'    => $this->pick($eduLevels),
                'is_urgent'        => ($idx % 5 === 0),
                'provinsi'         => $this->pick($provinces),
                'kota'             => $this->pick($cities),
                'kecamatan'        => 'Kec. ' . $this->pick($kecamatans),
                'deadline'         => now()->addDays(rand(14, 45)),
                'max_applicants'   => rand(30, 150),
                'skills_json'      => array_slice($allSkills, 0, rand(3, 6)),
                'benefits_json'    => array_slice($allBenefits, 0, rand(2, 4)),
                'experience_level' => $this->pick($expLevels),
                'created_by'       => $hr->id,
            ]);
        }

        // 3. Create 10 Regular Users with full profiles — no Faker
        $streets   = ['Merdeka', 'Sudirman', 'Gatot Subroto', 'Diponegoro', 'Imam Bonjol'];
        $fatherFirstNames = ['Suharto', 'Bambang', 'Sutrisno', 'Agus', 'Hendra', 'Wahyu', 'Joko', 'Rudi', 'Darmawan', 'Sigit'];
        $motherFirstNames = ['Sri', 'Siti', 'Dewi', 'Ratna', 'Endah', 'Yanti', 'Wati', 'Lestari', 'Murni', 'Suci'];
        $univs     = ['Universitas Indonesia', 'ITB', 'UGM', 'ITS', 'Universitas Brawijaya', 'BINUS University'];
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha'];
        $eduStr    = ['S1', 'D3', 'SMA/SMK'];
        $fatherJobs = ['PNS', 'Wiraswasta', 'Karyawan Swasta', 'Guru', 'Dokter'];
        $motherJobs = ['Ibu Rumah Tangga', 'Guru', 'Perawat', 'Pedagang', 'PNS'];

        $userData = [
            ['name'=>'Andi Pratama',    'gender'=>'Laki-laki', 'major'=>'Teknik Informatika', 'univ'=>'Universitas Indonesia', 'role'=>'Backend Developer',    'city'=>'Jakarta'],
            ['name'=>'Sari Dewi',       'gender'=>'Perempuan', 'major'=>'Sistem Informasi',   'univ'=>'ITB',                   'role'=>'UI/UX Designer',       'city'=>'Bandung'],
            ['name'=>'Budi Setiawan',   'gender'=>'Laki-laki', 'major'=>'Teknik Elektro',     'univ'=>'ITS',                   'role'=>'DevOps Engineer',      'city'=>'Surabaya'],
            ['name'=>'Rina Kusuma',     'gender'=>'Perempuan', 'major'=>'Manajemen',           'univ'=>'UGM',                   'role'=>'Product Manager',      'city'=>'Yogyakarta'],
            ['name'=>'Cahyo Nugroho',   'gender'=>'Laki-laki', 'major'=>'Ilmu Komunikasi',    'univ'=>'Universitas Brawijaya', 'role'=>'Marketing Specialist', 'city'=>'Malang'],
            ['name'=>'Tika Rahayu',     'gender'=>'Perempuan', 'major'=>'Akuntansi',           'univ'=>'BINUS University',      'role'=>'Data Analyst',         'city'=>'Jakarta'],
            ['name'=>'Deni Firmansyah', 'gender'=>'Laki-laki', 'major'=>'Teknik Informatika', 'univ'=>'Universitas Indonesia', 'role'=>'Frontend Developer',   'city'=>'Depok'],
            ['name'=>'Wulan Sari',      'gender'=>'Perempuan', 'major'=>'Psikologi',           'univ'=>'UGM',                   'role'=>'HR Generalist',        'city'=>'Yogyakarta'],
            ['name'=>'Eko Saputra',     'gender'=>'Laki-laki', 'major'=>'Sistem Informasi',   'univ'=>'ITS',                   'role'=>'Fullstack Developer',  'city'=>'Surabaya'],
            ['name'=>'Nadia Putri',     'gender'=>'Perempuan', 'major'=>'Teknik Informatika', 'univ'=>'ITB',                   'role'=>'Data Scientist',       'city'=>'Bandung'],
        ];

        $workPool = [
            ['title'=>'Junior Developer',   'company'=>'PT Maju Bersama',        'desc'=>'Mengembangkan fitur baru pada aplikasi web menggunakan Laravel dan React. Berkolaborasi dengan tim desain untuk implementasi UI.'],
            ['title'=>'Software Engineer',  'company'=>'CV Teknologi Nusantara', 'desc'=>'Bertanggung jawab atas arsitektur backend sistem e-commerce. Meningkatkan performa query database sebesar 35%.'],
            ['title'=>'Frontend Developer', 'company'=>'PT Digital Solusi',      'desc'=>'Membangun antarmuka pengguna responsif menggunakan Vue.js dan Tailwind CSS dalam metodologi Agile.'],
            ['title'=>'Data Analyst',       'company'=>'Startup Inovasi',        'desc'=>'Menganalisis data penjualan dan membuat dashboard laporan menggunakan Python dan Tableau.'],
            ['title'=>'IT Support',         'company'=>'PT Global Tech',         'desc'=>'Memberikan dukungan teknis kepada 200+ pengguna internal. Mengelola infrastruktur jaringan kantor.'],
            ['title'=>'UI Designer',        'company'=>'CV Kreatif Media',       'desc'=>'Merancang wireframe dan prototype aplikasi mobile menggunakan Figma. Melakukan user research dan usability testing.'],
        ];

        $achPool = [
            ['title'=>'Juara 1 Hackathon Nasional',    'type'=>'Lomba',       'org'=>'Kemenkominfo',           'rank'=>'Juara 1', 'level'=>'Nasional'],
            ['title'=>'AWS Certified Developer',       'type'=>'Sertifikat',  'org'=>'Amazon Web Services',   'rank'=>'Lulus',   'level'=>'Internasional'],
            ['title'=>'Google IT Support Certificate', 'type'=>'Sertifikat',  'org'=>'Google',                'rank'=>'Lulus',   'level'=>'Internasional'],
            ['title'=>'Best Employee Q3',              'type'=>'Penghargaan', 'org'=>'PT Digital Solusi',     'rank'=>'Terbaik', 'level'=>'Perusahaan'],
            ['title'=>'Finalis Lomba Inovasi Digital', 'type'=>'Lomba',       'org'=>'Universitas Indonesia', 'rank'=>'Finalis', 'level'=>'Nasional'],
            ['title'=>'Microsoft Azure Fundamentals',  'type'=>'Sertifikat',  'org'=>'Microsoft',             'rank'=>'Lulus',   'level'=>'Internasional'],
        ];

        $users = [];
        foreach ($userData as $i => $u) {
            $num = $i + 1;
            $user = User::firstOrCreate(
                ['email' => "user{$num}@challora.com"],
                [
                    'name'                 => $u['name'],
                    'password'             => Hash::make('password'),
                    'role'                 => UserRole::USER,
                    'phone'                => '08' . str_pad((string)rand(100000000, 999999999), 9, '0'),
                    'address'              => 'Jl. ' . $streets[$i % count($streets)] . ' No. ' . rand(1, 99) . ', ' . $u['city'],
                    'father_name'          => 'Bapak ' . $fatherFirstNames[$i],
                    'mother_name'          => 'Ibu ' . $motherFirstNames[$i],
                    'marital_status'       => $i < 7 ? 'Lajang' : 'Menikah',
                    'education_level'      => 'S1',
                    'graduation_year'      => 2018 + ($i % 6),
                    'education_major'      => $u['major'],
                    'education_university' => $u['univ'],
                    'gender'               => $u['gender'],
                    'religion'             => $religions[$i % count($religions)],
                    'social_media'         => 'linkedin.com/in/' . strtolower(str_replace(' ', '-', $u['name'])),
                    'birth_place'          => $u['city'],
                    'birth_date'           => date('Y-m-d', mktime(0, 0, 0, ($i % 12) + 1, ($i % 28) + 1, 1995 + $i)),
                    'father_job'           => $fatherJobs[$i % count($fatherJobs)],
                    'mother_job'           => $motherJobs[$i % count($motherJobs)],
                    'father_education'     => $eduStr[$i % count($eduStr)],
                    'mother_education'     => $eduStr[($i + 1) % count($eduStr)],
                    'father_phone'         => '08' . str_pad((string)rand(100000000, 999999999), 9, '0'),
                    'mother_phone'         => '08' . str_pad((string)rand(100000000, 999999999), 9, '0'),
                    'address_type'         => 'Domisili',
                    'address_family'       => 'Jl. Keluarga No. ' . rand(1, 50) . ', ' . $u['city'],
                    'emergency_name'       => 'Bapak ' . $fatherFirstNames[$i],
                    'emergency_phone'      => '08' . str_pad((string)rand(100000000, 999999999), 9, '0'),
                    'user_summary'         => "Saya adalah {$u['role']} dengan latar belakang {$u['major']} dari {$u['univ']}. Berpengalaman dalam lingkungan kerja yang dinamis dan berorientasi pada hasil. Memiliki kemampuan komunikasi yang baik dan mampu bekerja dalam tim maupun mandiri.",
                ]
            );

            if ($user->wasRecentlyCreated) {
                $expCount = ($i % 3) + 1;
                for ($j = 0; $j < $expCount; $j++) {
                    $w = $workPool[($i + $j) % count($workPool)];
                    UserWorkExperience::create([
                        'user_id'      => $user->id,
                        'title'        => $w['title'],
                        'company_name' => $w['company'],
                        'year_start'   => 2019 + $j,
                        'year_end'     => 2020 + $j + ($i % 2),
                        'description'  => $w['desc'],
                    ]);
                }

                $achCount = ($i % 2) + 1;
                for ($k = 0; $k < $achCount; $k++) {
                    $a = $achPool[($i + $k) % count($achPool)];
                    UserAchievement::create([
                        'user_id'     => $user->id,
                        'type'        => $a['type'],
                        'title'       => $a['title'],
                        'description' => 'Penghargaan atas kontribusi dan prestasi di bidang teknologi.',
                        'organizer'   => $a['org'],
                        'year'        => 2020 + ($i % 5),
                        'rank'        => $a['rank'],
                        'level'       => $a['level'],
                    ]);
                }
            }

            $users[] = $user;
        }

        // 4. Each user applies to 3 random jobs (no duplicates)
        $appStatuses = ApplicationStatus::cases();
        foreach ($users as $idx => $user) {
            $shuffled = $jobs;
            shuffle($shuffled);
            $picked = array_slice($shuffled, 0, 3);
            foreach ($picked as $job) {
                if (!Application::where('user_id', $user->id)->where('job_id', $job->id)->exists()) {
                    Application::create([
                        'user_id'      => $user->id,
                        'job_id'       => $job->id,
                        'status'       => $appStatuses[$idx % count($appStatuses)],
                        'cv_path'      => null,
                        'diploma_path' => null,
                        'photo_path'   => null,
                    ]);
                }
            }
        }
    }
}
