@extends('layouts.app')

@section('content')
<div class="lowercase mb-8 flex justify-between items-center">
    <a href="javascript:history.back()" class="font-black text-accent uppercase tracking-widest text-sm flex items-center gap-2">
        <i class="bi bi-arrow-left"></i> back to previous page
    </a>
    <span class="text-[10px] font-bold text-text-muted uppercase tracking-widest">
        Security Protocol: Read-Only View
    </span>
</div>

<div class="bg-black border-2 border-border shadow-[8px_8px_0_var(--color-border)] overflow-hidden relative" style="height: calc(100vh - 250px);">
    <iframe src="{{ $url }}" class="w-full h-full border-0" title="Document Viewer"></iframe>
    
    <!-- Read Only Overlay (Optional, but gives a visual cue) -->
    <div class="absolute top-0 right-0 p-4 pointer-events-none">
        <div class="bg-accent text-white px-3 py-1 text-[9px] font-black uppercase tracking-tighter border border-black">
            Locked Document
        </div>
    </div>
</div>

<div class="mt-8 text-center">
    <p class="text-[10px] font-bold text-text-muted uppercase tracking-widest">
        If you cannot see the document, <a href="{{ $url }}" target="_blank" class="text-accent underline">click here to open in new tab</a>.
    </p>
</div>
@endsection
