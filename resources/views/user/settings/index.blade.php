@extends('layouts.app')



@section('content')
    <div class="profile-container">
        <a href="{{ route('user.settings.edit') }}" class="btn-edit-float">
            Edit My Profile
        </a>

        <header class="profile-header">
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar-lg">
                    @if($user->avatar_path)
                        <img src="{{ route('avatar') }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span class="text-8xl font-black text-accent opacity-20">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div class="profile-name-section">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <div class="flex items-center gap-3">
                    <span class="profile-role-badge">Candidate</span>
                    <span class="text-sm font-bold text-text-muted italic">{{ $user->email }}</span>
                </div>
            </div>
        </header>

        <div class="profile-grid">
            <div class="profile-main">
                @if($user->user_summary)
                    <section class="info-card">
                        <h2 class="info-card-title">Professional Summary</h2>
                        <p class="summary-text">{{ $user->user_summary }}</p>
                    </section>
                @endif

                <section class="info-card">
                    <h2 class="info-card-title">Personal Data</h2>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="data-row">
                            <span class="data-label">Phone</span>
                            <span class="data-value">{{ $user->phone ?? '—' }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Gender</span>
                            <span
                                class="data-value">{{ $user->gender ? ($user->gender === 'laki-laki' ? 'Male' : 'Female') : '—' }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Address</span>
                            <span class="data-value">{{ $user->address ?? '—' }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Religion</span>
                            <span class="data-value">{{ $user->religion ?? '—' }}</span>
                        </div>
                    </div>
                </section>

                <section class="info-card">
                    <h2 class="info-card-title">Education</h2>
                    @if($user->education_university)
                        <div class="data-row">
                            <span class="data-label">{{ $user->education_level }} in {{ $user->education_major }}</span>
                            <span class="data-value text-2xl">{{ $user->education_university }}</span>
                            <span class="text-sm font-bold text-accent">Class of {{ $user->graduation_year }}</span>
                        </div>
                    @else
                        <p class="text-text-muted italic font-bold">No education history added yet.</p>
                    @endif
                </section>

                <section class="info-card">
                    <h2 class="info-card-title">Work Experience</h2>
                    @forelse($user->workExperiences as $exp)
                        <div class="experience-item">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-black uppercase">{{ $exp->title }}</h3>
                                    <p class="text-accent font-bold">{{ $exp->company_name }}</p>
                                </div>
                                <span class="bg-black text-white px-3 py-1 text-xs font-black">
                                    {{ $exp->year_start }} — {{ $exp->year_end }}
                                </span>
                            </div>
                            <p class="mt-4 text-text-muted font-medium">{{ $exp->description }}</p>
                        </div>
                    @empty
                        <p class="text-text-muted italic font-bold">No work experience added yet.</p>
                    @endforelse
                </section>
            </div>

            <aside class="profile-sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Supporting Documents</h3>
                    @foreach(['cv' => 'CV / Resume', 'diploma' => 'Educational Diploma', 'photo' => 'Formal Photo'] as $key => $label)
                        @php $field = $key . '_path'; @endphp
                        @if($user->$field)
                            <a href="{{ route('preview.user_file', ['type' => $key]) }}" target="_blank" class="doc-link">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="font-bold uppercase text-xs">{{ $label }}</span>
                            </a>
                        @else
                            <div class="doc-link opacity-40 grayscale">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="font-bold uppercase text-xs">{{ $label }} (Empty)</span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="info-card bg-secondary border-dashed">
                    <h3 class="font-black uppercase text-xs mb-4">Account Stats</h3>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between border-b border-border pb-2">
                            <span class="text-[10px] font-black uppercase text-text-muted">Applications</span>
                            <span class="font-black text-accent">{{ $user->applications()->count() }}</span>
                        </div>
                        <div class="flex justify-between border-b border-border pb-2">
                            <span class="text-[10px] font-black uppercase text-text-muted">Saved Jobs</span>
                            <span class="font-black text-accent">{{ $user->savedJobs()->count() }}</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        (function initIndexAnim() {
            if (!window.gsap) return setTimeout(initIndexAnim, 50);

            // Kill existing animations on these targets to prevent conflicts when Swup re-navigates
            window.gsap.killTweensOf(".profile-header, .info-card, .profile-sidebar, .btn-edit-float");

            window.gsap.fromTo(".profile-header",
                { opacity: 0, x: -50 },
                { opacity: 1, x: 0, duration: 1, ease: "power4.out" }
            );
            window.gsap.fromTo(".info-card",
                { opacity: 0, y: 40 },
                { opacity: 1, y: 0, stagger: 0.15, duration: 1.2, ease: "power4.out", delay: 0.2 }
            );
            window.gsap.fromTo(".profile-sidebar",
                { opacity: 0, x: 50 },
                { opacity: 1, x: 0, duration: 1, ease: "power4.out", delay: 0.5 }
            );
            window.gsap.fromTo(".btn-edit-float",
                { scale: 0 },
                { scale: 1, duration: 0.6, ease: "back.out(1.7)", delay: 1 }
            );
        })();
    </script>
@endsection