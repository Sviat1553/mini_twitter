<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
    {
        // Get all posts
        $posts = Post::orderBy('created_at', 'desc')->get();

        // Return the index view with the list of posts
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        // Return the post creation view
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);

        $userId = $request->cookie('user_id') ?? Str::random(32);

        // Знайти останній допис цього користувача
        $lastPost = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->first();

        if($lastPost && $lastPost->created_at->gt(Carbon::now()->subMinutes(10))) {
            return redirect()->route('posts.index')->with('error', 'You can only post once every 10 minutes.');
        }

        Cookie::queue('user_id', $userId, 60 * 24 * 365);  // Зберігаємо ідентифікатор користувача на рік

        $post = new Post([
            'content' => $request->input('content'),
            'user_id' => $userId,
        ]);

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function destroy(Request $request, Post $post)
    {
        // Здійснити перевірку: якщо ID користувача допису не співпадає з поточним user_id, повернути помилку
        if ($post->user_id !== $request->cookie('user_id')) {
            return redirect()->route('posts.index')->with('error', 'You can only delete your own posts.');
        }

        // Видалити допис
        $post->delete();

        // Перенаправити до списку дописів (метод index)
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}