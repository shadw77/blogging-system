<?php

// app/Filament/Pages/BlogAnalytics.php

namespace App\Filament\Pages;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use Filament\Pages\Page;

class BlogAnalytics extends Page
{
    protected static ?string $title = 'Blog Analytics';
    protected static ?string $navigationLabel = 'Blog Analytics';
    protected static ?string $navigationIcon = 'heroicon-s-chart-bar';
    protected static ?int $navigationSort = 1;

    public $totalPosts;
    public $totalComments;
    public $totalTags;
    public $publishedPosts;

    public function mount()
    {
        $this->totalPosts = Post::count();
        $this->totalComments = Comment::count();
        $this->totalTags = Tag::count();
        $this->publishedPosts = Post::where('status', 'published')->count();
    }

    public function getView(): string
    {
        return 'filament.pages.blog-analytics';
    }

    public function viewData(): array
    {
        return [
            'totalPosts' => $this->totalPosts,
            'totalComments' => $this->totalComments,
            'totalTags' => $this->totalTags,
            'publishedPosts' => $this->publishedPosts,
        ];
    }
}
