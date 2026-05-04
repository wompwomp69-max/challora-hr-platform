@extends('layouts.app')

@section('content')
    <div class="edit-container">
        <div class="edit-section">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="edit-section-title" style="margin:0;">Document Preview</h2>
                    <p class="text-xs text-text-muted mt-1">{{ strtoupper($type) }} • {{ $fileName }}</p>
                </div>
                <a href="{{ $backUrl }}" class="btn-cancel py-2 px-5 text-xs tracking-widest">KEMBALI</a>
            </div>

            @if($isImage)
                <img src="{{ $rawUrl }}" alt="{{ $fileName }}" class="w-full border-2 border-border bg-secondary" />
            @elseif($isPdf)
                <iframe src="{{ $rawUrl }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
                    class="w-full border-2 border-border bg-secondary" style="height:80vh;"></iframe>
                <p class="text-xs text-text-muted mt-3">Dokumen PDF ditampilkan dalam mode baca saja.</p>
            @else
                <div class="border-2 border-border bg-secondary p-5">
                    <p class="text-sm mb-3">Tipe berkas ini tidak bisa dipreview langsung.</p>
                    <a href="{{ $rawUrl }}" class="btn-submit py-2 px-4 text-xs tracking-widest inline-block">DOWNLOAD
                        FILE</a>
                </div>
            @endif
        </div>
    </div>
@endsection
