<?php

use Mockery\MockInterface;
use App\Services\Omdb\OmdbApiService;

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
            '/movie/detail/?imdbId=tt12037194',
        );

    $response->assertStatus(200)
        ->assertJsonIsObject()
        ->assertJson([
            'message' => 'Ok',
        ])
        ->assertJsonStructure([
            'data' => [
                'title', 'year', 'imdbId', 'type', 'poster',
            ],
            'message'
        ]);
});

test('it returns error 404 when imdbId is invalid', function () {
    $this->mock(OmdbApiService::class)
        ->shouldReceive('getFilmById')
        ->once()
        ->with('tt120371')
        ->andReturn([
            'data' => [
                'Response' => 'False',
                'Error' => 'Incorrect IMDb ID.',
            ],
            'info' => []
        ]);

    $response = $response = $this->withHeaders([
        'Accept' => 'application/json',
    ])
        ->get(
            '/movie/detail/?imdbId=tt120371',
        );

    $response->assertStatus(404)
        ->assertJsonIsObject()
        ->assertJson([
            'message' => 'Incorrect IMDb ID.',
            'data' => [],
        ]);
});

test('it returns error 422 when imdbId is empty', function () {
    $response = $response = $this->withHeaders([
        'Accept' => 'application/json',
    ])
        ->get(
            '/movie/detail/?imdbId=',
        );

    $response->assertStatus(422)
        ->assertJsonIsObject()
        ->assertJson([
            'message' => 'The imdb id field is required.',
            'errors' => [
                'imdbId' => ['The imdb id field is required.']
            ],
        ]);
});

test('it returns film based on IMDB params', function () {
    $responseData = [
        "Search" => [
            [
                "Title" => "The Karate Kid",
                "Year" => "1984",
                "imdbID" => "tt0087538",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BNTkzY2YzNmYtY2ViMS00MThiLWFlYTEtOWQ1OTBiOGEwMTdhXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_SX300.jpg",
            ],
            [
                "Title" => "The Karate Kid",
                "Year" => "2010",
                "imdbID" => "tt1155076",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BYjQ1NzRhYjYtMWY3My00ODA0LTk5ZDctYjQ4YjE0M2RhMGNiXkEyXkFqcGdeQXVyNTUyMzE4Mzg@._V1_SX300.jpg",
            ],
            [
                "Title" => "The Karate Kid Part II",
                "Year" => "1986",
                "imdbID" => "tt0091326",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BMDdjNDJjOWYtZDNkYy00MTM3LTlhY2EtNzMxMjhhMjU3OTFmXkEyXkFqcGdeQXVyMTUzMDUzNTI3._V1_SX300.jpg",
            ],
            [
                "Title" => "The Karate Kid Part III",
                "Year" => "1989",
                "imdbID" => "tt0097647",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BODk0NzA4MTMtNGQ3Zi00OTdlLThiZmQtOTI0YWEyNDFiMTg2XkEyXkFqcGdeQXVyNTUyMzE4Mzg@._V1_SX300.jpg",
            ],
            [
                "Title" => "The Next Karate Kid",
                "Year" => "1994",
                "imdbID" => "tt0110657",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BODFjOTk3NTMtNTZkYi00ZWVjLTg2ZDItMTM1ODVlMDA0MmViXkEyXkFqcGdeQXVyMTcwOTQzOTYy._V1_SX300.jpg",
            ],
            [
                "Title" => "Karate Rock (The Kid with Iron Hands)",
                "Year" => "1990",
                "imdbID" => "tt0099922",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BMjE5NTQ5NzA1OV5BMl5BanBnXkFtZTcwODA1MTAyMQ@@._V1_SX300.jpg",
            ],
            [
                "Title" => "Karate Kid",
                "Year" => "1967",
                "imdbID" => "tt0426060",
                "Type" => "movie",
                "Poster" => "N/A",
            ],
            [
                "Title" => "The Way of the Karate Kid",
                "Year" => "2005",
                "imdbID" => "tt0435525",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BMTA0NTg0MzAwNjNeQTJeQWpwZ15BbWU3MDQyMzExMjM@._V1_SX300.jpg",
            ],
            [
                "Title" => "Dancing Karate Kid",
                "Year" => "2013",
                "imdbID" => "tt3255892",
                "Type" => "movie",
                "Poster" =>
                "https://m.media-amazon.com/images/M/MV5BNjIwZDZlZTAtNTVkZi00NmI4LWFlMWQtNjFmYzBmNGQ3NTMxXkEyXkFqcGdeQXVyNDc5OTYzMjU@._V1_SX300.jpg",
            ],
            [
                "Title" => "The Karate Kid: Production Diaries",
                "Year" => "2010",
                "imdbID" => "tt1730151",
                "Type" => "movie",
                "Poster" => "N/A",
            ],
        ],
        "totalResults" => "24",
        "Response" => "True",
    ];

    $this->mock(OmdbApiService::class)
        ->shouldReceive('getMovies')
        ->once()
        ->with('Karate Kid', 2024, 'movie', 1)
        ->andReturn([
            'data' => $responseData,
            'info' => [],
        ]);

    $query = http_build_query([
        'title' => 'Karate Kid',
        'year' => 2024,
        'type' => 'movie',
        'page' => 1,
    ]);

    $response = $response = $this->withHeaders([
        'Accept' => 'application/json',
    ])
        ->get(
            "/movie/search/?{$query}",
        );

    $response->assertStatus(200)
        ->assertJsonIsObject()
        ->assertJson([
            'message' => 'Ok',
        ])
        ->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => ['title', 'year', 'imdbId', 'type', 'poster'],
                ],
                'totalResults'
            ],
            'message'
        ]);
});

test('it returns 422 error when params does not meet validation', function () {
    $query = http_build_query([
        'title' => '',
        'year' => 2,
        'type' => 'a',
        'page' => 'a',
    ]);

    $response = $response = $this->withHeaders([
        'Accept' => 'application/json',
    ])
        ->get(
            "/movie/search/?{$query}",
        );

    $response->assertStatus(422)
        ->assertJsonStructure([
            'errors' => [
                'title', 'type', 'year', 'page'
            ],
            'message'
        ]);
});

test('it returns 404 error when data film is not found', function () {
    $mock = $this->mock(OmdbApiService::class, function (MockInterface $mock) {
        $mock->shouldReceive('getMovies')
            ->once()
            ->with('Karate Kidf', 2024, 'movie', 1)
            ->andReturn([
                'data' => [
                    'Response' => 'False',
                    'Error' => 'Movie not found!',
                ],
                'info' => [],
            ]);
    });

    $query = http_build_query([
        'title' => 'Karate Kidf',
        'year' => 2024,
        'type' => 'movie',
        'page' => 1,
    ]);

    $response = $response = $this->withHeaders([
        'Accept' => 'application/json',
    ])
        ->get(
            "/movie/search/?{$query}",
        );

    $response->assertStatus(200)
        ->assertJsonIsObject()
        ->assertJson([
            'message' => 'Ok',
            'data' => [
                'data' => [],
                'totalResults' => 0,
            ]
        ]);
});
