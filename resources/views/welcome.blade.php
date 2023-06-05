<?php 
echo '<pre>';
// print_r($randomMovie);
echo '</pre>';
?>

@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')
<div class="row">
    <div class="imagem-container" style="background-image: url('https://image.tmdb.org/t/p/original{{ $randomMovie['backdrop_path'] }}');">
        <div class="gradient-overlay"></div>
    </div>
    <div class="movie-infos">
        <div class=""></div>
        <div class="movie-title">
            <h1>{{ $randomMovie['title'] }}</h1>
        </div>
        <div class="data-movie">
            <p>{{ substr($randomMovie['release_date'], 0, 4) }}</p>
            <p class="vote-average">{{ number_format($randomMovie['vote_average'], 1) }}</p>
        </div>
        <div class="description-movie">
            <p>{{ $randomMovie['overview'] }}</p>
        </div>
        <ul class="categorias-movie">
            <span>Generos: </span>
            @foreach ($randomMovie['genres'] as $categoria)
                <li><a href="/movies/category/{{ $categoria['id'] }}">{{ $categoria['name'] }}</a></li>
            @endforeach
        </ul>
        <div class="buttons">
            <button class="btn" id="{{ $randomMovie['id'] }}"><span><i></i>Assistir</span></button>
            <a class="btn btn-border" href="movies/movie/{{ $randomMovie['id'] }}" ><span><i></i>Mais Informações</span></a>
        </div>
    </div>
</div>
@foreach ($categoryMovies as $key => $category)
<div class="movies">
    <div class="container">
        <div class="movies-list">
            <h2 class="title-movies">{{ $key }}</h2>
            <div class="swiper movies-swiper">
                <div class="swiper-wrapper">
                    @foreach ($category['movies'] as $movie)
                        <a class="swiper-slide" href="movies/movie/{{ $movie['id'] }}">
                            <div class="image-container">
                                <img src="https://image.tmdb.org/t/p/original{{ $movie['poster_path'] }}" width="300px" alt="">
                            </div>
                            <div class="movies-infos">
                                <div class="infos-top">
                                    <h4>{{ $movie['title'] }}</h4>
                                    <span>{{ substr($movie['release_date'], 0, 4) }}</span>
                                </div>
                                <div class="infos-bottom">
                                    <div class="vote-average">
                                        <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</div> 
@endforeach
@endsection
