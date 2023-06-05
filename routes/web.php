<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MovieController::class, 'getMovies']);
Route::get('/movies/movie/{id}', [MovieController::class, 'getMovie']);
Route::post('/movies/search', [MovieController::class, 'searchMovies'])->name('movies.search');
Route::post('/favorites/add/{id}', [FavoriteController::class, 'addToFavorite']);
Route::post('/favorites/remove/{id}', [FavoriteController::class, 'removeFromFavorite']);
Route::get('/movies/favorites', [FavoriteController::class, 'getFavoritesUser'])->name('favorites');
Route::get('/favorite/{id}', [FavoriteController::class, 'showFavorite']);
Route::get('/movies/category/{id}', [MovieController::class, 'listMoviesCategory']);
Route::post('/comment/add/{id}/{tituloComment}/{comment}/{recommend}', [CommentsController::class, 'addComment']);
Route::get('/comment/list/{id}', [CommentsController::class, 'getCommentsMovie']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
