<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Services\Hr\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function __invoke()
    {
        $data = $this->dashboardService->getDashboardData(auth()->id());

        return view('hr.dashboard', array_merge(['pageTitle' => 'HR Dashboard'], $data));
    }
}
