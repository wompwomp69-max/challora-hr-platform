<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($type, $id)
    {
        $application = \App\Models\Application::with('job')->findOrFail($id);
        
        // Authorization check: Only owner of the job (HR) or the candidate themselves
        // Relax check for local development if needed, but let's keep it robust
        if (auth()->user()->role === \App\Enums\UserRole::HR) {
            if ($application->job->created_by !== auth()->id() && !app()->environment('local')) {
                abort(403, 'Anda bukan pemilik lowongan ini.');
            }
        } else {
            if ($application->user_id !== auth()->id() && !app()->environment('local')) {
                abort(403, 'Ini bukan berkas Anda.');
            }
        }

        $pathField = $type . '_path';
        $path = $application->$pathField;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            // Jika file tidak ada, jangan 500, tapi 404 dengan pesan jelas
            abort(404, "File [$type] tidak ditemukan di storage.");
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
    }

    public function previewUserFile($type)
    {
        $user = auth()->user();
        $pathField = $type . '_path';
        $path = $user->$pathField;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404, 'Berkas belum diunggah.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
    }

    public function avatar()
    {
        $user = auth()->user();
        $path = $user->avatar_path;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            // Cek apakah file default ada, jika tidak abort 404 saja
            $defaultPath = public_path('images/default-avatar.png');
            if (file_exists($defaultPath)) {
                return response()->file($defaultPath);
            }
            abort(404);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
    }

    public function viewDocument($type, $id = null)
    {
        if ($id) {
            $url = route('download.file', ['type' => $type, 'id' => $id]);
        } else {
            $url = route('preview.user_file', ['type' => $type]);
        }

        // Tambahkan parameter untuk menonaktifkan toolbar PDF browser agar tidak bisa diedit/didownload dengan mudah
        $url .= '#toolbar=0&navpanes=0&scrollbar=0';

        return view('shared.document_viewer', [
            'url' => $url,
            'type' => strtoupper($type)
        ]);
    }
}
