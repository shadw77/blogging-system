<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        try {
            $post = Post::findOrFail($postId);
    
            $validated = $request->validate([
                'content' => 'required|string|max:500',
                'user_name' => 'required|string|max:100',
                'user_email' => 'required|email|max:255',
            ]);
    
            $comment = $post->comments()->create([
                'content' => $validated['content'],
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
                'approved' => false,
            ]);
    
            return response()->json([
                'message' => 'Comment created successfully',
                'comment' => $comment,
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Database error occurred',
                'error' => $e->getMessage(),
            ], 500);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
