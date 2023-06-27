@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Post</h1>
        <form method="POST" action="{{ route('posts.store') }}" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="content">Post Content:</label>
                <input type="text" id="content" name="content" required maxlength="255" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection