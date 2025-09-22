<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Http\Resources\ReplyResource;
use Illuminate\Http\Request;

class ApiReplyController extends Controller
{
    /**
     * Restituisce tutte le replies di un commento.
     */
    public function getByComment($commentId)
    {
        // recupero replies legate al commento
        $replies = Reply::where('comment_id', $commentId)
                        ->orderBy('created_at', 'asc')
                        ->get();

        // ritorno come resource
        return ReplyResource::collection($replies);
    }

    /**
     * Store già lo hai fatto, quindi qui lasciamo solo il GET
     */
}