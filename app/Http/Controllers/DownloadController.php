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
                abort(403, 'You are not the owner of this job posting.');
            }
        } else {
            if ($application->user_id !== auth()->id() && !app()->environment('local')) {
                abort(403, 'This file does not belong to you.');
            }
        }

        $pathField = $type . '_path';
        // Prefer application snapshot if it exists on disk, otherwise use user's current file
        $appFilePath  = $application->$pathField;
        $userFilePath = $application->user->$pathField;
        $path = ($appFilePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($appFilePath))
            ? $appFilePath
            : $userFilePath;

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
            // Check if default avatar exists, otherwise abort 404
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
                    abort(403, 'You are not the owner of this job posting.');
                }
            } else {
                if ($application->user_id !== auth()->id() && !app()->environment('local')) {
                    abort(403, 'This file does not belong to you.');
                }
            }

            $pathField = $type . '_path';
            // Application snapshot may be stale (file deleted/replaced) — prefer
            // the application's own copy only if it physically exists on disk,
            // otherwise fall back to the user's current profile file.
            $disk = \Illuminate\Support\Facades\Storage::disk('public');
            $appFilePath  = $application->$pathField;
            $userFilePath = $application->user->$pathField;
            $path = ($appFilePath && $disk->exists($appFilePath))
                ? $appFilePath
                : $userFilePath;
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
