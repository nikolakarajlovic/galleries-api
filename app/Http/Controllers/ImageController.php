<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateImageRequest;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return response()->json($images);
    }

    public function store(CreateImageRequest $request)
    {
        $data = $request->validated();

        $image = Image::create($data);

        return response()->json($image);
    }

    public function destroy(Image $image)
    {
        $image->delete();
        return response(null, 204);
    }
}
