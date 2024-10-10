<!-- resources/views/errors/403.blade.php -->

@extends('layouts.auth')

@section('content')
 <!-- 404 Error Text -->
 <div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page Not Found</p>
    <p class="text-gray-500 mb-0">It looks like you don't have access to this page...</p>
    <p class="text-gray-500 mb-0">Get outta <a href="{{route('dashboard')}}">here!</a> </p>
    {{-- <a href="index.html">&larr; Back to Dashboard</a> --}}
</div>

@endsection