<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Dashboard UI Mockup</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed', // Primary purple
                            700: '#6d28d9',
                            900: '#4c1d95',
                        },
                        text: {
                            base: '#1f2937',
                            muted: '#6b7280',
                            light: '#9ca3af',
                        },
                        surface: '#f9fafb',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f3f4f6; color: #1f2937; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 240px 1fr 300px;
            gap: 24px;
            max-width: 1600px;
            margin: 0 auto;
            padding: 24px;
        }

        /* Checkbox Custom */
        .checkbox-custom {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #e5e7eb;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }
        .checkbox-custom:checked {
            background-color: #22c55e;
            border-color: #22c55e;
        }
        .checkbox-custom:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 5px;
            width: 4px;
            height: 9px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Tag Styles */
        .tag-gray { background: #f3f4f6; color: #6b7280; font-size: 11px; padding: 4px 10px; border-radius: 9999px; font-weight: 600; }
        .job-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .job-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px -10px rgba(124, 58, 237, 0.2); }
        
        .active-card {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            border: none;
        }
        .active-card .text-muted { color: rgba(255,255,255,0.8) !important; }
        .active-card .tag-gray { background: rgba(255,255,255,0.15); color: white; }
    </style>
</head>
<body class="antialiased min-h-screen">

    <!-- Top Navigation -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="px-6 h-20 flex items-center justify-between">
            <!-- Logo & Nav Links -->
            <div class="flex items-center gap-10">
                <a href="#" class="flex items-center gap-2 text-brand-600 font-bold text-2xl tracking-tight">
                    <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                        <i class="bi bi-briefcase-fill text-white text-sm"></i>
                    </div>
                    Talent
                </a>
                
                <div class="hidden md:flex items-center gap-2">
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-text-muted hover:text-brand-600 font-semibold text-sm transition-colors rounded-full">
                        <i class="bi bi-house"></i> Home
                    </a>
                    <a href="#" class="flex items-center gap-2 px-5 py-2.5 bg-brand-50 text-brand-600 border border-brand-100 font-semibold text-sm rounded-full">
                        <i class="bi bi-search"></i> Find Jobs
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-text-muted hover:text-brand-600 font-semibold text-sm transition-colors rounded-full">
                        <i class="bi bi-building"></i> Companies
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-text-muted hover:text-brand-600 font-semibold text-sm transition-colors rounded-full">
                        <i class="bi bi-file-earmark-text"></i> Application
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-text-muted hover:text-brand-600 font-semibold text-sm transition-colors rounded-full">
                        <i class="bi bi-clock-history"></i> History
                    </a>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-5">
                <button class="text-gray-400 hover:text-gray-600 text-xl transition-colors"><i class="bi bi-envelope"></i></button>
                <div class="relative">
                    <button class="text-gray-400 hover:text-gray-600 text-xl transition-colors"><i class="bi bi-bell"></i></button>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
                <div class="h-6 w-px bg-gray-200 ml-2"></div>
                <button class="flex items-center gap-3 pl-2">
                    <img src="https://ui-avatars.com/api/?name=Lance+Meyers&background=random" class="w-9 h-9 rounded-full object-cover">
                    <span class="font-bold text-sm text-gray-800 hidden sm:block">Lance Meyers</span>
                    <i class="bi bi-chevron-down text-xs text-gray-400"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="dashboard-grid h-[calc(100vh-80px)] overflow-hidden">
        
        <!-- LEFT SIDEBAR: FILTERS -->
        <aside class="bg-transparent h-full overflow-y-auto pr-4 pb-10">
            <div class="flex items-center justify-between pl-1 mb-6">
                <h3 class="font-bold text-lg text-gray-900">Filters</h3>
                <button class="text-brand-600 text-xs font-semibold hover:underline">Clear All</button>
            </div>

            <!-- Filter Group: Sort By -->
            <div class="mb-6">
                <button class="flex items-center justify-between w-full font-bold text-sm text-gray-800 mb-3 px-1">
                    Sort By <i class="bi bi-chevron-up text-gray-400"></i>
                </button>
                <div class="flex flex-col gap-3 px-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom" checked>
                        <span class="text-sm text-gray-600 font-medium">Most Relevant</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Most Recent</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Top Salary</span>
                    </label>
                </div>
            </div>

            <!-- Filter Group: Job Type -->
            <div class="mb-6">
                <button class="flex items-center justify-between w-full font-bold text-sm text-gray-800 mb-3 px-1">
                    Job Type <i class="bi bi-chevron-up text-gray-400"></i>
                </button>
                <div class="flex flex-col gap-3 px-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">All</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom" checked>
                        <span class="text-sm text-gray-600 font-medium">Full-time</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Part-time</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Internship</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Remote</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Contract</span>
                    </label>
                </div>
            </div>

            <!-- Filter Group: Experience -->
            <div class="mb-6">
                <button class="flex items-center justify-between w-full font-bold text-sm text-gray-800 mb-3 px-1">
                    Experience <i class="bi bi-chevron-up text-gray-400"></i>
                </button>
                <div class="flex flex-col gap-3 px-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">All</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom" checked>
                        <span class="text-sm text-gray-600 font-medium">Entry Level</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Intermediate</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Senior</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Expert</span>
                    </label>
                </div>
            </div>

            <!-- Filter Group: Education -->
            <div class="mb-6">
                <button class="flex items-center justify-between w-full font-bold text-sm text-gray-800 mb-3 px-1">
                    Education <i class="bi bi-chevron-up text-gray-400"></i>
                </button>
                <div class="flex flex-col gap-3 px-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom" checked>
                        <span class="text-sm text-gray-600 font-medium">High School</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="checkbox-custom">
                        <span class="text-sm text-gray-600 font-medium">Bachelor\'s</span>
                    </label>
                </div>
            </div>
        </aside>

        <!-- CENTER CONTENT: MAIN -->
        <section class="h-full overflow-y-auto pb-12 pr-2">
            
            <!-- Top Search / Filters Bar -->
            <div class="bg-white p-3 rounded-2xl shadow-sm mb-6 flex items-center gap-3">
                <div class="flex-1 flex items-center gap-3 px-3 bg-gray-50 rounded-xl h-11 border border-transparent focus-within:bg-white focus-within:border-brand-500 transition-colors">
                    <i class="bi bi-search text-gray-400"></i>
                    <input type="text" value="Marketing - Sales" class="bg-transparent w-full font-semibold text-sm text-gray-800 outline-none" placeholder="Job Title">
                    <button><i class="bi bi-x-circle-fill text-gray-300 hover:text-gray-500"></i></button>
                </div>
                
                <div class="flex-1 flex items-center gap-3 px-3 bg-gray-50 rounded-xl h-11 border border-transparent focus-within:bg-white focus-within:border-brand-500 transition-colors">
                    <i class="bi bi-geo-alt text-gray-400"></i>
                    <input type="text" value="Indonesia, Malang" class="bg-transparent w-full font-semibold text-sm text-gray-800 outline-none" placeholder="Location">
                </div>

                <div class="flex items-center gap-3 px-4 bg-gray-50 rounded-xl h-11 cursor-pointer">
                    <i class="bi bi-sliders text-gray-400"></i>
                    <span class="text-sm font-semibold text-gray-800">Office</span>
                    <i class="bi bi-chevron-down text-gray-400 text-xs ml-1"></i>
                </div>

                <div class="flex items-center gap-3 px-4 bg-gray-50 rounded-xl h-11 cursor-pointer">
                    <span class="text-brand-600 text-sm font-bold">$3,000 USD - $8,000 USD</span>
                </div>

                <button class="font-bold text-sm text-gray-500 px-3 hover:text-gray-800">Clear All</button>
                <button class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-8 rounded-xl h-11 transition-colors shadow-sm shadow-brand-500/30">Search</button>
            </div>

            <!-- Context Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-gray-600 text-[15px] font-medium">
                    Showing Result : <span class="text-brand-600 font-bold">359</span> Jobs : <span class="font-bold text-gray-800">Marketing</span> in <span class="text-brand-600 font-bold">Malang, Indonesia</span>
                </h2>
                
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-gray-800">Latest</span>
                        <i class="bi bi-chevron-down text-gray-400 text-xs"></i>
                    </div>
                    <div class="flex items-center bg-white rounded-lg p-1 shadow-sm">
                        <button class="w-8 h-8 flex items-center justify-center bg-brand-50 text-brand-600 rounded-md"><i class="bi bi-grid-fill"></i></button>
                        <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600"><i class="bi bi-list"></i></button>
                    </div>
                </div>
            </div>

            <!-- Job Cards Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                
                <!-- Card 1 (Active/Highlighted) -->
                <div class="job-card active-card p-6 rounded-[24px] flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20 shadow-sm">
                                    <div class="w-6 h-6 rounded bg-gradient-to-br from-green-400 to-emerald-500"></div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg leading-tight mb-1">Marketing</h3>
                                    <p class="text-sm opacity-90">Nova Tech</p>
                                </div>
                            </div>
                            <button class="w-8 h-8 flex items-center justify-center text-white/90 hover:bg-white/10 rounded-full transition-colors">
                                <i class="bi bi-bookmark-fill"></i>
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="tag-gray">Fulltime</span>
                            <span class="tag-gray">Entry Level</span>
                            <span class="tag-gray">Graduated</span>
                        </div>
                        <div class="space-y-2.5 mb-8">
                            <div class="flex items-center gap-3 text-sm font-medium opacity-95">
                                <i class="bi bi-currency-dollar w-4 text-center"></i> USD $300 - $600
                            </div>
                            <div class="flex items-center gap-3 text-sm font-medium opacity-95">
                                <i class="bi bi-geo-alt w-4 text-center"></i> Malang, Indonesia
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto">
                        <p class="text-xs font-medium opacity-80">An hour ago • <span class="text-white font-bold">38 Applicants</span></p>
                        <div class="flex gap-2">
                            <button class="px-5 py-2.5 bg-white/15 hover:bg-white/25 text-white text-xs font-bold rounded-xl transition-colors backdrop-blur-md">Detail Info</button>
                            <button class="px-5 py-2.5 bg-white text-brand-600 hover:bg-gray-50 text-xs font-bold rounded-xl transition-colors shadow-sm">Apply Now</button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="job-card bg-white p-6 rounded-[24px] border border-gray-100 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100">
                                    <div class="w-6 h-6 rounded bg-gradient-to-br from-blue-500 to-indigo-600 transform rotate-45 flex items-center justify-center"><div class="w-2 h-2 bg-white rounded-full"></div></div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight mb-1">Sales</h3>
                                    <p class="text-sm text-gray-500">Fusion Labs</p>
                                </div>
                            </div>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-gray-500 hover:bg-gray-50 rounded-full transition-colors">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="tag-gray">Fulltime</span>
                            <span class="tag-gray">Entry Level</span>
                            <span class="tag-gray">Graduated</span>
                        </div>
                        <div class="space-y-2.5 mb-8">
                            <div class="flex items-center gap-3 text-sm text-brand-600 font-semibold">
                                <i class="bi bi-cash-coin w-4 text-center"></i> USD $600 - $800
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                                <i class="bi bi-geo-alt w-4 text-center"></i> Malang, Indonesia
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto">
                        <p class="text-xs text-gray-400 font-medium">An hour ago • <span class="text-brand-600 font-bold">27 Applicants</span></p>
                        <div class="flex gap-2">
                            <button class="px-5 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-xl transition-colors">Detail Info</button>
                            <button class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm shadow-brand-500/20">Apply Now</button>
                        </div>
                    </div>
                </div>

                <!-- Repeat Card 3 -->
                <div class="job-card bg-white p-6 rounded-[24px] border border-gray-100 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 text-green-500 text-2xl">
                                    <i class="bi bi-feather"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight mb-1">Marketing</h3>
                                    <p class="text-sm text-gray-500">Echo Digital</p>
                                </div>
                            </div>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-gray-500 hover:bg-gray-50 rounded-full transition-colors">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="tag-gray">Fulltime</span>
                            <span class="tag-gray">Entry Level</span>
                            <span class="tag-gray">Graduated</span>
                        </div>
                        <div class="space-y-2.5 mb-8">
                            <div class="flex items-center gap-3 text-sm text-brand-600 font-semibold">
                                <i class="bi bi-cash-coin w-4 text-center"></i> USD $300 - $400
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                                <i class="bi bi-geo-alt w-4 text-center"></i> Malang, Indonesia
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto">
                        <p class="text-xs text-gray-400 font-medium">An hour ago • <span class="text-brand-600 font-bold">20 Applicants</span></p>
                        <div class="flex gap-2">
                            <button class="px-5 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-xl transition-colors">Detail Info</button>
                            <button class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm shadow-brand-500/20">Apply Now</button>
                        </div>
                    </div>
                </div>

                <!-- Repeat Card 4 -->
                <div class="job-card bg-white p-6 rounded-[24px] border border-gray-100 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 text-blue-500 text-xl">
                                    <i class="bi bi-hypnotize"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight mb-1">Marketing</h3>
                                    <p class="text-sm text-gray-500">Orbit Networks</p>
                                </div>
                            </div>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-gray-500 hover:bg-gray-50 rounded-full transition-colors">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="tag-gray">Fulltime</span>
                            <span class="tag-gray">Entry Level</span>
                            <span class="tag-gray">Graduated</span>
                        </div>
                        <div class="space-y-2.5 mb-8">
                            <div class="flex items-center gap-3 text-sm text-brand-600 font-semibold">
                                <i class="bi bi-cash-coin w-4 text-center"></i> USD $300 - $800
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                                <i class="bi bi-geo-alt w-4 text-center"></i> Malang, Indonesia
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto">
                        <p class="text-xs text-gray-400 font-medium">2 day ago • <span class="text-brand-600 font-bold">46 Applicants</span></p>
                        <div class="flex gap-2">
                            <button class="px-5 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-xl transition-colors">Detail Info</button>
                            <button class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm shadow-brand-500/20">Apply Now</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- RIGHT SIDEBAR: PROFILE & SUGGESTIONS -->
        <aside class="h-full overflow-y-auto pb-12">
            
            <!-- Profile Card -->
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 mb-6">
                <h3 class="font-bold text-lg text-gray-900 mb-6">Profile</h3>
                
                <div class="flex gap-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name=Lance+Meyers&background=random" class="w-[60px] h-[60px] rounded-full object-cover">
                    <div>
                        <h4 class="font-bold text-[17px] text-gray-900 leading-tight mb-1">Lance Meyers</h4>
                        <p class="text-[13px] text-gray-500 font-medium mb-2"><i class="bi bi-briefcase mr-1"></i> Marketing <span class="mx-1">•</span> <i class="bi bi-geo-alt mr-1"></i> Malang, Indonesia</p>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-600 text-[11px] font-bold rounded-full border border-green-100">Available for work</span>
                    </div>
                </div>

                <!-- Work Experience -->
                <div class="mb-6">
                    <h5 class="text-brand-600 font-bold text-sm mb-4">Work Experience</h5>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded bg-gray-50 flex items-center justify-center flex-shrink-0 text-brand-500"><i class="bi bi-triangle-half transform rotate-90"></i></div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h6 class="font-bold text-sm text-gray-900 leading-tight">Sales Marketing</h6>
                                    <span class="text-xs text-gray-500">2 years</span>
                                </div>
                                <p class="text-xs text-gray-500">Fusion Labs • Fulltime</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded bg-gray-50 flex items-center justify-center flex-shrink-0 text-emerald-500"><i class="bi bi-pentagon-fill"></i></div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h6 class="font-bold text-sm text-gray-900 leading-tight">Marketing</h6>
                                    <span class="text-xs text-gray-500">3 years</span>
                                </div>
                                <p class="text-xs text-gray-500">Echo Digital • Parttime</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded bg-gray-50 flex items-center justify-center flex-shrink-0 text-orange-500"><i class="bi bi-graph-up-arrow"></i></div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h6 class="font-bold text-sm text-gray-900 leading-tight">Marketing</h6>
                                    <span class="text-xs text-gray-500">3 years</span>
                                </div>
                                <p class="text-xs text-gray-500">Stellar Group • Internship</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Skills -->
                <div>
                    <h5 class="text-brand-600 font-bold text-sm mb-3">Top Skills</h5>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Sales</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Marketing</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Admin</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Operator</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Manager</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Staff</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Content Strategist</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">Creative Director</span>
                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 text-xs font-semibold rounded-full">SEO</span>
                    </div>
                </div>
            </div>

            <!-- Job Fair Widget -->
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-lg text-gray-900 mb-2">Job Fair</h3>
                <p class="text-[13px] text-gray-500 leading-relaxed mb-6">Find a Job Fair Invitation and Attend to look for work</p>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-4 cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 text-lg group-hover:bg-teal-500 group-hover:text-white transition-colors">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="flex-1">
                            <h6 class="font-bold text-sm text-gray-900 leading-tight">Manufacturing industry job fair</h6>
                            <p class="text-xs text-gray-500 mt-1"><i class="bi bi-clock mr-1"></i> 19 Aug 2026 <i class="bi bi-geo-alt ml-1 mr-1"></i> InnoTech Solutions</p>
                        </div>
                        <i class="bi bi-chevron-right text-gray-300 group-hover:text-gray-900 transition-colors"></i>
                    </div>
                    
                    <div class="flex items-center gap-4 cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="flex-1">
                            <h6 class="font-bold text-sm text-gray-900 leading-tight">Webinar Invitation</h6>
                            <p class="text-xs text-gray-500 mt-1"><i class="bi bi-clock mr-1"></i> 18 Aug 2026 <i class="bi bi-geo-alt ml-1 mr-1"></i> Apex Enterprises</p>
                        </div>
                        <i class="bi bi-chevron-right text-gray-300 group-hover:text-gray-900 transition-colors"></i>
                    </div>
                    
                    <div class="flex items-center gap-4 cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600 text-lg group-hover:bg-pink-500 group-hover:text-white transition-colors">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div class="flex-1">
                            <h6 class="font-bold text-sm text-gray-900 leading-tight">Factory job fair</h6>
                            <p class="text-xs text-gray-500 mt-1"><i class="bi bi-clock mr-1"></i> 17 Aug 2026 <i class="bi bi-geo-alt ml-1 mr-1"></i> Genesis Global</p>
                        </div>
                        <i class="bi bi-chevron-right text-gray-300 group-hover:text-gray-900 transition-colors"></i>
                    </div>
                </div>
            </div>

        </aside>

    </main>

</body>
</html>
