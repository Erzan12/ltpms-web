@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <h2 class="text-center mb-4" style="font-family: 'Comic Sans MS', cursive;">Livestock Tagging and Profiling Management System</h2>
                        <h5 class="text-center mb-4">Login</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error:</strong> {{ $errors->first() }}
                            </div>
                        @endif
                        <form action="/login" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('password.forgot') }}">Forgot Password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection