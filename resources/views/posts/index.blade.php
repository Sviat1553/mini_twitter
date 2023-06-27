<!DOCTYPE html>
<html>
<head>
    <title>Mini Twitter</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}">
</head>
<body>
<h1>Posts</h1>

@if (session('error'))
    <div class="notification">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="notification">{{ session('success') }}</div>
@endif

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