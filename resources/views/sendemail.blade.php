<!-- resources/views/sendemail.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>
    <h1>Send Email</h1>
    
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('send.email') }}" method="POST">
        @csrf
        <button type="submit">Send Email</button>
    </form>
</body>
</html>
