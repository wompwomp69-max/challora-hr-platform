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
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Create 1 HR User
        $hr = User::create([
            'name' => 'Budi Santoso (HR Manager)',
            'email' => 'hr@challora.com',
            'password' => Hash::make('password'),
            'role' => UserRole::HR,
            'phone' => '081234567890',
            'address' => 'Jl. Jenderal Sudirman No. 1, Jakarta Pusat',
            'user_summary' => 'HR Manager profesional dengan pengalaman lebih dari 10 tahun di bidang rekrutmen IT.',
        ]);

        // 2. Create 30 Job Listings
        $jobTitles = [
            'Software Engineer', 'Frontend Developer', 'Backend Developer', 'UI/UX Designer',
            'Product Manager', 'Data Analyst', 'Marketing Specialist', 'Sales Executive',
            'HR Generalist', 'Accounting Manager', 'DevOps Engineer', 'Mobile Developer',
            'Content Writer', 'Graphic Designer', 'Customer Service', 'Operations Manager',
            'QA Engineer', 'System Administrator', 'Network Engineer', 'Social Media Manager',
            'Business Development', 'Project Manager', 'Technical Lead', 'Cloud Architect',
            'Fullstack Developer', 'Data Scientist', 'Security Analyst', 'Legal Counsel',
            'Office Administrator', 'Warehouse Supervisor'
        ];

        $skills = ['PHP', 'Laravel', 'React', 'Vue', 'Node.js', 'Python', 'SQL', 'AWS', 'Docker', 'Git', 'Figma', 'Agile'];
        $benefits = ['Gaji Kompetitif', 'Asuransi Kesehatan', 'Bonus Tahunan', 'Remote Work', 'Pelatihan & Sertifikasi', 'BPJS'];

        $jobs = [];
        foreach ($jobTitles as $title) {
            $jobs[] = JobPosting::create([
                'title' => $title,
                'description' => "Kami sedang mencari {$title} yang berbakat untuk bergabung dengan tim kami. " . $faker->paragraph(3),
                'short_description' => "Lowongan kerja {$title} di perusahaan teknologi terkemuka.",
                'location' => $faker->city,
                'salary_range' => 'Rp ' . number_format($faker->numberBetween(5, 10), 0, ',', '.') . 'jt - Rp ' . number_format($faker->numberBetween(11, 25), 0, ',', '.') . 'jt',
                'min_salary' => $faker->numberBetween(5000000, 10000000),
                'max_salary' => $faker->numberBetween(11000000, 30000000),
                'job_type' => $faker->randomElement(JobType::cases()),
                'min_education' => $faker->randomElement(EducationLevel::cases()),
                'is_urgent' => $faker->boolean(20),
                'provinsi' => $faker->state,
                'kota' => $faker->city,
                'kecamatan' => $faker->citySuffix,
                'deadline' => now()->addDays($faker->numberBetween(14, 45)),
                'max_applicants' => $faker->numberBetween(30, 150),
                'skills_json' => $faker->randomElements($skills, $faker->numberBetween(3, 6)),
                'benefits_json' => $faker->randomElements($benefits, $faker->numberBetween(2, 4)),
                'experience_level' => $faker->randomElement(ExperienceLevel::cases()),
                'created_by' => $hr->id,
            ]);
        }

        // 3. Create 10 Regular Users with diverse profiles
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $user = User::create([
                'name' => $faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role' => UserRole::USER,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'father_name' => $faker->name('male'),
                'mother_name' => $faker->name('female'),
                'marital_status' => $faker->randomElement(['Lajang', 'Menikah', 'Cerai']),
                'education_level' => $faker->randomElement(['S1', 'D3', 'SMA/SMK']),
                'graduation_year' => $faker->year,
                'education_major' => $faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Ilmu Komunikasi']),
                'education_university' => $faker->company . ' University',
                'gender' => $gender,
                'religion' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu']),
                'social_media' => '@' . $faker->userName,
                'birth_place' => $faker->city,
                'birth_date' => $faker->date('Y-m-d', '2002-01-01'),
                'father_job' => $faker->jobTitle,
                'mother_job' => $faker->jobTitle,
                'father_education' => $faker->randomElement(['S1', 'D3', 'SMA']),
                'mother_education' => $faker->randomElement(['S1', 'D3', 'SMA']),
                'father_phone' => $faker->phoneNumber,
                'mother_phone' => $faker->phoneNumber,
                'address_type' => $faker->randomElement(['Domisili', 'KTP']),
                'address_family' => $faker->address,
                'emergency_name' => $faker->name,
                'emergency_phone' => $faker->phoneNumber,
                'user_summary' => "Halo, saya adalah profesional yang berdedikasi di bidang " . $faker->jobTitle . ". " . $faker->paragraph,
            ]);

            // Add Work Experiences
            for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                UserWorkExperience::create([
                    'user_id' => $user->id,
                    'title' => $faker->jobTitle,
                    'company_name' => $faker->company,
                    'year_start' => $faker->year(2020),
                    'year_end' => $faker->year(2024),
                    'description' => $faker->sentence(15),
                ]);
            }

            // Add Achievements
            for ($k = 0; $k < $faker->numberBetween(1, 2); $k++) {
                UserAchievement::create([
                    'user_id' => $user->id,
                    'type' => $faker->randomElement(['Sertifikat', 'Penghargaan', 'Lomba']),
                    'title' => $faker->sentence(4),
                    'description' => $faker->sentence(10),
                    'organizer' => $faker->company,
                    'year' => $faker->year,
                    'rank' => $faker->randomElement(['Juara 1', 'Juara 2', 'Finalis']),
                    'level' => $faker->randomElement(['Nasional', 'Internasional', 'Provinsi']),
                ]);
            }

            $users[] = $user;
        }

        // 4. Create 3 random applied jobs for each user
        foreach ($users as $user) {
            $randomJobs = collect($jobs)->random(3);
            foreach ($randomJobs as $job) {
                Application::create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                    'status' => $faker->randomElement(ApplicationStatus::cases()),
                    'cv_path' => 'dummy/cv.pdf',
                    'diploma_path' => 'dummy/diploma.pdf',
                    'photo_path' => 'dummy/photo.jpg',
                ]);
            }
        }
    }
}
