<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title> <!-- This is the email title -->
</head>
<body>
    <h1>{{ $details['title'] }}</h1> <!-- Main title inside the email -->
    <p>{!! nl2br(e($details['body'])) !!}</p> <!-- Main content of the email -->
</body>
</html>