<!DOCTYPE html>
<html>
<head>
    <title>Mini Twitter</title>
</head>
<body>
<h1>Posts</h1>
@foreach ($posts as $post)
    <div>
        <p>{{ $post->content }}</p>
        @if($post->user_id == Cookie::get('user_id'))
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @endif
    </div>
@endforeach
<a href="{{ route('posts.create') }}">Create a new post</a>
</body>
</html>