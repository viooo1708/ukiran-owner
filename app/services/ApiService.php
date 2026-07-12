<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    /**
     * URL Backend API
     */
    protected string $baseUrl;

    /**
     * Bearer Token
     */
    protected ?string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.url'), '/');
        $this->token = Session::get('token');
    }

    /**
     * Membuat request dengan Bearer Token jika tersedia.
     */
    protected function client()
    {
        $client = Http::acceptJson();

        if ($this->token) {
            $client = $client->withToken($this->token);
        }

        return $client;
    }

    /**
     * GET Request
     */
    public function get(string $endpoint, array $query = [])
    {
        return $this->client()
            ->get($this->baseUrl . $endpoint, $query);
    }

    /**
     * POST Request
     */
    public function post(string $endpoint, array $data = [])
    {
        return $this->client()
            ->post($this->baseUrl . $endpoint, $data);
    }

    /**
     * PUT Request
     */
    public function put(string $endpoint, array $data = [])
    {
        return $this->client()
            ->put($this->baseUrl . $endpoint, $data);
    }

    /**
     * DELETE Request
     */
    public function delete(string $endpoint)
    {
        return $this->client()
            ->delete($this->baseUrl . $endpoint);
    }

    /**
     * Upload File
     */
    public function upload(string $endpoint, array $data = [], ?string $filePath = null, string $fileField = 'gambar')
    {
        $client = $this->client();

        if ($filePath && file_exists($filePath)) {
            $client = $client->attach(
                $fileField,
                fopen($filePath, 'r'),
                basename($filePath)
            );
        }

        return $client->post($this->baseUrl . $endpoint, $data);
    }
}
