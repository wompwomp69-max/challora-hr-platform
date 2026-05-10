<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($type, $id)
    {
        $application = \App\Models\Application::with(['job', 'user'])->findOrFail($id);
        
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
        // Fall back to user's file if application doesn't have its own copy
        $path = $application->$pathField ?: $application->user->$pathField;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return response(view('shared.document_not_found', [
                'type' => $type,
                'message' => 'File not found in storage.',
            ]), 200);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
    }

    public function previewUserFile($type)
    {
        $user = auth()->user();
        $pathField = $type . '_path';
        $path = $user->$pathField;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return response(view('shared.document_not_found', [
                'type' => $type,
                'message' => 'You have not uploaded this document yet.',
            ]), 200);
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
            $application = \App\Models\Application::with(['user', 'job'])->findOrFail($id);

            // Authorization: HR must own the job, candidate must own the application
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
            // cv_path, diploma_path, photo_path are stored on the user profile,
            // but may also be snapshotted on the application — fall back to user
            $path = $application->$pathField ?: $application->user->$pathField;
        } else {
            $user = auth()->user();
            $pathField = $type . '_path';
            $path = $user->$pathField;
        }

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return response(view('shared.document_not_found', [
                'type' => $type,
                'message' => 'This file could not be found on the server.',
            ]), 200);
        }

        $fileUrl = str_replace('http://', 'https://', \Illuminate\Support\Facades\Storage::disk('public')->url($path));
        $fileUrl .= '#toolbar=0&navpanes=0&scrollbar=0';

        return view('shared.document_viewer', [
            'url' => $fileUrl,
            'type' => strtoupper($type)
        ]);
    }
}
