<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['categories', 'tags', 'comments'])
            ->paginate(10);
        return response()->json($posts);
    }

    public function show($slug)
    {
        $post = Post::with(['categories', 'tags', 'comments'])
            ->where('slug', $slug)
            ->firstOrFail();
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array|exists:tags,id',
        ]);

        $post = Post::create($validated);
        $post->tags()->sync($validated['tags']);
        return response()->json($post, 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'category_id' => 'exists:categories,id',
            'tags' => 'array|exists:tags,id',
        ]);

        $post->update($validated);
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        $post->comments()->delete();
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
