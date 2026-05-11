@extends('layouts.app')

@push('styles')
<style>
    /* ── SHIFT5 REPLICA STYLES ── */
    :root {
        --s5-orange: #FF4D30;
        --s5-black: #000000;
        --s5-white: #FFFFFF;
        --s5-grey-light: #F4F4F4;
        --s5-grey-mid: #E5E5E5;
        --s5-grey-dark: #888888;
        --nav-height: 80px;
    }

    body, html {
        font-family: "Inter", -apple-system, sans-serif !important;
    }

    /* ── Typography ── */
    .s5-title-mega {
        font-family: "Inter", sans-serif;
        font-size: clamp(4rem, 10vw, 9rem);
        font-weight: 900;
        line-height: 0.85;
        letter-spacing: -0.04em;
        text-transform: none;
    }
    
    .s5-title-section {
        font-family: "Inter", sans-serif;
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .s5-mono {
        font-family: "JetBrains Mono", monospace;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ── Components ── */
    .s5-pill-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 2rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        cursor: pointer;
        visibility: visible !important;
    }
    .s5-pill-primary {
        background-color: var(--s5-orange);
        color: var(--s5-white);
    }
    .s5-pill-primary:hover {
        background-color: #e6452a;
    }
    .s5-pill-outline {
        background-color: transparent;
        color: var(--s5-black);
        border-color: var(--s5-black);
    }
    .s5-pill-outline:hover {
        background-color: var(--s5-black);
        color: var(--s5-white);
        border-color: var(--s5-white);
    }
    .s5-pill-white {
        background-color: var(--s5-white);
        color: var(--s5-black);
    }
    .s5-pill-white:hover {
        background-color: var(--s5-grey-light);
    }

    /* ── Hero Layout (Split Screen) ── */
    .s5-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        width: 100vw;
        position: relative;
        left: 50%; right: 50%;
        margin-left: -50vw; margin-right: -50vw;
        border-bottom: 1px solid var(--s5-grey-mid);
    }

    .s5-hero-left {
        position: relative;
        background-color: var(--s5-grey-light);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 4rem;
        border-right: 1px solid var(--s5-grey-mid);
    }

    .s5-hero-image {
        position: absolute;
        inset: 0;
        background-image: url('/hero.jpg');
        background-size: cover;
        background-position: center;
        filter: grayscale(100%) contrast(1.2) brightness(0.8);
        z-index: 1;
    }

    .s5-hero-left-text {
        position: relative;
        z-index: 2;
        color: var(--s5-white);
        font-size: clamp(1.5rem, 3vw, 2.5rem);
        font-weight: 700;
        line-height: 1.1;
        max-width: 80%;
    }

    .s5-hero-right {
        background-color: var(--s5-black);
        color: var(--s5-white);
        display: flex;
        flex-direction: column;
        padding: calc(var(--nav-height) + 4rem) 4rem 4rem;
        position: relative;
    }

    .s5-hero-right-top {
        flex: 1;
    }

    /* ── System Status Block ── */
    .s5-system-status {
        margin-top: 4rem;
        border-top: 1px solid rgba(255,255,255,0.2);
        padding-top: 2rem;
    }
    .s5-status-title {
        font-size: 1rem;
        color: var(--s5-grey-dark);
        margin-bottom: 1rem;
    }
    .s5-status-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem 2rem;
    }
    .s5-status-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--s5-grey-mid);
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 0.25rem;
    }
    .s5-status-dot {
        width: 6px; height: 6px;
        background-color: var(--s5-orange);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--s5-orange);
    }

    /* ── Solutions Grid ── */
    .s5-section {
        padding: 8rem 4rem;
        max-width: 1600px;
        margin: 0 auto;
    }

    .s5-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-top: 1px solid var(--s5-orange);
        border-left: 1px solid var(--s5-orange);
        margin-top: 4rem;
    }

    .s5-grid-card {
        border-right: 1px solid var(--s5-orange);
        border-bottom: 1px solid var(--s5-orange);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        background: transparent;
        color: var(--s5-white);
        transition: background 0.3s;
    }

    .s5-grid-card:hover {
        background: rgba(255, 77, 48, 0.1);
    }

    .s5-card-title {
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .s5-card-desc {
        color: var(--s5-grey-dark);
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 2rem;
        flex: 1;
    }

    /* ── Marquee ── */
    .s5-marquee {
        background-color: var(--s5-orange);
        color: var(--s5-black);
        padding: 1rem 0;
        overflow: hidden;
        white-space: nowrap;
        font-weight: 800;
        font-size: 1.25rem;
        text-transform: uppercase;
        border-bottom: 1px solid var(--s5-black);
        width: 100vw;
        position: relative;
        left: 50%; right: 50%;
        margin-left: -50vw; margin-right: -50vw;
    }
    .s5-marquee span {
        display: inline-block;
        animation: s5-scroll 30s linear infinite;
    }
    @keyframes s5-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
        .s5-hero { grid-template-columns: 1fr; }
        .s5-hero-left { min-height: 40vh; }
        .s5-grid-4 { grid-template-columns: 1fr 1fr; }
        .s5-hero-right { padding: calc(var(--nav-height) + 2rem) 2rem 2rem; }
        .s5-section { padding: 4rem 1.5rem; }
    }
    @media (max-width: 640px) {
        .s5-grid-4 { grid-template-columns: 1fr; }
        .s5-hero-left, .s5-hero-right { padding: 1.5rem; }
        .s5-hero-right { padding-top: calc(var(--nav-height) + 1.5rem); }
        .s5-title-mega { font-size: clamp(3rem, 15vw, 5rem); }
        .s5-title-section { font-size: clamp(1.5rem, 7vw, 2.5rem); }
        .s5-pill-btn { padding: 0.75rem 1.25rem; font-size: 0.875rem; }
        .s5-system-status { margin-top: 2rem; }
        .s5-status-grid { grid-template-columns: 1fr; }
        .s5-section { padding: 3rem 1rem; }
        .s5-marquee { font-size: 1rem; }
    }
