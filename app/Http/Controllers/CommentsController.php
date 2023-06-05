<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Comments;

class CommentsController extends Controller {
    public function addComment(Request $request, $movieId, $tituloComment, $comment, $recommend)
    {
        $userId = auth()->user()->id;
    
        $existingComment = Comments::where('id_user', $userId)
                                  ->where('id_filme', $movieId)
                                  ->first();
    
        if ($existingComment) {
            return response()->json(['message' => 'O usuário já possui um comentário para esse filme.']);
        }
    
        $newComment = new Comments();
        $newComment->id_user = $userId;
        $newComment->id_filme = $movieId;
        $newComment->comentario = $comment;
        $newComment->titulo = $tituloComment;
        $newComment->recomendado = $recommend;
        $newComment->save();
    
        return response()->json(['message' => 'Comentário adicionado com sucesso!']);
    }

    public function getCommentsMovie($idMovie)
    {
        $userId = auth()->check() ? auth()->user()->id : null;

        $userComment = null;
        $otherComments = Comments::with('user')
            ->where('id_filme', $idMovie)
            ->where('id_user', '!=', $userId)
            ->get();

        if ($userId) {
            $userComment = Comments::with('user')
                ->where('id_filme', $idMovie)
                ->where('id_user', $userId)
                ->first();
        }

        $commentsList = collect();

        if ($userComment) {
            $commentsList->push($userComment);
        }

        $commentsList = $commentsList->concat($otherComments);

        return $commentsList;
    }
        
}