@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    
    <div class="row w-100 shadow-lg" style="max-width: 900px; border-radius: 20px; overflow: hidden;">
        
        <div class="col-md-6 bg-white text-dark p-5 d-flex flex-column justify-content-center">
            <h2 class="text-center fw-bold mb-4">Create account</h2>
            
            @if($errors->any())
                <div class="alert alert-danger p-2 mb-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control bg-light" placeholder="Name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control bg-light" placeholder="Email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="phone_number" class="form-control bg-light" placeholder="Phone Number" value="{{ old('phone_number') }}" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control bg-light" placeholder="Password" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password_confirmation" class="form-control bg-light" placeholder="Confirm Password" required>
                </div>
                
                <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-bold">sign up</button>
            </form>
        </div>

        <div class="col-md-6 bg-card text-center p-5 d-flex flex-column justify-content-center align-items-center border-start-0" style="background-color: var(--bg-navy);">
            <h1 class="fw-bold mb-3 text-white">Get Started</h1>
            <p class="text-secondary mb-4">Already have an account?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-5 py-2 fw-bold">Log in</a>
        </div>

    </div>

</div>
@endsection