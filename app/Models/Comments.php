<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $table = 'comentarios_user';

    protected $fillable = [
        'id_user',
        'id_filme',
        'comentario',
        'titulo',
        'recomendado',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function filme()
    {
        return $this->belongsTo(Filme::class, 'id_filme');
    }
}
