<!DOCTYPE html>
<html>

<head>
    <title>Posts</title>
</head>

<body>
    <h1>Daftar Posts</h1>
    @foreach($posts as $post)
        <p>{{ $post->title }}</p>
    @endforeach
</body>

</html>