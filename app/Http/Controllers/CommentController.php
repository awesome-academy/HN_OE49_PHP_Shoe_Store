<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function comment(CommentRequest $request)
    {
        Comment::create($request->all());

        return redirect()->route('shop.detail', $request->product_id)->with('message', __('rating success'));
    }
}
