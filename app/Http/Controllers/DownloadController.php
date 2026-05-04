<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download(Request $request, $type, $id)
    {
        [$application, $path] = $this->getAuthorizedApplicationPath($type, $id);

        $fallbackBackUrl = auth()->user()->role === \App\Enums\UserRole::HR
            ? route('hr.applications.index')
            : route('user.applications.index');
        $backUrl = $request->query('back', url()->previous());
        if (!is_string($backUrl) || !str_starts_with($backUrl, url('/'))) {
            $backUrl = $fallbackBackUrl;
        }

        return view('user.settings.preview-file', [
            'type' => $type,
            'fileName' => basename($path),
            'rawUrl' => route('download.file.raw', ['type' => $type, 'id' => $application->id]),
            'backUrl' => $backUrl,
            'isPdf' => strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf',
            'isImage' => str_starts_with(Storage::disk('public')->mimeType($path) ?? '', 'image/'),
        ]);
    }

    public function downloadRaw($type, $id)
    {
        [, $path] = $this->getAuthorizedApplicationPath($type, $id);

        return Storage::disk('public')->response($path, basename($path), [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
=======

class DownloadController extends Controller
{
    public function download($type, $id)
    {
        $application = \App\Models\Application::with('job')->findOrFail($id);
        
        // Authorization check: Only owner of the job (HR) or the candidate themselves
        if (auth()->user()->role === \App\Enums\UserRole::HR) {
            if ($application->job->created_by !== auth()->id()) {
                abort(403);
            }
        } else {
            if ($application->user_id !== auth()->id()) {
                abort(403);
            }
        }

        $pathField = $type . '_path'; // cv_path, diploma_path, photo_path
        $path = $application->$pathField;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
    }

    public function previewUserFile($type)
    {
<<<<<<< HEAD
        $allowedTypes = ['cv', 'diploma', 'photo'];
        if (!in_array($type, $allowedTypes, true)) {
            abort(404);
        }

=======
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
        $user = auth()->user();
        $pathField = $type . '_path';
        $path = $user->$pathField;

<<<<<<< HEAD
        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'Berkas belum diunggah.');
        }

        return view('user.settings.preview-file', [
            'type' => $type,
            'fileName' => basename($path),
            'rawUrl' => route('preview.user_file.raw', ['type' => $type]),
            'backUrl' => route('user.settings.edit'),
            'isPdf' => strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf',
            'isImage' => str_starts_with(Storage::disk('public')->mimeType($path) ?? '', 'image/'),
        ]);
    }

    public function previewUserFileRaw($type)
    {
        $allowedTypes = ['cv', 'diploma', 'photo'];
        if (!in_array($type, $allowedTypes, true)) {
            abort(404);
        }

        $user = auth()->user();
        $pathField = $type . '_path';
        $path = $user->$pathField;

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'Berkas belum diunggah.');
        }

        $isPdf = strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf';
        $headers = [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ];

        // Keep PDF in read-only browser preview mode and hide built-in toolbar actions.
        if ($isPdf) {
            $headers['Content-Disposition'] = 'inline; filename="' . basename($path) . '"';
        }

        return Storage::disk('public')->response($path, basename($path), $headers);
=======
        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404, 'Berkas belum diunggah.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
    }

    public function avatar()
    {
        $user = auth()->user();
        $path = $user->avatar_path;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            // Return default avatar if needed or 404
            return response()->file(public_path('images/default-avatar.png')); // Hypothetical default
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
    }
<<<<<<< HEAD

    protected function getAuthorizedApplicationPath(string $type, int|string $id): array
    {
        $allowedTypes = ['cv', 'diploma', 'photo'];
        if (!in_array($type, $allowedTypes, true)) {
            abort(404);
        }

        $application = \App\Models\Application::with('job')->findOrFail($id);

        // Authorization check: Only owner of the job (HR) or the candidate themselves
        if (auth()->user()->role === \App\Enums\UserRole::HR) {
            if ($application->job->created_by !== auth()->id()) {
                abort(403);
            }
        } elseif ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $pathField = $type . '_path';
        $path = $application->$pathField;
        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return [$application, $path];
    }
=======
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
}
