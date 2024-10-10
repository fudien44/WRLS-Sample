@extends('layouts.login')

@section('content')
<div class="form-content">

    <div class="icon-container">
        <img class="doh-icon" src="/images/chd12.png" alt="Image is not available" />
        <h1 class="title">Welcome to the Water Refilling Licensing System</h1>
        <img class="doh-icon" src="/images/dohlogo.png" alt="Image is not available" />
    </div>
<br>
    {{-- <h1 class="title">Welcome to the Water Refilling Licensing System</h1> --}}
    <div class="card">
        <form action="/login" method="POST" id="login-form">
            @csrf
            <div class="card-body">
                <h5 class="card-title">Please sign-in to your account</h5>

                <label class="form-label">Username: </label><br /><input class="form-control" type="text"
                    name="inputusername" placeholder="Enter your username">

                <br />

                <label class="form-label">Password: </label><br /><input class="form-control" type="password"
                    aria-describedby="passwordHelpBlock" name="inputpassword" placeholder="Enter your password">



                <div class="container space-between">
                    <div>
                        <input type="checkbox"> <label>Remember me</label>
                    </div>
                    <a class="forgot-password" href="#">Forgot password?</a>
                </div>

                <br />
                <p>Don't have an account? <a href="/register">Register here!</a></p>
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
