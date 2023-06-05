<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static $categoryMovies = [
        'Populares' => [
            'category_id' => null,
        ],
        'Ação' => [
            'category_id' => 28,
        ],
        'Comédia' => [
            'category_id' => 35,
        ],
        'Terror' => [
            'category_id' => 27,
        ],
        'Romance' => [
            'category_id' => 10749,
        ],
        'Documentario' => [
            'category_id' => 99,
        ],
    ];
}