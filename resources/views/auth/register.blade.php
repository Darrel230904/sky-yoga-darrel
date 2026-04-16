@extends('layouts.auth')

@section('content')
<div class="w-full min-h-screen flex justify-center items-center bg-cover bg-center bg-no-repeat p-4" 
     style="background-image: url('{{ asset('images/bg-login-wave.png') }}');">
    
    <div class="flex flex-col md:flex-row w-full max-w-[850px] rounded-[15px] overflow-hidden shadow-2xl">
        
        <div class="w-full md:w-[55%] bg-white px-12 py-12 flex flex-col justify-center">
            <h2 class="text-[28px] font-bold text-center text-[#0A1628] mb-6">Create account</h2>
            
            @if($errors->any())
                <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-xs">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" class="w-full bg-white border border-gray-400 placeholder-gray-400 text-black rounded px-4 py-2.5 focus:outline-none focus:border-[#0A1628] transition-all" required>
                
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="w-full bg-white border border-gray-400 placeholder-gray-400 text-black rounded px-4 py-2.5 focus:outline-none focus:border-[#0A1628] transition-all" required>
                
                <input type="text" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}" class="w-full bg-white border border-gray-400 placeholder-gray-400 text-black rounded px-4 py-2.5 focus:outline-none focus:border-[#0A1628] transition-all" required>
                
                <input type="password" name="password" placeholder="Password" class="w-full bg-white border border-gray-400 placeholder-gray-400 text-black rounded px-4 py-2.5 focus:outline-none focus:border-[#0A1628] transition-all" required>
                
                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full bg-white border border-gray-400 placeholder-gray-400 text-black rounded px-4 py-2.5 focus:outline-none focus:border-[#0A1628] transition-all" required>
                
                <div class="flex justify-center pt-3">
                    <button type="submit" class="w-[200px] bg-[#0A1628] text-white text-[15px] font-medium py-2.5 rounded-full hover:bg-gray-800 transition-colors">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full md:w-[45%] bg-[#0A1628]/50 p-10 flex flex-col justify-center items-center text-center">
            <h2 class="text-4xl font-bold text-white mb-6 leading-tight">Get Started</h2>
            <p class="text-gray-300 mb-8 text-sm">Already have an account?</p>
            <a href="{{ route('login') }}" class="border border-white text-white font-normal py-2 px-10 rounded-full hover:bg-white hover:text-[#0A1628] transition-all text-sm">
                Log in
            </a>
        </div>

    </div>
</div>
@endsection