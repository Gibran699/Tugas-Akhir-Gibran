<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\Response;

class ExternalApiService
{
    protected $baseUrl;
    protected $credentials;
    protected $tokenKey;
    protected $retryCount = 0;
    protected $maxRetries = 1; // Max retry attempts when token expires

    public function __construct()
    {
        $this->baseUrl = config('externalApi.base_url');
        $this->credentials = config('externalApi.credentials');
        $this->tokenKey = config('externalApi.token_key');
    }

    public function authenticate()
    {
        return Cache::remember('external_api_token', now()->addHours(1), function () {
            $password = $this->credentials['password'];

            // if (str_starts_with($password, 'encrypted:')) {
            //     $password = Crypt::decryptString(str_replace('encrypted:', '', $password));
            // }

            // Tambahkan environment check untuk keamanan
            $verifySSL = app()->environment('production')
                ? storage_path('certs/cacert.pem')
                : false;

            $response = Http::timeout(30)
                ->withOptions(['verify' => $verifySSL])
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->post($this->baseUrl . '/api/login', [
                    'email' => $this->credentials['email'],
                    'password' => $password
                ]);

            // Validasi response dasar
            if ($response->body() === '' || $response->body() === null) {
                throw new \Exception('Empty response from API');
            }

            $responseData = $response->json();

            // Validasi JSON parsing
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
            }

            // Validasi response structure
            if (!$response->successful()) {
                $errorMsg = $responseData['message'] ?? $response->status() . ' Error';
                throw new \Exception('API Error: ' . $errorMsg);
            }

            // Cek berbagai format token yang mungkin
            $token = $responseData['access_token']
                ?? $responseData['token']
                ?? $responseData['data']['token']
                ?? null;

            if (!$token) {
                throw new \Exception('Token not found in API response');
            }

            return $token;
        });
    }

    protected function handleAuthError(Response $response)
    {
        $status = $response->status();

        try {
            $body = $response->json();
            $errorMessage = $body['message'] ?? $body['error'] ?? 'Authentication failed';
        } catch (\Exception $e) {
            $errorMessage = $response->body();
        }

        Cache::forget('external_api_token');
        throw new \Exception("API Authentication Error [$status]: $errorMessage");
    }

    protected function handleRequestError(Response $response)
    {
        $status = $response->status();

        try {
            $body = $response->json();
            $errorMessage = $body['message'] ?? $body['error'] ?? 'Request failed';
        } catch (\Exception $e) {
            $errorMessage = $response->body();
        }

        if ($status === 401) {
            Cache::forget('external_api_token');
        }

        throw new \Exception("API Request Error [$status]: $errorMessage", $status);
    }

    public function makeAuthenticatedRequest($method, $endpoint, $data = [])
    {
        $verifySSL = app()->environment('production')
            ? storage_path('certs/cacert.pem')
            : false;
        try {
            $token = $this->authenticate();
            $response = Http::withOptions(['verify' => $verifySSL])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ])->timeout(30)->$method($this->baseUrl . $endpoint, $data);

            if (!$response->successful()) {
                $this->handleRequestError($response);
            }

            $responseData = $response->json();

            // Validasi response adalah array
            if (!is_array($responseData)) {
                throw new \Exception('Invalid API response format');
            }

            return $responseData;
        } catch (\Exception $e) {
            throw new \Exception('API Request Failed: ' . $e->getMessage());
        }
    }

    // Helper methods with improved error handling
    public function get($endpoint, array $query = [])
    {
        return $this->makeAuthenticatedRequest('get', $endpoint, ['query' => $query]);
    }

    public function post($endpoint, array $data = [])
    {
        return $this->makeAuthenticatedRequest('post', $endpoint, $data);
    }

    public function put($endpoint, array $data = [])
    {
        return $this->makeAuthenticatedRequest('put', $endpoint, $data);
    }

    public function delete($endpoint, array $data = [])
    {
        return $this->makeAuthenticatedRequest('delete', $endpoint, $data);
    }
}
