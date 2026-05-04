<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.backend.url', 'http://localhost:5000/api');
    }

    protected function getHeaders()
    {
        $token = Session::get('api_token');
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    public function post(string $endpoint, array $data = [])
    {
        return Http::withHeaders($this->getHeaders())->post($this->baseUrl . $endpoint, $data);
    }

    public function get(string $endpoint, array $query = [])
    {
        return Http::withHeaders($this->getHeaders())->get($this->baseUrl . $endpoint, $query);
    }

    public function put(string $endpoint, array $data = [])
    {
        return Http::withHeaders($this->getHeaders())->put($this->baseUrl . $endpoint, $data);
    }

    public function delete(string $endpoint)
    {
        return Http::withHeaders($this->getHeaders())->delete($this->baseUrl . $endpoint);
    }
}
