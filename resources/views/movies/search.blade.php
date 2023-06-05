<?php
echo '<pre>';
    //print_r($movies);
echo '</pre>';
?>

@extends('layouts.main')

@section('content')

<div class="more-movies">
    <div class="container">
        <ul class="movies-list">
            @foreach($movies as $movie)
            <li class="movie">
                <a href="/movies/movie/{{ $movie['id'] }}">
                    <div class="img-container">
                        <div class="vote-average">
                            <span>{{ number_format($movie['vote_average'], 1) }}</span>
                        </div>
                        <img src='https://image.tmdb.org/t/p/original{{ $movie['poster_path'] }}' alt="">
                    </div>
                    <div class="movies-infos">
                        <div class="infos-top">
                            <h4>{{ $movie['title'] }}</h4>
                            <span>{{ substr($movie['release_date'], 0, 4) }}</span>
                        </div>
                        <div class="infos-bottom">
                         
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

@endsection
