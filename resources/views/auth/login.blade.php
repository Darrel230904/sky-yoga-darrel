@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    
    <div class="row w-100 shadow-lg" style="max-width: 900px; border-radius: 20px; overflow: hidden;">
        
        <div class="col-md-6 bg-white text-dark p-5 d-flex flex-column justify-content-center">
            <h2 class="text-center fw-bold mb-4">Welcome Back</h2>
            
            @if($errors->any())
                <div class="alert alert-danger p-2 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="login" class="form-control form-control-lg bg-light" placeholder="Email or WhatsApp" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill mb-3 fw-bold">Log In</button>
                
                <div class="text-center mb-3 fw-bold text-secondary">OR</div>
                
                <button type="button" class="btn btn-outline-success w-100 py-2 rounded-pill fw-bold">
                    Log in with WhatsApp
                </button>
            </form>
        </div>

        <div class="col-md-6 bg-card text-center p-5 d-flex flex-column justify-content-center align-items-center border-start-0">
            <h1 class="fw-bold mb-3">Don't Have <br> An ACCOUNT</h1>
            <p class="text-secondary mb-4">Create an Account</p>
            <a href="{{ route('register') }}" class="btn btn-outline-light rounded-pill px-5 py-2 fw-bold">Sign Up</a>
        </div>

    </div>

</div>
@endsection