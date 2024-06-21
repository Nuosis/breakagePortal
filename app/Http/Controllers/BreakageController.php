<?php

namespace App\Http\Controllers;

use App\Services\FileMakerService;
use Illuminate\Http\Request;

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

        return view('lookup-results', compact('breakageData'));
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

