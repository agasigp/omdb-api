<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Omdb\OmdbApiService;

class OmdbController extends Controller
{
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

        return response()->json([
            'message' => 'Ok',
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
