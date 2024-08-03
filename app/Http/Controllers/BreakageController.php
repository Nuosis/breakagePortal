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
        $data = $request->all();
        $data['date'] = date('m-d-Y');  // Add today's date to the data in US standard
    
        try {
            $result = $this->fileMakerService->newBreakage($data);
            Log::info('Submission result: ', $result);
    
            if (isset($result['response']) && $result['messages'][0]['message'] == 'OK') {
                return redirect()->route('confirmation')->with('status', 'success');
            } else {
                return view('lookup-results', [
                    'breakageData' => $this->fileMakerService->fetchBreakageData($data['student_id']),
                    'sites' => $this->fileMakerService->getSites(),
                    'error' => 'There was an error submitting your breakage report. Please try again.',
                    'submittedData' => $data
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error submitting breakage report: ' . $e->getMessage());
            return view('lookup-results', [
                'breakageData' => $this->fileMakerService->fetchBreakageData($data['student_id']),
                'sites' => $this->fileMakerService->getSites(),
                'error' => 'There was an error submitting your breakage report. Please try again.',
                'submittedData' => $data
            ]);
        }
    }
    
}

