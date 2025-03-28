<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // Create a new post 
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required|string'
        ]);

        $post = Post::create([
            'user_id'=>Auth::id(),
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        return response()->json([
            'status'=> true,
            'message'=>'Data Created',
            'data'=> $post
        ]);
    }
    
    // Get all post
    public function index()
    {
        return response()->json([
            'status'=> true,
            'data'=> Post::all()
        ]);
    }

    // Get a single post
    public function show($id)
    {
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'status'=> false,
                'message'=> 'Data not found'
            ], 404);
        }

        return response()->json([
            'status'=>true,
            'data'=> $post
        ], 200);
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return response()->json([
                'status'=>false,
                'message'=>'data not found'
            ]);
        }

        if($post->user_id !== Auth::id())
        {
            return reponse()->json([
                'status'=>false,
                'message'=> 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'title'=>'string|max:255',
            'content'=>'string'
        ]);

        $post->update($request->only(['title', 'content']));

        return response()->json([
            'status'=> true,
            'message'=>'data updated',
            'data'=> $post
        ]);
    }

    // Delete a post
    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post)
          {
            return response()->json([
                'status'=>false,
                'message'=>'Data not found'
            ], 404);
          }

          if($post->user_id !== Auth::id())
          {
            return response()->json([
                'status'=>false,
                'message'=>'Unauthorized'
            ], 403);
          }

          $post->delete();

          return response()->json([
            'status'=>true,
            'message'=> 'data deleted'
          ], 200);
    }
}
