<?php 
    echo '<pre>';
    // print_r($isFavorite);
    echo '</pre>';
?>

@extends('layouts.main')

@section('content')
<div class="featured">
    <div class="row">
        <div class="imagem-container" style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] }}');">
            <div class="gradient-overlay"></div>
        </div>
        <div class="movie-infos">
            <div class=""></div>
            <div class="movie-title">
                <h1>{{ $movie['title'] }}</h1>
            </div>
            <div class="data-movie">
                <p>{{ substr($movie['release_date'], 0, 4) }}</p>
                <p class="vote-average">{{ number_format($movie['vote_average'], 1) }}</p>
            </div>
            <div class="description-movie">
                <p>{{ $movie['overview'] }}</p>
            </div>
            <ul class="categorias-movie">
                <span>Generos: </span>
                @foreach ($movie['genres'] as $categoria)
                    <li><a href="/movies/category/{{ $categoria['id'] }}">{{ $categoria['name'] }}</a></li>
                @endforeach
            </ul>
            <div class="buttons">
                <button class="btn" id="{{ $movie['id'] }}"><span><i></i>Assistir</span></button>
                <button class="btn btn-border"><span><i></i>Mais Informações</span></button>
            </div>
        </div>
    </div>
    <div class="more-infos">
        <div class="container">
            <div class="trailer-movie">
                <h2 class="title-movies">Resumo</h2>
                <div class="poster-trailer">
                    <div class="movie-poster trailer-poster" id="{{ $movie['id'] }}">
                        <div class="imagem-container">
                            <img src="https://image.tmdb.org/t/p/original{{ $movie['poster_path'] }}" alt="" class="poster">
                            <div class="vote-average">
                                <h2>{{ number_format($movie['vote_average'], 1) }}</h2>
                                <span>{{ $movie['vote_count'] }}  votos </span>
                            </div>
                        </div>
                        <div class="play-trailer"><i class="fa-solid fa-circle-play"></i></div>
                    </div>
                    <div class="infos-movie">
                        <div class="title-movie">
                            <h1>{{ $movie['title'] }} <span class="date-movie">{{ substr($movie['release_date'], 0, 4) }}</span></h1>
                            <div class="overall-average">
                                <h2>{{ number_format($movie['vote_average'], 1) }}</h2>
                                <span>{{ $movie['vote_count'] }}  votos </span>
                            </div>
                        </div>
                        <div class="movie-directors">
                            <p>Dirigido por: @foreach($directors as $director) <span class="directors">{{ $director['name'] }}</span> @endforeach</p>
                        </div>
                        <div class="sinopse">
                            <h2 class="title2">Sinopse</h2>
                            <p class="sinopse">{{ $movie['overview'] }}</p>
                        </div>
                        <div class="movie-row">
                            <div class="movies-actions">
                                <div id="favorite-buttons">
                                    <button class="buttons-action" type="submit" id="button-favorite" title="Favorito">
                                        <i class="fa-regular fa-heart" id="iconFavorito"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="movie-categories">
                                @foreach ($movie['genres'] as $categoria)
                                    <li><a href="/movies/category/{{ $categoria['id'] }}">{{ $categoria['name'] }}</a></li>
                                @endforeach
                            </div>
                        </div>
                        <div class="main-actors">
                            <h2 class="title2">Principais Atores</h2>
                            <ul class="list-actors">
                                @foreach($mainActors as $actor)
                                <li>
                                    <a href="">
                                        <div class="name-actor">
                                            <h2>{{ $actor['original_name'] }}</h2>
                                        </div>
                                        <div class="character-actor">
                                            <h3>{{ $actor['character'] }}</h3>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="movie-time">
                            <p>{{ $movie['runtime'] }} minutos</p>
                        </div>
                    </div>
                </div>
                {{-- <iframe src="" frameborder="0" class="movieFrame"></iframe> --}}
            </div>
        </div>
    </div>
    <div class="comments">
        <div class="container">
            <div class="assessments">
                <div class="header-comments">
                    <h2 class="title-movies">Avaliações de usuários</h2>
                    @auth
                    <div class="add-comment"><i class="fa-solid fa-plus"></i>Adicionar Avaliação</div>
                    @endauth
                    @guest
                        <a class="" href="/login"><i class="fa-solid fa-plus"></i>Adicionar Avaliação</a>
                    @endguest
                </div>
                {{-- <div class="comment-user">
                    <div class="avatar">
                        <p class="avatar-user">{{ substr(auth()->user()->name, 0, 1) }}</p>
                    </div>
                    <div class="comment-text">
                        <input type="text" placeholder="Adicione uma avaliação...">
                    </div>
                </div> --}}
                <div class="comments-list">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
