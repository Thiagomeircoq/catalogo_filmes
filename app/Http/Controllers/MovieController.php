<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class MovieController extends Controller {

    public function getMovies() {
        $popularityMovies = $this->getPopularityMovies();
        $randomMovie = $this->getRandomMovie($popularityMovies);
        $categoryMovies = $this->allCategoryMovies();
    
        return view('welcome', ['randomMovie' => $randomMovie, 'categoryMovies' => $categoryMovies]);
    }
    
    private function allCategoryMovies() {
        $categoryMovies = [
            'Populares' => [
                'movies' => $this->getPopularityMovies(),
                'category_id' => null,
            ],
            'Ação' => [
                'movies' => $this->getMoviesByCategory(28, 20),
                'category_id' => 28,
            ],
            'Comédia' => [
                'movies' => $this->getMoviesByCategory(35, 20),
                'category_id' => 35,
            ],
            'Terror' => [
                'movies' => $this->getMoviesByCategory(27, 20),
                'category_id' => 27,
            ],
            'Romance' => [
                'movies' => $this->getMoviesByCategory(10749, 20),
                'category_id' => 10749,
            ],
            'Documentario' => [
                'movies' => $this->getMoviesByCategory(99, 20),
                'category_id' => 99,
            ],
        ];
    
        return $categoryMovies;
    }

    private function getPopularityMovies() {
        $response = Http::asJson()
            ->get(config('services.tmdb.endpoint').'discover/movie', [
                'api_key' => config('services.tmdb.api'),
                'language' => 'pt-BR',
                'sort_by' => 'popularity.desc',
                'page' => 1,
                'limit' => 20
            ])
            ->json();
    
        return $response['results'];
    }
    
    private function getRandomMovie($movies) {
        $filteredMovies = array_filter($movies, function($movie) {
            return $movie['popularity'] > 400.000;
        });
    
        $randomMovie = $filteredMovies[array_rand($filteredMovies)];
    
        $response = Http::asJson()
            ->get(config('services.tmdb.endpoint').'movie/'.$randomMovie['id'], [
                'api_key' => config('services.tmdb.api'),
                'language' => 'pt-BR'
            ])
            ->json();
    
        return $response;
    }

    private function getMoviesByCategory($categoryId, $perPage) {
        $response = Http::asJson()
            ->get(config('services.tmdb.endpoint').'discover/movie', [
                'api_key' => config('services.tmdb.api'),
                'language' => 'pt-BR',
                'sort_by' => 'popularity.desc',
                'page' => request('page', 1),
                'limit' => $perPage,
                'with_genres' => $categoryId
            ])
            ->json();
    
        $movies = $response['results'];
    
        return new LengthAwarePaginator(
            $movies,
            $response['total_results'],
            $perPage,
            request('page', 1),
            ['path' => request()->url()]
        );
    }
    
    public function searchMovies(Request $query) {
        $request = $query->input('search');

        $response = Http::asJson()
            ->get(config('services.tmdb.endpoint').'search/movie', [
                'api_key' => config('services.tmdb.api'),
                'query' => $request,
                'language' => 'pt-BR'
            ])
            ->json();
    
        $movies = $response['results'];
    
        $filteredMovies = array_filter($movies, function ($movie) {
            return $movie['popularity'] > 20.000;
        });
    
        return view('movies.search', ['movies' => $filteredMovies]);
    }

    public function getMovie($id = null) {
        $movieResponse = Http::asJson()
            ->get(config('services.tmdb.endpoint').'movie/'.$id.'?api_key='.config('services.tmdb.api').'&language=pt-BR');
    
        $creditsResponse = Http::asJson()
            ->get(config('services.tmdb.endpoint').'movie/'.$id.'/credits?api_key='.config('services.tmdb.api').'&language=pt-BR');
    
        if ($movieResponse->successful() && $creditsResponse->successful()) {
            $movie = $movieResponse->json();
            $credits = $creditsResponse->json();
    
            $cast = isset($credits['cast']) ? $credits['cast'] : [];
            $mainActors = array_slice($cast, 0, 5);
    
            $crew = isset($credits['crew']) ? $credits['crew'] : [];
            $directors = [];
            foreach ($crew as $crewMember) {
                if ($crewMember['department'] === 'Directing') {
                    $directors[] = $crewMember;
                }
            }
        
            return view('movies.movie', [
                'movie' => $movie,
                'mainActors' => $mainActors,
                'directors' => $directors,
            ]);
        }
    }

    public function listMoviesCategory($id) {
        $perPage = 10; // Define o número de filmes por página
    
        $listMoviesCategory = $this->getMoviesByCategory($id, $perPage);
    
        return view('movies.category', ['movies' => $listMoviesCategory]);
    }
}