<?php
// app/Services/KtpApiService.php
namespace App\services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class perekamanService
{
    protected $client;
    protected $baseUri;
    protected $credentials;

    public function __construct()
    {
        $this->baseUri = 'http://ektp.samarindakota.go.id/API/';
        $this->client = new Client([
            'base_uri' => env('KTP_API_URL'),
            'auth' => [
                config('externalApi.ktp_api.username'),
                config('externalApi.ktp_api.password')
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'verify' => false // Only for development with self-signed certs
        ]);
    }

    public function getData($startDate = null, $endDate = null)
    {
        try {
            $query = [];
            if ($startDate) $query['start_date'] = $startDate;
            if ($endDate) $query['end_date'] = $endDate;

            $response = $this->client->get('costum_date_perekaman.php', [
                'query' => $query
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new \Exception("API request failed: " . $e->getMessage());
        }
    }
}
