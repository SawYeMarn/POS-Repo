<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>This is user Home Page</h1>

<form action="{{route('logout')}}" method="post">
    @csrf
    <input type="submit" value="Logout" class="btn btn-danger">
</form>
</body>
</html>
