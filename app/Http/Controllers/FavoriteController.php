<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller {
    
    public function addToFavorite($movieId) {
        $userId = auth()->user()->id;
    
        $favorite = new Favorite();
        $favorite->id_user = $userId;
        $favorite->id_filme = $movieId;
        $favorite->save();
    
        return response()->json(['message' => 'Adicionado com sucesso!']);
    }
    
    public function removeFromFavorite($movieId) {
        $userId = auth()->user()->id;
    
        Favorite::where('id_user', $userId)
            ->where('id_filme', $movieId)
            ->delete();
    
        return response()->json(['message' => 'Removido com sucesso!']);
    }

    public function showFavorite($id) {
        $userId = auth()->user()->id;

        $isFavorite = Favorite::where('id_user', $userId)
            ->where('id_filme', $id)
            ->exists();

        return response()->json(['isFavorite' => $isFavorite]);
    }

    public function getFavoritesUser() {
        $userId = auth()->user()->id;
    
        $favoriteMovies = Favorite::where('id_user', $userId)->get();
    
        $movies = [];
        foreach ($favoriteMovies as $favorite) {
            $movieResponse = Http::asJson()
                ->get(config('services.tmdb.endpoint').'movie/'.$favorite->id_filme, [
                    'api_key' => config('services.tmdb.api'),
                    'language' => 'pt-BR'
                ])
                ->json();
            
            $movies[] = $movieResponse;
        }
    
        return view('movies.favorites', ['movies' => $movies]);
    }

}
