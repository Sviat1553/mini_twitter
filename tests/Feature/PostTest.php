<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanViewPostsPage()
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
    }

    public function testUserCanCreatePost()
    {
        $userId = Str::random(32);
        $response = $this->withCookie('user_id', $userId)->post('/posts', [
            'content' => 'This is a test post'
        ]);

        $response->assertRedirect('/posts');

        $this->assertDatabaseHas('posts', [
            'content' => 'This is a test post',
            'user_id' => $userId
        ]);
    }

    public function testUserCanDeleteTheirPost()
    {
        // Створюємо допис для видалення
        $userId = Str::random(32);
        $post = Post::create([
            'content' => 'Test Post Content',
            'user_id' => $userId,
        ]);

        // Виконуємо запит на видалення з встановленим cookie
        $response = $this->withCookie('user_id', $userId)->delete("/posts/{$post->id}");

        // Переконуємося, що ми були перенаправлені назад на сторінку дописів
        $response->assertRedirect('/posts');

        // Переконуємося, що допис був видалений
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id
        ]);
    }
}