<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}">
</head>
<body>
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <label for="content">Post Content:</label>
        <input type="text" id="content" name="content" required maxlength="255">
        <button type="submit">Submit</button>
    </form>
</body>
</html>