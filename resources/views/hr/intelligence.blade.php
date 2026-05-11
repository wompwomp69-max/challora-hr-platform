@extends('layouts.app')

@section('content')
<div class="bg-[#1a1a1a] border-4 border-black rounded p-6 mb-5">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-white">HR Intelligence</h1>
            <p class="text-base text-gray-300">Top candidates, compatibility list, and AI insights per job.</p>
        </div>
        <a href="{{ route('hr.applications.index') }}" class="px-3 py-2 text-xs rounded bg-accent text-black font-bold uppercase">Manage Pipeline</a>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-5">
    <div class="space-y-5">
        <div class="bg-[#1a1a1a] border-4 border-black rounded p-5">
            <h2 class="text-sm uppercase tracking-wider font-bold text-gray-400 mb-3">Top Candidates Per Job</h2>
            @forelse($topCandidatesByJob as $item)
                <div class="mb-4">
                    <div class="text-white font-bold mb-2">{{ $item['job']['title'] }}</div>
                    @foreach($item['candidates'] as $candidate)
                        <button class="candidate-trigger w-full text-left border border-gray-700 rounded p-2 mb-2 {{ ($defaultSelectedApplicationId ?? null) === $candidate['application_id'] ? 'ring-2 ring-accent' : '' }}" data-application-id="{{ $candidate['application_id'] }}">
                            <div class="flex justify-between">
                                <span class="text-sm text-white">{{ $candidate['candidate_name'] }}</span>
                                <span class="text-xs text-accent font-bold">Score {{ number_format($candidate['score_total'] / 10, 1) }}/10</span>
                            </div>
                        </button>
                    @endforeach
                </div>
            @empty
                <p class="text-base text-gray-300">No candidates with AI score yet.</p>
            @endforelse
        </div>

        <div class="bg-[#1a1a1a] border-4 border-black rounded p-5">
            <h2 class="text-sm uppercase tracking-wider font-bold text-gray-400 mb-3">Available Compatible Candidate</h2>
            @forelse($availableCompatibleCandidates as $candidate)
                <button class="candidate-trigger w-full text-left border-b border-gray-700 py-2 {{ ($defaultSelectedApplicationId ?? null) === $candidate['application_id'] ? 'text-accent' : 'text-white' }}" data-application-id="{{ $candidate['application_id'] }}">
                    <div class="flex justify-between">
                        <span>{{ $candidate['candidate_name'] }}</span>
                        <span class="text-xs">Score {{ number_format($candidate['score_total'] / 10, 1) }}/10</span>
                    </div>
                    <div class="text-xs text-gray-400">{{ $candidate['job_title'] }}</div>
                </button>
            @empty
                <p class="text-base text-gray-300">No compatible candidates yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-[#1a1a1a] border-4 border-black rounded p-5">
        <h2 class="text-sm uppercase tracking-wider font-bold text-gray-400 mb-3">Candidate Insight</h2>
        <div id="insight-empty" class="{{ $selectedCandidateDetail ? 'hidden' : '' }}">
            <p class="text-base text-gray-300">Select a candidate to view insights.</p>
        </div>
        <div id="insight-body" class="{{ $selectedCandidateDetail ? '' : 'hidden' }}">
            <div class="mb-3">
                <div id="insight-name" class="text-lg font-bold text-white"></div>
                <div id="insight-job" class="text-base text-gray-300"></div>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="border border-gray-700 rounded p-2 text-center">
                    <div class="text-xs text-gray-400">AI Score</div>
                    <div id="insight-score" class="text-white font-bold">0</div>
                </div>
                <div class="border border-gray-700 rounded p-2 text-center">
                    <div class="text-xs text-gray-400">Confidence</div>
                    <div id="insight-confidence" class="text-white font-bold">0%</div>
                </div>
            </div>
            <div class="mb-3">
                <h3 class="text-sm font-bold text-green-400">Plus</h3>
                <ul id="insight-pros" class="list-disc list-inside text-base text-gray-300"></ul>
            </div>
            <div class="mb-3">
                <h3 class="text-sm font-bold text-red-400">Minus</h3>
                <ul id="insight-cons" class="list-disc list-inside text-base text-gray-300"></ul>
            </div>
            <div>
                <h3 class="text-sm font-bold text-accent">Summary</h3>
                <p id="insight-summary" class="text-base text-gray-300"></p>
            </div>
        </div>
    </div>
</div>

<script id="intel-bootstrap" type="application/json">{!! json_encode([
    'detailUrlTemplate' => route('hr.intelligence.candidates.show', ['application' => '__APP__']),
    'initialDetail' => $selectedCandidateDetail,
]) !!}</script>
@endsection

@push('scripts')
<script>
    const initHrIntelligence = () => {
        const bootstrapNode = document.getElementById('intel-bootstrap');
        if (!bootstrapNode || bootstrapNode.dataset.initialized === '1') return;
        bootstrapNode.dataset.initialized = '1';

        const emptyState = document.getElementById('insight-empty');
        const bodyState = document.getElementById('insight-body');
        if (!emptyState || !bodyState) return;

        const payload = JSON.parse(bootstrapNode.textContent || '{}');
        const detailUrlTemplate = payload.detailUrlTemplate || '';
        const triggers = document.querySelectorAll('.candidate-trigger');

        const renderList = (targetId, values, fallback) => {
            const list = document.getElementById(targetId);
            if (!list) return;
            list.innerHTML = '';
            (Array.isArray(values) && values.length ? values : [fallback]).forEach((item) => {
                const li = document.createElement('li');
                li.textContent = item;
                list.appendChild(li);
            });
        };

        const renderDetail = (detail) => {
            if (!detail) {
                bodyState.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            bodyState.classList.remove('hidden');
            emptyState.classList.add('hidden');
            document.getElementById('insight-name').textContent = detail.candidate?.name ?? '-';
            document.getElementById('insight-job').textContent = detail.job?.title ?? '-';
            document.getElementById('insight-score').textContent = ((detail.ai?.score_total ?? 0) / 10).toFixed(1) + '/10';
            document.getElementById('insight-confidence').textContent = `${Math.round((detail.ai?.confidence ?? 0) * 100)}%`;
            document.getElementById('insight-summary').textContent = detail.ai?.summary_text ?? 'No AI summary available.';
            renderList('insight-pros', detail.ai?.pros, 'No strengths listed.');
            renderList('insight-cons', detail.ai?.cons, 'No weaknesses listed.');
        };

        const loadDetail = async (applicationId) => {
            if (!detailUrlTemplate) return;
            const response = await fetch(detailUrlTemplate.replace('__APP__', applicationId), {
                headers: {'X-Requested-With': 'XMLHttpRequest'},
            });
            if (!response.ok) return;
            const result = await response.json();
            if (result?.ok) renderDetail(result.data);
        };

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', async () => {
                await loadDetail(trigger.dataset.applicationId);
            });
        });

        renderDetail(payload.initialDetail ?? null);
    };

    document.addEventListener('DOMContentLoaded', initHrIntelligence);
    document.addEventListener('app:page-ready', initHrIntelligence);
</script>
@endpush


