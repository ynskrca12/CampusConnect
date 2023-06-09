<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Exception;

class PostController extends Controller
{

    public function index(){

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Postlar başarıyla listelendi.',
            'data' =>Post::all()
        ]);
    }


    public function store(CreatePostRequest $request){

        
        try{
          $file = $request->file('file');
          $fileName = $file->getClientOriginalName();
          $file->move(public_path('uploads'), $fileName);
  
          $post = new Post();

          $post->email=$request->email;
          $post->postText=$request->postText;
          $post->postImages=$fileName;
          $post->authorName=$request->authorName;
          $post->save();
  
          return response()->json([
              'status_code' => 200,
              'status_message' => 'Post başarıyla kaydedildi.',
              'data' =>$post
          ]);
        }
        catch (Exception $e){
          return response()->json($e);
        }
  
      } //End Method


      public function update(EditPostRequest $request, Post $post){

        try{        
         
            $post->email=$request->email;
            $post->postText=$request->postText;
            $post->authorName=$request->authorName;
            $post->save();
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Post başarıyla güncellendi.',
                'data' =>$post
            ]);
        }
        catch (Exception $e) {
            return response()->json($e);
        }
    
        }//End Method
        
        public function delete(Post $post){
            try {
                if($post){
                    $post->delete();
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Post başarıyla silindi.',
                    'data' =>$post
                ]);
                }else{
    
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Post bulunamadı.',
                ]);
                }
    
            } catch (Exception $e) {
                return response()->json($e);
            }
        }//End Method    
}
