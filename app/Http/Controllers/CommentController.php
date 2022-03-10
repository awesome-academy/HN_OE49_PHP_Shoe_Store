<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\UpdateRequest;
use App\Http\Requests\Comments\StoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(StoreRequest $request)
    {
        Comment::create($request->all());

        return redirect()->route('shop.detail', $request->product_id)->with('message', __('rating success'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $comment = Comment::find($id);
        $comment->update($request->only('content'));

        return redirect()->route('shop.detail', $request->product_id);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect()->route('shop.detail', request()->product_id);
    }
}
