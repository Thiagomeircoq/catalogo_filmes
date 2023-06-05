<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favoritos_user';

    protected $fillable = [
        'id_user',
        'id_filme',
    ];
}