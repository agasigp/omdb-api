<?php

namespace App\Http\Controllers;

use App\Services\Omdb\OmdbApiService;

class OmdbController extends Controller
{
    public function detailMovie(OmdbApiService $omdbApiService)
    {
        $response = $omdbApiService->getFilmById(request('imdbID'));
        $data = $response['data'];
        $info = $response['info'];

        return response()->json([
            'data' => [
                'title' => $data['Title'],
                'year' => $data['Year'],
                'imdbId' => $data['imdbID'],
                'type' => $data['Type'],
                'poster' => $data['Poster'],
            ]
        ]);
    }
}
