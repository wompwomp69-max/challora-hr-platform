@extends('layouts.app')



@section('content')
    <div class="edit-container">
        <div class="edit-hero">
            <h1 class="edit-title">Profile Settings</h1>
        </div>

        <!-- Avatar Upload -->
        <div class="avatar-upload-hero">
            <div class="avatar-preview-lg">
                @if(auth()->user()->avatar_path)
                    <img src="{{ route('avatar') }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl font-black text-accent opacity-20">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="font-black text-lg uppercase tracking-widest mb-2">Profile Photo</h3>
                <p class="text-sm font-bold text-text-muted mb-4">Upload a formal photo to improve your credibility (Max.
                    1MB).</p>
                <form action="{{ route('user.settings.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-4">
                        <input type="file" name="avatar" class="form-input text-xs" required accept="image/*">
                        <button type="submit" class="btn-submit py-2 px-6 text-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Profile Form -->
        <form method="post" action="{{ route('user.settings.update') }}">
            @csrf

            <div class="edit-section" id="personal">
                <h2 class="edit-section-title">
                    <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </h2>
                <div class="grid grid-cols-1 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" required value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input opacity-50 cursor-not-allowed" value="{{ $user->email }}"
                            readonly disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">— Select —</option>
                            <option value="laki-laki" {{ $user->gender === 'laki-laki' ? 'selected' : '' }}>Male</option>
                            <option value="perempuan" {{ $user->gender === 'perempuan' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birth Place</label>
                        <input type="text" name="birth_place" class="form-input" value="{{ old('birth_place', $user->birth_place) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Religion</label>
                        <select name="religion" class="form-select">
                            <option value="">— Select —</option>
                            @foreach(['Islam', 'Christianity', 'Catholicism', 'Hinduism', 'Buddhism', 'Confucianism'] as $r)
                                <option value="{{ $r }}" {{ $user->religion === $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select">
                            <option value="">— Select —</option>
                            @foreach(['Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced'] as $val => $label)
                                <option value="{{ $val }}" {{ $user->marital_status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Full Address</label>
                    <textarea name="address" class="form-textarea" rows="2">{{ old('address', $user->address) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Professional Summary</label>
                    <textarea name="user_summary" class="form-textarea"
                        rows="4">{{ old('user_summary', $user->user_summary) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Skills</label>
                    <p class="text-[11px] text-text-muted font-bold mb-2 uppercase">Separate with commas — e.g. PHP, Laravel, React, MySQL</p>
                    <input type="text" name="skills" class="form-input"
                        placeholder="PHP, Laravel, React, MySQL, Docker..."
                        value="{{ old('skills', $user->skills) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Skills</label>
                    <textarea name="skills" class="form-textarea"
                        placeholder="Comma-separated skills e.g., PHP, Laravel, Communication"
                        rows="3">{{ old('skills', $user->skills) }}</textarea>
                </div>
            </div>

            <div class="edit-section" id="education">
                <h2 class="edit-section-title">
                    <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                    Education History
                </h2>
                <div class="grid grid-cols-1 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">University / Institution</label>
                        <input type="text" name="education_university" class="form-input"
                            value="{{ old('education_university', $user->education_university) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Major</label>
                        <input type="text" name="education_major" class="form-input"
                            value="{{ old('education_major', $user->education_major) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Education Level</label>
                        <select name="education_level" class="form-select">
                            <option value="">— Select —</option>
                            @foreach(\App\Enums\EducationLevel::cases() as $level)
                                <option value="{{ $level->value }}" {{ $user->education_level === $level->value ? 'selected' : '' }}>{{ $level->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Graduation Year</label>
                        <input type="text" name="graduation_year" class="form-input"
                            value="{{ old('graduation_year', $user->graduation_year) }}">
                    </div>
                </div>
            </div>

            <!-- Experience Section with Dynamic Rows -->
            <div class="edit-section" id="work-experience">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="edit-section-title" style="margin:0;">
                        <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Work Experience
                    </h2>
                    <button type="button" class="btn-cancel py-1 px-4 text-xs tracking-widest" id="add-exp">ADD NEW</button>
                </div>
                <div id="exp-container">
                    @foreach($user->workExperiences as $exp)
                        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="work_title[]" class="form-input" placeholder="Job Title"
                                    value="{{ $exp->title }}">
                                <input type="text" name="work_company[]" class="form-input" placeholder="Company Name"
                                    value="{{ $exp->company_name }}">
                            </div>
                            <div class="flex gap-4 w-full">
                                <input type="text" name="work_year_start[]" class="form-input" placeholder="Start Year"
                                    value="{{ $exp->year_start }}">
                                <input type="text" name="work_year_end[]" class="form-input" placeholder="End Year"
                                    value="{{ $exp->year_end }}">
                                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black"
                                    onclick="this.parentElement.parentElement.remove()">X</button>
                            </div>
                            <textarea name="work_description[]" class="form-textarea"
                                placeholder="Job description...">{{ $exp->description }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Achievements Section -->
            <div class="edit-section" id="achievements">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="edit-section-title" style="margin:0;">
                        <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Achievements
                    </h2>
                    <button type="button" class="btn-cancel py-1 px-4 text-xs tracking-widest" id="add-ach">ADD NEW</button>
                </div>
                <div id="ach-container">
                    @foreach($user->achievements as $ach)
                        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="ach_title[]" class="form-input" placeholder="Achievement Title" value="{{ $ach->title }}">
                                <select name="ach_type[]" class="form-select">
                                    <option value="Sertifikat" {{ $ach->type === 'Sertifikat' ? 'selected' : '' }}>Certificate</option>
                                    <option value="Penghargaan" {{ $ach->type === 'Penghargaan' ? 'selected' : '' }}>Award</option>
                                    <option value="Lomba" {{ $ach->type === 'Lomba' ? 'selected' : '' }}>Competition</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="ach_organizer[]" class="form-input" placeholder="Organizer" value="{{ $ach->organizer }}">
                                <input type="text" name="ach_year[]" class="form-input" placeholder="Year" value="{{ $ach->year }}">
                            </div>
                            <div class="flex gap-4 w-full">
                                <input type="text" name="ach_level[]" class="form-input" placeholder="Level (e.g. National)" value="{{ $ach->level }}">
                                <input type="text" name="ach_certificate_link[]" class="form-input" placeholder="Certificate Link / URL" value="{{ $ach->certificate_link }}">
                                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
                            </div>
                            <textarea name="ach_description[]" class="form-textarea" placeholder="Description...">{{ $ach->description }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Organizational Experience Section -->
            <div class="edit-section" id="org-experience">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="edit-section-title" style="margin:0;">
                        <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Organizational Experience
                    </h2>
                    <button type="button" class="btn-cancel py-1 px-4 text-xs tracking-widest" id="add-org">ADD NEW</button>
                </div>
                <div id="org-container">
                    @foreach($user->organizationalExperiences as $org)
                        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="org_name[]" class="form-input" placeholder="Organization Name" value="{{ $org->organization_name }}">
                                <input type="text" name="org_position[]" class="form-input" placeholder="Position / Role" value="{{ $org->position }}">
                            </div>
                            <div class="flex gap-4 w-full">
                                <input type="text" name="org_year_start[]" class="form-input" placeholder="Start Year" value="{{ $org->start_year }}">
                                <input type="text" name="org_year_end[]" class="form-input" placeholder="End Year" value="{{ $org->year_end }}">
                                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
                            </div>
                            <textarea name="org_description[]" class="form-textarea" placeholder="Describe your role and impact...">{{ $org->description }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-4 mt-12 pb-12">
                <button type="submit" class="btn-submit">Save All Changes</button>
                <a href="{{ route('user.settings.index') }}" class="btn-cancel">Back to Profile</a>
            </div>
        </form>

        <!-- Document Upload Section -->
        <div class="edit-section" id="documents">
            <h2 class="edit-section-title">
                <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Supporting Documents
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(['cv' => 'CV / Resume', 'diploma' => 'Diploma', 'photo' => 'Photo Formal'] as $key => $label)
                    <div class="bg-secondary p-6 border-2 border-dashed border-border flex flex-col justify-between">
                        <div>
                            <h4 class="font-black text-xs uppercase tracking-widest mb-1">{{ $label }}</h4>
                            @php $field = $key . '_path'; @endphp
                            @if($user->$field)
                                <p class="text-[10px] font-bold text-success-text mb-4 uppercase">Uploaded &bull; <a
                                        href="{{ route('view.document', ['type' => $key]) }}"
                                        class="underline">View</a></p>
                            @else
                                <p class="text-[10px] font-bold text-red-600 mb-4 uppercase">Not Uploaded</p>
                            @endif
                        </div>
                        <form action="{{ route('user.settings.upload', $key) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="{{ $key }}" class="hidden" id="file-{{ $key }}"
                                accept="{{ in_array($key, ['cv','diploma']) ? '.pdf' : '.jpg,.jpeg,.png' }}"
                                data-field="{{ $key }}">
                            <label for="file-{{ $key }}"
                                class="btn-cancel py-2 px-4 text-[10px] block text-center cursor-pointer">UPLOAD NEW</label>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <template id="exp-template">
        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="work_title[]" class="form-input" placeholder="Job Title">
                <input type="text" name="work_company[]" class="form-input" placeholder="Company Name">
            </div>
            <div class="flex gap-4 w-full">
                <input type="text" name="work_year_start[]" class="form-input" placeholder="Start Year">
                <input type="text" name="work_year_end[]" class="form-input" placeholder="End Year">
                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black"
                    onclick="this.parentElement.parentElement.remove()">X</button>
            </div>
            <textarea name="work_description[]" class="form-textarea" placeholder="Job description..."></textarea>
        </div>
    </template>

    <template id="ach-template">
        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="ach_title[]" class="form-input" placeholder="Achievement Title">
                <select name="ach_type[]" class="form-select">
                    <option value="Sertifikat">Certificate</option>
                    <option value="Penghargaan">Award</option>
                    <option value="Lomba">Competition</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="ach_organizer[]" class="form-input" placeholder="Organizer">
                <input type="text" name="ach_year[]" class="form-input" placeholder="Year">
            </div>
            <div class="flex gap-4 w-full">
                <input type="text" name="ach_level[]" class="form-input" placeholder="Level (e.g. National)">
                <input type="text" name="ach_certificate_link[]" class="form-input" placeholder="Certificate Link / URL">
                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
            </div>
            <textarea name="ach_description[]" class="form-textarea" placeholder="Description..."></textarea>
        </div>
    </template>

    <template id="org-template">
        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="org_name[]" class="form-input" placeholder="Organization Name">
                <input type="text" name="org_position[]" class="form-input" placeholder="Position / Role">
            </div>
            <div class="flex gap-4 w-full">
                <input type="text" name="org_year_start[]" class="form-input" placeholder="Start Year">
                <input type="text" name="org_year_end[]" class="form-input" placeholder="End Year">
                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
            </div>
            <textarea name="org_description[]" class="form-textarea" placeholder="Describe your role and impact..."></textarea>
        </div>
    </template>

    <script>
        const MAX_SIZE = 1 * 1024 * 1024; // 1MB

        function checkFileSize(input, form) {
            if (input.files[0] && input.files[0].size > MAX_SIZE) {
                alert('File is too large. Maximum allowed size is 1MB.');
                input.value = '';
                return false;
            }
            return true;
        }

        // Avatar form
        document.querySelector('form[action*="avatar"] input[type="file"]')
            ?.closest('form')
            ?.addEventListener('submit', function(e) {
                const input = this.querySelector('input[type="file"]');
                if (!checkFileSize(input, this)) e.preventDefault();
            });

        // Document upload forms (auto-submit on change)
        document.querySelectorAll('input[type="file"][id^="file-"]').forEach(input => {
            input.addEventListener('change', function() {
                if (!checkFileSize(this)) { this.value = ''; return; }
                this.closest('form').submit();
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const setupAddButton = (btnId, containerId, templateId) => {
                const btn = document.getElementById(btnId);
                const container = document.getElementById(containerId);
                const template = document.getElementById(templateId);
                
                if (btn && container && template) {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const clone = template.content.cloneNode(true);
                        container.appendChild(clone);
                    });
                }
            };

            setupAddButton('add-exp', 'exp-container', 'exp-template');
            setupAddButton('add-ach', 'ach-container', 'ach-template');
            setupAddButton('add-org', 'org-container', 'org-template');

            if (window.gsap) {
                gsap.fromTo(".edit-hero", { opacity: 0, x: -30 }, { opacity: 1, x: 0, duration: 0.8, ease: "power4.out" });
                gsap.fromTo(".edit-section", { opacity: 0, y: 30 }, { opacity: 1, y: 0, stagger: 0.1, duration: 1, ease: "power4.out", delay: 0.2 });
            }
        });
    </script>
@endsection

