<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Gallery $gallery, StoreCommentRequest $request)
    {
        $data = $request->validated();
        $user_id = Auth::id();
        $gallery_id = $gallery['id'];
        $data = array_merge($data, compact('user_id', 'gallery_id'));
        $comment = Comment::create($data);
        $comment->load('user');

        return response()->json($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $galleryComments = Comment::with('user')->where('gallery_id', $gallery->id)->get();
        return response()->json($galleryComments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request)
    {
        $data = $request->validated();
        $commentToUpdate = Comment::findOrFail($data['id']);

        $commentToUpdate->body = $data['body'];
        $commentToUpdate->save();

        return response()->json($commentToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response(null, 204);
    }
}
