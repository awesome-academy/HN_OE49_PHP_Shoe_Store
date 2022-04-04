<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\UpdateRequest;
use App\Http\Requests\Comments\StoreRequest;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function comment(StoreRequest $request)
    {
        $this->commentRepo->create($request->all());

        return redirect()->route('shop.detail', $request->product_id)->with('message', __('rating success'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->commentRepo->update($id, $request->only('content'));

        return redirect()->route('shop.detail', $request->product_id);
    }

    public function destroy($id)
    {
        $this->commentRepo->delete($id);

        return redirect()->route('shop.detail', request()->product_id);
    }
}
