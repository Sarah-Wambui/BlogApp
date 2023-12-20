<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{   
   // Retrieve all the posts and their corresponding users
   public function index()
   {
    $posts = Post::with('user')->get();
    return response()->json(['posts'=>$posts]);
   }
   
   // Retrieve post by id
   public function show($id)
   {
    $post = Post::find($id);
    if($post){
        return response()->json(['post'=>$post]);
    }
    return response()->json(['message'=>'Record not found!!']);  
   }  
   
   
   //Retrieve all the posts for a specific user
   public function showPost($user_id)
   {
    // Retrieve posts for a specific user
    $posts = Post::with('user')->where('user_id', $user_id)->get();
    
     // Check if the user has any posts
    if($posts->isEmpty()){
        return response()->json(['message'=> 'No posts found for this user'], 404);
    }else{

        // return response()->json(['posts'=> $posts]);

        $formattedPosts = $posts->map(function ($post){
            return [
                'post_title' => $post->title,
                'post_content' => $post->content,
                'created_at'=> $post->created_at
            ];
        });
        return response()->json(['posts'=> $formattedPosts]);
    }
   }

   public function store(Request $request)
   {
      // Create a new post and associate it with the authenticated user
     $post = Post::create([
        'title'=>$request->input('title'),
        'content'=>$request->input('content'),
        'user_id'=>auth()->id(),
     ]);
     return response()->json(['post'=>$post]);
   }

  //Update a post
  public function update(Request $request, $id)
  {
    $post = Post::find($id);
    if($post){
        $post->update($request->all());
        return response()->json(['message' => 'Post updated successfully']);
    }else{
        return response()->json(['message'=> 'Post not found']);
    }
  }     
   
   //Delete a record    
   public function destroy($id)
   {
    $post = Post::find($id);
    if($post){
        $post->delete();
        return response()->json(['message'=>'Record deleted successfully!!']); 
    }else{
        return response()->json(['message'=>'Record not found!!']); 
    }
   }
}