</style>
@endpush

@section('content')
<div class="flex flex-col w-full">

    <!-- HERO SECTION -->
    <section class="s5-hero">
        <!-- Left Side: Image & Tagline -->
        <div class="s5-hero-left">
            <div class="s5-hero-image"><img src="{{ asset('hero.jpg') }}" alt="Hero" style="width:100%;height:100%;object-fit:cover;object-position:center;filter:grayscale(100%) contrast(1.2) brightness(0.8);"></div>
            <!-- Overlay gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-[1]"></div>
            
            <div class="s5-hero-left-text">
                Smarter Hiring for Every Role, Every Team, Every Company.
            </div>
        </div>

        <!-- Right Side: Title & Status -->
        <div class="s5-hero-right">
            <div class="s5-hero-right-top">
                <p class="s5-mono text-sm text-[#888] mb-6">AI-powered recruitment that finds the right person, not just the right keywords.</p>
                <h1 class="s5-title-mega mb-10">
                    HR /<br>Intelligence
                </h1>
                
                <div class="flex gap-4" style="position: relative; z-index: 3;">
                    <a href="{{ route('jobs.index') }}" class="s5-pill-btn s5-pill-primary">
                        Find Jobs
                    </a>
                    <a href="{{ route('register') }}" class="s5-pill-btn s5-pill-outline">
                        Post a Job
                    </a>
                </div>
            </div>

            <div class="s5-system-status">
                <div class="s5-mono s5-status-title">System Status</div>
                <div class="s5-mono s5-status-grid">
                    @php $statuses = [
                        ['01', 'CV Parser'],       ['02', 'Match Engine'],
                        ['03', 'Bias Filter'],      ['04', 'Skill Extractor'],
                        ['05', 'Score Ranking'],    ['06', 'Profile Coach'],
                        ['07', 'Job Indexer'],      ['08', 'Candidate DB'],
                        ['09', 'HR Dashboard'],     ['10', 'Notifications'],
                    ]; @endphp
                    @foreach($statuses as $s)
                    <div class="s5-status-item">
                        <span>{{ $s[0] }}. {{ $s[1] }}</span>
                        <div class="s5-status-dot"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- MARQUEE -->
    <div class="s5-marquee">
        <span>
            // NO BIAS &nbsp;&nbsp;&nbsp; SMARTER HIRING &nbsp;&nbsp;&nbsp; CHALLY AI &nbsp;&nbsp;&nbsp; FIND THE RIGHT PERSON &nbsp;&nbsp;&nbsp; NOT JUST THE RIGHT KEYWORDS &nbsp;&nbsp;&nbsp; ZERO GUESSWORK &nbsp;&nbsp;&nbsp; BUILT FOR THE FUTURE OF WORK &nbsp;&nbsp;&nbsp;
            // NO BIAS &nbsp;&nbsp;&nbsp; SMARTER HIRING &nbsp;&nbsp;&nbsp; CHALLY AI &nbsp;&nbsp;&nbsp; FIND THE RIGHT PERSON &nbsp;&nbsp;&nbsp; NOT JUST THE RIGHT KEYWORDS &nbsp;&nbsp;&nbsp; ZERO GUESSWORK &nbsp;&nbsp;&nbsp; BUILT FOR THE FUTURE OF WORK &nbsp;&nbsp;&nbsp;
        </span>
    </div>

    <!-- SOLUTIONS SECTION -->
    <section class="s5-section">
        <h2 class="s5-title-section max-w-3xl">Recruitment Intelligence Solutions</h2>
        
        <div class="s5-grid-4">
            <div class="s5-grid-card group">
                <h3 class="s5-card-title">AI Screening</h3>
                <p class="s5-card-desc">Analyze thousands of CVs in seconds. Chally extracts skills semantically, validates experience, and eliminates noise — no human bias involved.</p>
                <div class="mt-auto">
                    <a href="{{ route('register') }}" class="s5-mono text-[10px] text-accent font-bold border border-accent rounded-full px-4 py-2 group-hover:bg-accent group-hover:text-black transition-colors">EXPLORE</a>
                </div>
            </div>

            <div class="s5-grid-card group">
                <h3 class="s5-card-title">Job Matching</h3>
                <p class="s5-card-desc">Beyond keyword matching — Chally maps candidate competencies against your team's specific needs: technical skills, cultural fit, and career stability.</p>
                <div class="mt-auto">
                    <a href="{{ route('jobs.index') }}" class="s5-mono text-[10px] text-accent font-bold border border-accent rounded-full px-4 py-2 group-hover:bg-accent group-hover:text-black transition-colors">EXPLORE</a>
                </div>
            </div>

            <div class="s5-grid-card group">
                <h3 class="s5-card-title">Profile Coach</h3>
                <p class="s5-card-desc">Chally doesn't just evaluate — it guides. Candidates get instant, actionable advice to strengthen their profile and get noticed by top recruiters.</p>
                <div class="mt-auto">
                    <a href="{{ route('register') }}" class="s5-mono text-[10px] text-accent font-bold border border-accent rounded-full px-4 py-2 group-hover:bg-accent group-hover:text-black transition-colors">EXPLORE</a>
                </div>
            </div>

            <div class="s5-grid-card group">
                <h3 class="s5-card-title">HR Analytics</h3>
                <p class="s5-card-desc">Give your HR team a full-picture dashboard — application pipeline, candidate scores, and hiring velocity — all in one place.</p>
                <div class="mt-auto">
                    <a href="{{ route('register') }}" class="s5-mono text-[10px] text-accent font-bold border border-accent rounded-full px-4 py-2 group-hover:bg-accent group-hover:text-black transition-colors">EXPLORE</a>
                </div>
            </div>
        </div>
    </section>

    <!-- JOBS SECTION (Adapted to S5 Style) -->
    <section class="s5-section pt-0">
        <div class="flex justify-between items-end mb-8 border-b border-accent pb-4">
            <h2 class="s5-title-section text-white">Open Positions</h2>
            <a href="{{ route('jobs.index') }}" class="s5-pill-btn text-accent border border-accent hover:bg-accent hover:text-black text-sm py-2 px-6">View All</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0 border-t border-l border-accent">
            @forelse($latestJobs as $job)
            <div class="border-r border-b border-accent p-8 relative group hover:bg-[rgba(255,77,48,0.1)] transition-colors flex flex-col">
                <div class="s5-mono text-[10px] text-accent font-bold mb-4">OPEN // {{ strtoupper($job->location) }}</div>
                <h3 class="s5-title-section text-2xl mb-4 leading-tight text-white group-hover:text-accent transition-colors">{{ $job->title }}</h3>
                <div class="flex flex-wrap gap-2 mb-8">
                    @if($job->skills_json)
                        @foreach(array_slice($job->skills_json, 0, 3) as $skill)
                        <span class="border border-accent text-accent px-3 py-1 s5-mono text-[9px]">{{ $skill }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="mt-auto">
                    <a href="{{ route('jobs.show', $job->id) }}" class="s5-mono text-[10px] font-bold border border-accent bg-transparent text-accent rounded-full px-6 py-3 hover:bg-accent hover:text-black transition-colors">APPLY NOW</a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center s5-mono text-gray-400">No active missions.</div>
            @endforelse
        </div>
    </section>



</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin(ScrollTrigger);

    // Hero Animations
    gsap.from(".s5-hero-left-text", { y: 30, opacity: 0, duration: 1, delay: 0.2 });
    gsap.from(".s5-title-mega", { y: 50, opacity: 0, duration: 1, ease: "power3.out", delay: 0.4 });
    gsap.from(".s5-status-item", { x: 20, opacity: 0, duration: 0.5, stagger: 0.05, delay: 0.8 });

    // Grid Animations
    gsap.from(".s5-grid-card", {
        y: 40, opacity: 0, duration: 0.8, stagger: 0.1,
        scrollTrigger: { trigger: ".s5-grid-4", start: "top 80%" }
    });
});
</script>
@endpush