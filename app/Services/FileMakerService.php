<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FileMakerService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('filemaker.api_url');
        $this->username = config('filemaker.username');
        $this->password = config('filemaker.password');
    }

    private function getToken()
    {
        try {
            $url = "{$this->baseUrl}/sessions";
            $authHeader = "Basic " . base64_encode("{$this->username}:{$this->password}");
    
            Log::info('Requesting token with Basic Auth', ['url' => $url, 'Authorization' => $authHeader]);
    
            $response = Http::withHeaders([
                                'Content-Type' => 'application/json',
                                'Authorization' => $authHeader
                            ])
                            ->post($url, json_encode(new \stdClass())); // Explicitly send an empty JSON object
    
            Log::info('Raw Response:', $response->json());
    
            $responseData = $response->json();
            if ($response->successful() && isset($responseData['response']['token'])) {
                $this->token = $responseData['response']['token'];
                return $this->token;
            } else {
                throw new \Exception('Failed to retrieve token from response: ' . json_encode($responseData));
            }
        } catch (\Exception $e) {
            Log::error('Failed to get token: ' . $e->getMessage());
            return null;
        }
    }
    
    
    
    


    private function releaseToken($token)
    {
        try {
            Http::withToken($token)->delete("{$this->baseUrl}/sessions/{$token}");
        } catch (\Exception $e) {
            Log::error('Failed to release token: ' . $e->getMessage());
        }
    }

    public function fetchBreakageData($studentId)
    {
        $token = $this->getToken();

        if (!$token) {
            return ['error' => 'Failed to retrieve token'];
        }

        try {
            $response = Http::withToken($token)
                            ->get("{$this->baseUrl}/layouts/ydapiBillable/records", [
                                'query' => [
                                    [
                                        'partyID' => $studentId
                                    ]
                                ]
                            ]);

            $data = $response->json();
            
            // Release the token after the call
            $this->releaseToken($token);

            return $data;
        } catch (\Exception $e) {
            Log::error('Failed to fetch breakage data: ' . $e->getMessage());
            return ['error' => 'Failed to fetch breakage data'];
        }
    }
}
