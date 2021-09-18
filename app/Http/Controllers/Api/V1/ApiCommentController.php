<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Comment;
use Illuminate\Http\Request;

class ApiCommentController extends Controller
{
    //
    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->client_id = $request->input('client_id');
        $comment->guid_id = $request->input('guid_id');
        $comment->save();
        return $comment;
    }
}
