<?php

namespace App\Http\Controllers;

use App\Services\FileMakerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BreakageController extends Controller
{
    protected $fileMakerService;

    public function __construct(FileMakerService $fileMakerService)
    {
        $this->fileMakerService = $fileMakerService;
    }

    public function showLookupForm()
    {
        return view('lookup');
    }

    public function lookupBreakage(Request $request)
    {
        $studentId = $request->input('student_id');
        $breakageData = $this->fileMakerService->fetchBreakageData($studentId);
        $sites = $this->fileMakerService->getSites();

        Log::info('Breakage Data:', $breakageData);
        Log::info('Sites Data:', $sites);

        return view('lookup-results', compact('breakageData', 'sites'));
    }

    public function showSubmitForm()
    {
        return view('submit');
    }

    public function submitBreakage(Request $request)
    {
        // Handle form submission logic and interact with FileMaker API
    }
}

