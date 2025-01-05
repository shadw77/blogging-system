<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'tags', 'comments'])
            ->paginate(10);
        return response()->json($posts);
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'tags', 'comments'])
            ->where('slug', $slug)
            ->firstOrFail();
        return response()->json($post);
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }
    
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'array|exists:tags,id',
                'slug' => 'required|string|unique:posts,slug',
                'author_id' => 'required|exists:users,id',
            ]);
    
            $post = Post::create($validated);
    
            $post->tags()->sync($validated['tags']);
    
            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post,
            ], 201);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
    
        }  catch (QueryException $e) {
            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);
    
        } 
    }
    
    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }
        try {
            $post = Post::findOrFail($id);
    
            $validated = $request->validate([
                'title' => 'string|max:255',
                'slug' => 'string|max:255|unique:posts,slug,' . $id,
                'content' => 'string',
                'published_at' => 'date|nullable',
                'status' => 'in:draft,published,archived',
                'author_id' => 'exists:users,id',
                'tags' => 'array|exists:tags,id',
            ]);
    
            $post->update($validated);
    
            if (isset($validated['tags'])) {
                $post->tags()->sync($validated['tags']);
            }
    
            return response()->json([
                'message' => 'Post updated successfully',
                'post' => $post->load('tags'),
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $post = Post::with('comments')->findOrFail($id);
        $post->comments()->delete();
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
