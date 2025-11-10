<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function posts(){
        $posts = Post::orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ], 200);
    }
}
