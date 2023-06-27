@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
        </div>

        @foreach ($posts as $post)
            <div class="card mb-4">
                <div class="card-body">
                    <p class="card-text">{{ $post->content }}</p>
                    @if($post->user_id == Cookie::get('user_id'))
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection