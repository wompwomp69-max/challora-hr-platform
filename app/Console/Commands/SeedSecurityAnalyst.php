<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserWorkExperience;
use App\Models\UserAchievement;
use App\Models\UserOrganizationalExperience;
use App\Models\Application;
use App\Models\JobPosting;
use App\Enums\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SeedSecurityAnalyst extends Command
{
    protected $signature = 'db:seed-security-analyst {--force}';
    protected $description = 'Seed a security analyst candidate for testing';

    public function handle(): int
    {
        $email = 'security.candidate@challora.com';

        if (User::where('email', $email)->exists()) {
            if (!$this->option('force')) {
                $this->warn('User already exists. Use --force to re-create.');
                return self::SUCCESS;
            }
            $this->warn('User exists. Deleting and recreating...');
            User::where('email', $email)->delete();
        }

        $user = User::create([
            'name' => 'Rizki Abdullah',
            'email' => $email,
            'password' => Hash::make('123123123'),
            'role' => UserRole::USER,
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka Selatan No. 12, Jakarta Selatan, 12190',
            'father_name' => 'Bapak Hendra Wijaya',
            'mother_name' => 'Ibu Siti Rahayu',
            'marital_status' => 'Single',
            'education_level' => 'S1',
            'graduation_year' => '2021',
            'education_major' => 'Teknik Informatika',
            'education_university' => 'Universitas Indonesia',
            'gender' => 'Laki-laki',
            'religion' => 'Islam',
            'social_media' => 'linkedin.com/in/rizki-abdullah-security',
            'birth_place' => 'Jakarta',
            'birth_date' => '1999-03-15',
            'father_job' => 'Karyawan Swasta',
            'mother_job' => 'Guru',
            'father_education' => 'S1',
            'mother_education' => 'S1',
            'father_phone' => '081987654321',
            'mother_phone' => '081912345678',
            'address_type' => 'Domisili',
            'address_family' => 'Jl. Melati No. 5, Jakarta Pusat, 10110',
            'emergency_name' => 'Bapak Hendra Wijaya',
            'emergency_phone' => '081987654321',
            'user_summary' => 'Security Analyst dengan pengalaman 4+ tahun di bidang cybersecurity. Spesialisasi dalam penetration testing, SIEM implementation, dan incident response. Memiliki pemahaman mendalam tentang NIST Framework dan ISO 27001. Passionate dalam threat hunting dan vulnerability assessment untuk melindungi infrastruktur organisasi dari serangan siber.',
            'skills' => 'Penetration Testing, SIEM, Network Security, Python, Bash, Metasploit, Burp Suite, Wireshark, Nmap, OWASP Top 10, NIST Framework, ISO 27001, Incident Response, Log Analysis, Vulnerability Assessment',
        ]);

        $this->info("User created: {$user->id}");

        UserWorkExperience::insert([
            [
                'user_id' => $user->id, 'title' => 'SOC Analyst',
                'company_name' => 'PT CyberDefense Indonesia',
                'year_start' => '2022', 'year_end' => '2024',
                'description' => 'Monitor keamanan jaringan 24/7 menggunakan SIEM Splunk dan Microsoft Sentinel. Melakukan analisis log dan korelasi event untuk mendeteksi ancaman siber. Menangani incident security dengan prosedur playbooks. Threat hunting proaktif menggunakan IOC dari threat intelligence feeds.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'user_id' => $user->id, 'title' => 'Junior Penetration Tester',
                'company_name' => 'Ethical Hacking Corp',
                'year_start' => '2020', 'year_end' => '2022',
                'description' => 'Melakukan penetration testing pada web aplikasi, infrastructure, dan mobile apps. Menggunakan Burp Suite, Metasploit, Nmap untuk mengidentifikasi vulnerabilities. Menyusun laporan teknis dan executive summary untuk klien.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'user_id' => $user->id, 'title' => 'IT Security Intern',
                'company_name' => 'Startup Fintech - PT Finova Digital',
                'year_start' => '2019', 'year_end' => '2020',
                'description' => 'Assisted senior security engineers dalam monitoring keamanan sistem payment gateway. Melakukan vulnerability scanning dan membantu remediasi findings. Membantu implementasi security controls sesuai compliance PCI-DSS.',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
        $this->info('Work experiences created.');

        UserAchievement::insert([
            [
                'user_id' => $user->id, 'type' => 'Sertifikat', 'title' => 'Certified Ethical Hacker (CEH)',
                'description' => 'Sertifikasi ethical hacking dari EC-Council mencakup 20 modul keamanan siber.',
                'organizer' => 'EC-Council', 'year' => '2022', 'rank' => 'Certified',
                'level' => 'Internasional', 'certificate_link' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'user_id' => $user->id, 'type' => 'Sertifikat', 'title' => 'CompTIA Security+',
                'description' => 'Sertifikasi keamanan IT yang memvalidasi foundational security skills.',
                'organizer' => 'CompTIA', 'year' => '2021', 'rank' => 'Certified',
                'level' => 'Internasional', 'certificate_link' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'user_id' => $user->id, 'type' => 'Sertifikat', 'title' => 'ISO 27001 Lead Auditor',
                'description' => 'Training dan sertifikasi untuk audit sistem manajemen keamanan informasi ISO 27001.',
                'organizer' => 'BSI Group', 'year' => '2023', 'rank' => 'Lead Auditor',
                'level' => 'Internasional', 'certificate_link' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'user_id' => $user->id, 'type' => 'Lomba', 'title' => 'Finalis National CTF Competition - Cybersecurity Week 2023',
                'description' => 'Finalis kompetisi Capture The Flag nasional. Web exploitation, cryptography, forensics, reverse engineering.',
                'organizer' => 'BNN dan Kemkominfo', 'year' => '2023', 'rank' => 'Finalis',
                'level' => 'Nasional', 'certificate_link' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
        $this->info('Achievements created.');

        UserOrganizationalExperience::create([
            'user_id' => $user->id,
            'organization_name' => 'Indonesian Cybersecurity Community (IDC)',
            'position' => 'Member & Active Contributor',
            'start_year' => '2021', 'year_end' => null,
            'description' => 'Bergabung dalam komunitas profesional cybersecurity Indonesia. Aktif berkontribusi dalam diskusi teknis dan collaborative security research.',
        ]);
        $this->info('Organizational experience created.');

        $jobId = \App\Models\JobPosting::where('title', 'like', '%Security%')->first()?->id ?? 29;
        Application::create([
            'user_id' => $user->id, 'job_id' => $jobId,
            'status' => 'pending', 'cv_path' => null, 'diploma_path' => null, 'photo_path' => null,
        ]);
        $this->info("Application created for job ID: {$jobId}");

        $this->info('DONE - Candidate ID: ' . $user->id);
        $this->info('Email: security.candidate@challora.com / Password: 123123123');

        return self::SUCCESS;
    }
}