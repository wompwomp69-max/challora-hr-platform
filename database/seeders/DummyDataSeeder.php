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
    public function run(): void
    {
        // Use Laravel's fake() helper — works in production (no fakerphp/faker dev dep needed)
        $faker = fake('id_ID');

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

        $allSkills  = ['PHP', 'Laravel', 'React', 'Vue', 'Node.js', 'Python', 'SQL', 'AWS', 'Docker', 'Git', 'Figma', 'Agile'];
        $allBenefits = ['Gaji Kompetitif', 'Asuransi Kesehatan', 'Bonus Tahunan', 'Remote Work', 'Pelatihan & Sertifikasi', 'BPJS'];
        $cities     = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang', 'Makassar', 'Denpasar'];

        $jobs = [];
        foreach ($jobTitles as $title) {
            $skillCount   = rand(3, 6);
            $benefitCount = rand(2, 4);
            $shuffledSkills   = $allSkills;
            $shuffledBenefits = $allBenefits;
            shuffle($shuffledSkills);
            shuffle($shuffledBenefits);

            $jobs[] = JobPosting::create([
                'title'           => $title,
                'description'     => "Kami sedang mencari {$title} yang berbakat untuk bergabung dengan tim kami. " . $faker->paragraph(3),
                'short_description' => "Lowongan kerja {$title} di perusahaan teknologi terkemuka.",
                'location'        => $faker->randomElement($cities),
                'salary_range'    => 'Rp ' . rand(5, 10) . 'jt - Rp ' . rand(11, 25) . 'jt',
                'min_salary'      => rand(5000000, 10000000),
                'max_salary'      => rand(11000000, 30000000),
                'job_type'        => $faker->randomElement(JobType::cases()),
                'min_education'   => $faker->randomElement(EducationLevel::cases()),
                'is_urgent'       => rand(0, 4) === 0,
                'provinsi'        => $faker->randomElement(['DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'Jawa Tengah', 'Bali']),
                'kota'            => $faker->randomElement($cities),
                'kecamatan'       => 'Kec. ' . $faker->randomElement(['Menteng', 'Kebayoran', 'Cibiru', 'Lowokwaru', 'Denpasar Utara']),
                'deadline'        => now()->addDays(rand(14, 45)),
                'max_applicants'  => rand(30, 150),
                'skills_json'     => array_slice($shuffledSkills, 0, $skillCount),
                'benefits_json'   => array_slice($shuffledBenefits, 0, $benefitCount),
                'experience_level' => $faker->randomElement(ExperienceLevel::cases()),
                'created_by'      => $hr->id,
            ]);
        }

        // 3. Create 10 Regular Users with full profiles
        $majors     = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Ilmu Komunikasi', 'Teknik Elektro', 'Psikologi'];
        $religions  = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
        $eduLevels  = ['S1', 'D3', 'SMA/SMK'];
        $jobTitlesSimple = ['Programmer', 'Desainer', 'Analis', 'Konsultan', 'Manajer Proyek', 'Akuntan', 'Marketing'];
        $companies  = ['PT Maju Bersama', 'CV Teknologi Nusantara', 'PT Digital Solusi', 'Startup Inovasi', 'PT Global Tech', 'CV Kreatif Media'];

        $maleNames   = ['Andi Pratama', 'Budi Setiawan', 'Cahyo Nugroho', 'Deni Firmansyah', 'Eko Saputra', 'Fajar Hidayat', 'Gilang Ramadhan'];
        $femaleNames = ['Sari Dewi', 'Rina Kusuma', 'Tika Rahayu', 'Wulan Sari', 'Yuni Astuti', 'Nadia Putri', 'Laras Ayu'];

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $isMale  = ($i % 2 === 1);
            $gender  = $isMale ? 'Laki-laki' : 'Perempuan';
            $namePool = $isMale ? $maleNames : $femaleNames;
            $name    = $namePool[($i - 1) % count($namePool)];
            $major   = $majors[array_rand($majors)];
            $jobRole = $jobTitlesSimple[array_rand($jobTitlesSimple)];

            $user = User::firstOrCreate(
                ['email' => "user{$i}@challora.com"],
                [
                    'name'                 => $name,
                    'password'             => Hash::make('password'),
                    'role'                 => UserRole::USER,
                    'phone'                => '08' . rand(100000000, 999999999),
                    'address'              => 'Jl. ' . $faker->randomElement(['Merdeka', 'Sudirman', 'Gatot Subroto', 'Diponegoro']) . ' No. ' . rand(1, 99) . ', ' . $faker->randomElement($cities),
                    'father_name'          => 'Bapak ' . $faker->randomElement(['Suharto', 'Bambang', 'Sutrisno', 'Agus', 'Hendra']),
                    'mother_name'          => 'Ibu ' . $faker->randomElement(['Sri', 'Siti', 'Dewi', 'Ratna', 'Endah']),
                    'marital_status'       => $faker->randomElement(['Lajang', 'Menikah']),
                    'education_level'      => $faker->randomElement($eduLevels),
                    'graduation_year'      => rand(2018, 2024),
                    'education_major'      => $major,
                    'education_university' => $faker->randomElement(['Universitas Indonesia', 'ITB', 'UGM', 'ITS', 'Universitas Brawijaya', 'BINUS University']),
                    'gender'               => $gender,
                    'religion'             => $faker->randomElement($religions),
                    'social_media'         => 'linkedin.com/in/' . strtolower(str_replace(' ', '-', $name)),
                    'birth_place'          => $faker->randomElement($cities),
                    'birth_date'           => date('Y-m-d', mktime(0, 0, 0, rand(1, 12), rand(1, 28), rand(1995, 2002))),
                    'father_job'           => $faker->randomElement($jobTitlesSimple),
                    'mother_job'           => $faker->randomElement(['Ibu Rumah Tangga', 'Guru', 'Perawat', 'Pedagang']),
                    'father_education'     => $faker->randomElement($eduLevels),
                    'mother_education'     => $faker->randomElement($eduLevels),
                    'father_phone'         => '08' . rand(100000000, 999999999),
                    'mother_phone'         => '08' . rand(100000000, 999999999),
                    'address_type'         => $faker->randomElement(['Domisili', 'KTP']),
                    'address_family'       => 'Jl. Keluarga No. ' . rand(1, 50) . ', ' . $faker->randomElement($cities),
                    'emergency_name'       => 'Kontak ' . $faker->randomElement(['Darurat', 'Keluarga']),
                    'emergency_phone'      => '08' . rand(100000000, 999999999),
                    'user_summary'         => "Saya adalah {$jobRole} dengan latar belakang {$major}. Berpengalaman dalam lingkungan kerja yang dinamis dan berorientasi pada hasil. Memiliki kemampuan komunikasi yang baik dan mampu bekerja dalam tim maupun mandiri.",
                ]
            );

            // Work Experiences (2-3 per user)
            $expCount = rand(2, 3);
            for ($j = 0; $j < $expCount; $j++) {
                $startYear = rand(2018, 2022);
                UserWorkExperience::create([
                    'user_id'      => $user->id,
                    'title'        => $faker->randomElement($jobTitlesSimple),
                    'company_name' => $faker->randomElement($companies),
                    'year_start'   => $startYear,
                    'year_end'     => $startYear + rand(1, 3),
                    'description'  => "Bertanggung jawab atas pengembangan dan pemeliharaan sistem. Berkolaborasi dengan tim lintas fungsi untuk mencapai target perusahaan. Meningkatkan efisiensi proses sebesar " . rand(10, 40) . "%.",
                ]);
            }

            // Achievements (1-2 per user)
            $achCount = rand(1, 2);
            for ($k = 0; $k < $achCount; $k++) {
                UserAchievement::create([
                    'user_id'          => $user->id,
                    'type'             => $faker->randomElement(['Sertifikat', 'Penghargaan', 'Lomba']),
                    'title'            => $faker->randomElement(['Juara Hackathon', 'Sertifikasi AWS', 'Best Employee', 'Lomba Inovasi', 'Google Developer Certification']),
                    'description'      => 'Penghargaan atas kontribusi dan prestasi di bidang teknologi.',
                    'organizer'        => $faker->randomElement(['Google', 'Microsoft', 'Kemenkominfo', 'Universitas Indonesia', 'AWS']),
                    'year'             => rand(2020, 2024),
                    'rank'             => $faker->randomElement(['Juara 1', 'Juara 2', 'Finalis', 'Peserta Terbaik']),
                    'level'            => $faker->randomElement(['Nasional', 'Internasional', 'Provinsi']),
                ]);
            }

            $users[] = $user;
        }

        // 4. Each user applies to 3 random jobs
        foreach ($users as $user) {
            $shuffledJobs = $jobs;
            shuffle($shuffledJobs);
            $picked = array_slice($shuffledJobs, 0, 3);

            foreach ($picked as $job) {
                // Avoid duplicate applications
                $exists = Application::where('user_id', $user->id)->where('job_id', $job->id)->exists();
                if (!$exists) {
                    Application::create([
                        'user_id'      => $user->id,
                        'job_id'       => $job->id,
                        'status'       => $faker->randomElement(ApplicationStatus::cases()),
                        'cv_path'      => null,
                        'diploma_path' => null,
                        'photo_path'   => null,
                    ]);
                }
            }
        }
    }
}
