<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::first();
        $category = Category::first();
        $tags = Tag::all();

        Post::create([
            'title' => 'First Post',
            'slug' => 'first-post',
            'content' => 'This is the content of the first post.',
            'author_id' => $author->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
        ])->tags()->attach($tags->pluck('id'));
    }
}
