@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-5">

            <!-- Card Box -->
            <div class="card shadow-lg border-0">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4" style="font-family: 'Comic Sans MS', cursive;">🐄 Livestock Tagging and Profiling Management System</h2>
                    <h5 class="text-center mb-4">Login</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('password.forgot') }}">Forgot Password?</a>
                        </div>

                        <button class="btn btn-primary btn-block">
                            Login
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection