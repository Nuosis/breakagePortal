<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FileMakerService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('filemaker.api_url');
        $this->username = config('filemaker.username');
        $this->password = config('filemaker.password');
    }

    private function getToken()
    {
        $response = Http::withBasicAuth($this->username, $this->password)
                        ->post($this->baseUrl . '/sessions');
        
        return $response->json()['token'];
    }

    public function fetchBreakageData($studentId)
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
                        ->get($this->baseUrl . '/layouts/your-layout/records', [
                            'query' => [
                                'query' => [
                                    [
                                        'field' => 'student_id',
                                        'value' => $studentId
                                    ]
                                ]
                            ]
                        ]);

        return $response->json();
    }
}
