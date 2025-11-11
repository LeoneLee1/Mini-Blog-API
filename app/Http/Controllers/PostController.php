<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostsRequest;

class PostController extends Controller
{
    public function posts(){
        try {
            $posts = Post::with('user:id,name')->orderByDesc('id')->paginate(10);
    
            return response()->json([
                'success' => true,
                'posts' => $posts,
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed load posts data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create(CreatePostsRequest $request){
        try {
            $validateData = $request->validated();
    
            $posts = Post::create($validateData);
    
            return response()->json([
                'success' => true,
                'message' => 'Successfully created posts.',
                'posts' => $posts,
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed create posts',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function read($id){
        try {
            $posts = Post::with('user:id,name')->findOrFail($id);

            return response()->json([
                'success' => true,
                'posts' => $posts,
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed load posts id ' . $id,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(CreatePostsRequest $request, $id){
        try {
            $validateData = $request->validated();
    
            $posts = Post::findOrFail($id);
    
            $posts->update($validateData);
    
            return response()->json([
                'success' => true,
                'message' => 'Successfully update posts id ' . $id,
                'posts' => $posts,
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed update data posts id ' . $id,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id){
        try {
            Post::findOrFail($id)->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Successfully delete posts id ' . $id,
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed delete data posts id ' . $id,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
