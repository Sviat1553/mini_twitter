<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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
        Cookie::queue('user_id', $userId, 60 * 24 * 365);  // Зберігаємо ідентифікатор користувача на рік

        $post = new Post([
            'content' => $request->input('content'),
            'user_id' => $userId,
        ]);

        $post->save();

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        // Check if the post belongs to the current user
        if ($post->user_id == request()->cookie('user_id')) {
            // Delete the post
            $post->delete();

            // Redirect to the post list (index method) with success message
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }
        // Redirect to the post list (index method) with error message if the post doesn't belong to the current user
        return redirect()->route('posts.index')->with('error', 'You are not authorized to delete this post.');
    }
}