<?php

use App\Services\Omdb\OmdbApiService;
use Illuminate\Testing\Fluent\AssertableJson;

test('it returns film based on IMDB id', function () {
    $responseData = [
        "Title" => "Furiosa: A Mad Max Saga",
        "Year" => "2024",
        "Rated" => "R",
        "Released" => "24 May 2024",
        "Runtime" => "148 min",
        "Genre" => "Action, Adventure, Sci-Fi",
        "Director" => "George Miller",
        "Writer" => "George Miller, Nick Lathouris",
        "Actors" => "Anya Taylor-Joy, Chris Hemsworth, Tom Burke",
        "Plot" => "The origin story of renegade warrior Furiosa before her encounter and teamup with Mad Max.",
        "Language" => "English",
        "Country" => "Australia, United States",
        "Awards" => "N/A",
        "Poster" => "https://m.media-amazon.com/images/M/MV5BNmYzMWVjNmQtNjJjNy00M2Y4LTkzZjQtZWQ5NmYzMjRjMDIzXkEyXkFqcGdeQXVyMTM1NjM2ODg1._V1_SX300.jpg",
        "Ratings" => [
            [
                "Source" => "Internet Movie Database",
                "Value" => "7.9/10"
            ],
            [
                "Source" => "Rotten Tomatoes",
                "Value" => "90%"
            ]
        ],
        "Metascore" => "N/A",
        "imdbRating" => "7.9",
        "imdbVotes" => "70,225",
        "imdbID" => "tt12037194",
        "Type" => "movie",
        "DVD" => "N/A",
        "BoxOffice" => "$54,463,537",
        "Production" => "N/A",
        "Website" => "N/A",
        "Response" => "True"
    ];

    $this->mock(OmdbApiService::class)
        ->shouldReceive('getFilmById')
        ->once()
        ->with('tt12037194')
        ->andReturn([
            'data' => $responseData,
            'info' => []
        ]);

    $response = $response = $this->withHeaders([
        'Accept' => 'application/json',
    ])
        ->get(
            '/movie/detail/?imdbID=tt12037194',
        );

    $response->assertStatus(200)
        ->assertJsonIsObject()
        ->assertJsonStructure([
            'data' => [
                'title', 'year', 'imdbId', 'type', 'poster',
            ]
        ]);
});
