<?php

namespace App\Services\Omdb;

class OmdbApiService
{
    private string $endpoint;
    private string $apikey;
    private $curl;

    public function __construct()
    {
        $this->endpoint = config('omdbapi.endpoint');
        $this->apikey = config('omdbapi.apikey');
        $this->curl = curl_init();
    }

    public function getFilmById(string $imdbId): array
    {
        $query = http_build_query([
            'apikey' => $this->apikey,
            'i' => $imdbId,
            'type' => 'movie'
        ]);

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "{$this->endpoint}?{$query}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($this->curl);

        if (curl_errno($this->curl) === 500) {
            $info = curl_getinfo($this->curl);
        } else {
            $info = [];
        }

        curl_close($this->curl);
        $responseDecoded = json_decode($response, true);

        return [
            'data' => $responseDecoded,
            'info' => $info,
        ];
    }
}
