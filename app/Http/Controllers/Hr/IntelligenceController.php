<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\Hr\IntelligenceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class IntelligenceController extends Controller
{
    public function __construct(private readonly IntelligenceService $intelligenceService)
    {
    }

    public function index()
    {
        $data = $this->intelligenceService->getDashboardData((int) Auth::id());

        return view('hr.intelligence', array_merge([
            'pageTitle' => 'HR Intelligence',
        ], $data));
    }

    public function showCandidate(Application $application)
    {
        $detail = $this->intelligenceService->getCandidateDetailByApplication((int) Auth::id(), $application->id);
        
        if (!$detail) {
            abort(404, 'Candidate not found or unauthorized.');
        }

        return view('hr.candidates.show', [
            'data' => (object) $detail,
            'pageTitle' => 'Candidate Intelligence: ' . $detail['candidate']['name']
        ]);
    }
}
