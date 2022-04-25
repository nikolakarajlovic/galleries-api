<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userGalleries($user_id, Request $request)
    {
        $filter = $request->query('filter');
        $user = User::findOrFail($user_id);
        $query = $user->galleries()->with('images', 'user');
        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")->orWhere('description', 'like', "%$filter%")->orWhere("description", 'like', "%$filter%");
        }
        $galleries = $query->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($galleries);
    }
}
