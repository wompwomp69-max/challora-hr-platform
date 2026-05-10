@extends('layouts.app')

@section('content')
<div class="lowercase mb-8 flex justify-between items-center">
    <a href="javascript:history.back()" class="font-black text-accent uppercase tracking-widest text-sm flex items-center gap-2">
        <i class="bi bi-arrow-left"></i> back to previous page
    </a>
</div>

<div class="border-2 border-border shadow-[8px_8px_0_var(--color-border)] p-16 flex flex-col items-center justify-center text-center" style="min-height: 400px;">
    <div class="text-6xl mb-6">📄</div>
    <h2 class="font-black text-2xl uppercase tracking-tight mb-3">File Not Available</h2>
    <p class="text-text-muted font-bold text-sm uppercase tracking-widest mb-2">
        {{ strtoupper($type) }} &nbsp;·&nbsp; {{ $message ?? 'This file could not be found on the server.' }}
    </p>
    <p class="text-text-muted text-xs mt-4 max-w-md leading-relaxed">
        This usually happens because the file was uploaded before the latest deployment.
        The candidate may need to re-upload their document.
    </p>
</div>
@endsection
