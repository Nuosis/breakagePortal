<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class FileMakerService
{
    protected $client;
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('filemaker.api_url');
        $this->username = config('filemaker.username');
        $this->password = config('filemaker.password');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    private function getToken($dbName = "InventoryTracker")
    {
        try {
            $uri = $dbName . "/sessions";
            $url = $this->baseUrl . $uri;
            $authHeader = "Basic " . base64_encode("{$this->username}:{$this->password}");

            $response = $this->client->post($url, [
                'headers' => ['Authorization' => $authHeader],
                'verify' => false // Bypass SSL verification TURN OFF IN PRODUCTION
            ]);

            // Decode the response body to an array
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Log the raw response data
            // Log::info('Token Response:', $responseData);

            // Check for the existence of the token in the response data
            if ($response->getStatusCode() === 200 && isset($responseData['response']['token'])) {
                $this->token = $responseData['response']['token'];
                return $this->token;
            } else {
                // Log an error if the expected token isn't found
                Log::error('Token not found in response', [
                    'status_code' => $response->getStatusCode(),
                    'response' => $responseData
                ]);
                throw new \Exception('Failed to retrieve token from response: ' . json_encode($responseData));
            }
        } catch (GuzzleException $e) {
            Log::error('Failed to get token: ' . $e->getMessage());
            return null;
        }
    }

    private function releaseToken($token, $dbName = "InventoryTracker")
    {
        try {
            $this->client->delete("/fmi/data/vLatest/databases/{$dbName}/sessions/{$token}", [
                'headers' => ['Authorization' => "Bearer {$token}"],
                'verify' => false // TURN OFF IN PRODUCTION
            ]);
            // Log::info('Token released');
        } catch (GuzzleException $e) {
            Log::error('Failed to release token: ' . $e->getMessage());
        }
    }

    public function fetchBreakageData($studentId)
    {
        $token = $this->getToken();

        if (!$token) {
            return ['error' => 'Failed to retrieve token'];
        }

        $url = "/fmi/data/vLatest/databases/InventoryTracker/layouts/Web_DamagedEquip/_find";  // Adjusted endpoint for finding records
        $params = [  // Define the query parameters as JSON
            'query' => [
                [
                    'StudentID' => $studentId
                ]
            ]
        ];

        // Log::info('Requesting token with Basic Auth', ['url' => $url, 'params' => $params]);

        try {
            // Make a POST request to the find endpoint with the query parameters
            $response = $this->client->post($url, [
                'headers' => ['Authorization' => "Bearer {$token}", 'Content-Type' => 'application/json'],
                'json' => $params,
                'verify' => false // TURN OFF IN PRODUCTION
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            Log::info('Fetch Breakage Data Response:', $data);
            $this->releaseToken($token, "InventoryTracker");

            if (isset($data['response'])) {
                return $data;  // Return only the response part if needed, adjust based on actual API response
            } else {
                return ['error' => 'No data found'];  // Handle the case where no data is returned
            }
        } catch (GuzzleException $e) {
            $this->releaseToken($token, "InventoryTracker");
            Log::error('Failed to fetch breakage data: ' . $e->getMessage());
            return ['error' => 'Failed to fetch breakage data'];
        }
    }

    public function fetchBreakageDataForDevice($studentId, $equipment)
    {
        $token = $this->getToken();
    
        if (!$token) {
            return ['error' => 'Failed to retrieve token'];
        }
    
        $url = "/fmi/data/vLatest/databases/InventoryTracker/layouts/Web_DamagedEquip/_find";  // Adjusted endpoint for finding records
        $params = [  // Define the query parameters as JSON
            'query' => [
                [
                    'StudentID' => $studentId,
                    'Hardware' => '=='.$equipment
                ]
            ]
        ];
        Log::info('BreakageDataforStudent Params: ', $params);
    
        try {
            // Make a POST request to the find endpoint with the query parameters
            $response = $this->client->post($url, [
                'headers' => ['Authorization' => "Bearer {$token}", 'Content-Type' => 'application/json'],
                'json' => $params,
                'verify' => false // TURN OFF IN PRODUCTION
            ]);
    
            $data = json_decode($response->getBody()->getContents(), true);
    
            // Check for 401 error code and handle it
            if (isset($data['messages'][0]['code']) && $data['messages'][0]['code'] == 401) {
                Log::info('No records match the request for device: ' . $equipment, ['data' => $data]);
                return $data;
            }
    
            Log::info('Fetch Breakage Data for ' . $equipment . ' Response:', ['data' => $data]);
            $this->releaseToken($token, "InventoryTracker");
    
            if (isset($data['response'])) {
                return $data;  // Return only the response part if needed, adjust based on actual API response
            } else {
                return ['error' => 'No data found'];  // Handle the case where no data is returned
            }
        } catch (GuzzleException $e) {
            $this->releaseToken($token, "InventoryTracker");
            Log::error('Failed to fetch breakage data for ' . $equipment . ': ' . $e->getMessage());
            return ['error' => 'Failed to fetch breakage data'];
        }
    }

    public function costLookup($damageType, $equipment, $incidentNo)
    {
        $token = $this->getToken();

        if (!$token) {
            return ['error' => 'Failed to retrieve token'];
        }

        $url = "/fmi/data/vLatest/databases/InventoryTracker/layouts/dapi_damageCosts/_find";  // Adjusted endpoint for finding records
        $params = [  // Define the query parameters as JSON
            'query' => [
                [
                    'Incident' => $damageType,
                    'Hardware' => '=='.$equipment,
                    'IncidentNo' => $incidentNo
                ]
            ]
        ];
        Log::info('BreakageDataforDevice Params: ', $params);

        // Log::info('Requesting token with Basic Auth', ['url' => $url, 'params' => $params]);

        try {
            // Make a POST request to the find endpoint with the query parameters
            $response = $this->client->post($url, [
                'headers' => ['Authorization' => "Bearer {$token}", 'Content-Type' => 'application/json'],
                'json' => $params,
                'verify' => false // TURN OFF IN PRODUCTION
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            Log::info('Fetch Cost Lookup Response:', $data);
            $this->releaseToken($token, "InventoryTracker");

            if (isset($data['response'])) {
                return $data;  // Return only the response part if needed, adjust based on actual API response
            } else {
                return ['error' => 'No data found'];  // Handle the case where no data is returned
            }
        } catch (GuzzleException $e) {
            $this->releaseToken($token, "InventoryTracker");
            Log::error('Failed to fetch Cost Lookup: ' . $e->getMessage());
            return ['error' => 'Failed to fetch Cost Lookup'];
        }
    }

    public function getSites($query = "*")
    {
        $token = $this->getToken();

        if (!$token) {
            return ['error' => 'Failed to retrieve token'];
        }

        $url = "/fmi/data/vLatest/databases/InventoryTracker/layouts/dapi_Sites_List/_find";  // Adjusted endpoint for finding records
        $params = [  // Define the query parameters as JSON
            'query' => [
                [
                    'Site' => $query
                ]
            ]
        ];

        try {
            // Make a POST request to the find endpoint with the query parameters
            $response = $this->client->post($url, [
                'headers' => ['Authorization' => "Bearer {$token}", 'Content-Type' => 'application/json'],
                'json' => $params,
                'verify' => false // TURN OFF IN PRODUCTION
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            Log::info('Fetch Sites Response:', $data);
            $this->releaseToken($token, "InventoryTracker");

            if (isset($data['response'])) {
                return $data;  // Return only the response part if needed, adjust based on actual API response
            } else {
                return ['error' => 'No data found'];  // Handle the case where no data is returned
            }
        } catch (GuzzleException $e) {
            $this->releaseToken($token, "InventoryTracker");
            Log::error('Failed to fetch sites data: ' . $e->getMessage());
            return ['error' => 'Failed to fetch sites data'];
        }
    }

    public function newBreakage($data)
    {
        $token = $this->getToken();
        if (!$token) {
            return ['error' => 'Failed to retrieve token'];
        }
    
        // Fetch breakage data for the device
        // Log::info('Submitted Data: ', $data);
        $breakageDataForDevice = $this->fetchBreakageDataForDevice($data['student_id'], $data['equipment']);
        $count = $breakageDataForDevice['response']['dataInfo']['foundCount'];
        // Log::info('Breakage Count: ' . $count);

        
        // Lookup cost
        $costData = $this->costLookup($data['damage_type'], $data['equipment'], $count+1);
        $cost = $costData['response']['data'][0]['fieldData']['Cost'];
        // Log::info('Breakage Cost:' . $cost);
        // Log::info('Data Date:' . $data['date']);

    
        $url = "/fmi/data/vLatest/databases/InventoryTracker/layouts/Web_DamagedEquip/records";
        $params = [
            'fieldData' => [
                'Date' => $data['date'],
                'FANo' => $data['fa'],
                'Incident' => $data['damage_type'],
                'Hardware' => $data['equipment'],
                'StudentID' => $data['student_id'],
                'StudentFirstName' => $data['student_first_name'],
                'StudentLastName' => $data['student_last_name'],
                'Cost' => $cost
            ],
            // 'script' => 'Create TechOrder from Damaged Equip'
        ];
        if (!empty($data['notes'])) {
          $params['fieldData']['Notes'] = $data['notes'];
        }
        Log::info('Submit Breakage Record Params: ', $params);
    
        try {
            // Make a POST request to the find endpoint with the query parameters
            $response = $this->client->post($url, [
                'headers' => ['Authorization' => "Bearer {$token}", 'Content-Type' => 'application/json'],
                'json' => $params,
                'verify' => false // TURN OFF IN PRODUCTION
            ]);
    
            $data = json_decode($response->getBody()->getContents(), true);
            // Log::info('Fetch Breakage Form Submit Response:', $data);
            $this->releaseToken($token, "InventoryTracker");
    
            if (isset($data['response'])) {
                return $data;  // Return only the response part if needed, adjust based on actual API response
            } else {
                return ['error' => 'No data found'];  // Handle the case where no data is returned
            }
        } catch (GuzzleException $e) {
            $this->releaseToken($token, "InventoryTracker");
            Log::error('Failed to send Breakage Form Submit data: ' . $e->getMessage());
            return ['error' => 'Failed to create breakage record'];
        }
    }
    
}
