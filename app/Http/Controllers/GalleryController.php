<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $$filter = $request->query('filter');
        $query = Gallery::with('user', 'images');
        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")
                ->orWhere('description', 'like', "%$filter%")
                ->orWhereHas('user', function ($q) use ($filter) {
                    $q->where('firstname', 'like', "%$filter%")
                        ->orWhere('lastname', 'like', "%$filter%");
                });
        }
        $galleries = $query->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($galleries);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        $gallery = Auth::user()->galleries()->create($request->validated());
        foreach ($request->images as $images) {
            $image_url = $images['image_url'];
            $gallery->images()->create(compact('image_url'));
        }
        $gallery->images;
        return response()->json($gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('user', 'images', 'comments', 'comments.user');
        return response()->json($gallery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->validated());
        if ($request->images) {
            $gallery->images()->delete();
            foreach ($request->images as $images) {
                $image_url = $images['image_url'];
                $gallery->images()->create(compact('image_url'));
            }
            info($gallery->images()->get());
        }
        $gallery = $gallery->load('user', 'images');
        return response()->json($gallery);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        $gallery->images()->delete();
        return response(null, 204);
    }

    public function myGalleries(Request $request)
    {
        $filter = $request->query('filter');
        $query = Auth::user()->galleries()->with('user', 'images');

        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")->orWhere('description', 'like', "%$filter%")->orWhere("description", 'like', "%$filter%");
        }
        $galleries = $query->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($galleries);
    }
}
