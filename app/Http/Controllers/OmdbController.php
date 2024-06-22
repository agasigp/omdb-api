<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Omdb\OmdbApiService;
use Illuminate\Support\Facades\Cache;

class OmdbController extends Controller
{
    public function getPopularMovies()
    {
        // Not yet implemented because omdbapi doesn't have api for getting popular movies
        // https://www.omdbapi.com/#parameters
    }

    public function detailMovie(Request $request, OmdbApiService $omdbApiService)
    {
        $request->validate([
            'imdbId' => 'required',
        ]);

        $response = $omdbApiService->getFilmById(request('imdbId'));
        $data = $response['data'];
        $info = $response['info'];

        if (isset($data['Response']) && $data['Response'] === 'False') {
            return response()->json([
                'message' => $data['Error'],
                'data' => [
                ]
            ], 404);
        }

        if (isset($info['http_code']) && $data['http_code'] !== 200) {
            return response()->json([
                'message' => 'Error get data from omdb Api',
                'data' => [
                ]
            ], 500);
        }

        $movie = Cache::remember('movie', 60, function () use ($data) {
            return $data;
        });

        return response()->json([
            'message' => 'Ok',
            'data' => [
                'title' => $movie['Title'],
                'year' => $movie['Year'],
                'imdbId' => $movie['imdbID'],
                'type' => $movie['Type'],
                'poster' => $movie['Poster'],
            ]
        ]);
    }

    public function getMovies(Request $request, OmdbApiService $omdbApiService)
    {
        $validate = $request->validate([
            'title' => 'required',
            'type' => ['required', Rule::in(['movie', 'series', 'episode'])],
            'page' => 'required|numeric',
            'year' => 'nullable|numeric|min_digits:4'
        ]);

        $response = $omdbApiService->getMovies(
            $validate['title'],
            request('year'),
            $validate['type'],
            $validate['page'],
        );

        if (isset($response['data']['Response']) && $response['data']['Response'] === 'False') {
            return response()->json([
                'message' => 'Ok',
                'data' => [
                    'data' => [],
                    'totalResults' => 0
                ]
            ]);
        }

        $dataCollection = collect($response['data']['Search']);
        $data = $dataCollection->map(function(array $item, $key) {
            return [
                'title' => $item['Title'],
                'year' => $item['Year'],
                'imdbId' => $item['imdbID'],
                'type' => $item['Type'],
                'poster' => $item['Poster'],
            ];
        });

        $movies = Cache::remember('movies', 60, function () use ($data) {
            return $data->all();
        });

        $info = $response['info'];

        if (isset($info['http_code']) && $data['http_code'] !== 200) {
            return response()->json([
                'message' => 'Error get data from omdb Api',
                'data' => []
            ], 500);
        }

        return response()->json([
            'message' => 'Ok',
            'data' => [
                'data' => $movies,
                'totalResults' => $response['data']['totalResults']
            ],
        ]);
    }
}
