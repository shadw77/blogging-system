<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = Post::first();

        Comment::create([
            'post_id' => $post->id,
            'user_name' => 'John Doe',
            'user_email' => 'john.doe@example.com',
            'content' => 'Great post!',
            'approved' => true,
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_name' => 'Jane Doe',
            'user_email' => 'jane.doe@example.com',
            'content' => 'Nice article!',
            'approved' => false,
        ]);
    }
}
