@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row align-items-center min-vh-75 py-5">
        <div class="col-lg-6 text-center text-lg-start">
            <h1 class="display-4 fw-bold mb-4">Your Yoga Journey Starts Here</h1>
            <p class="lead text-secondary mb-5">Unlimited Yoga Classes for 1 month. Start your journey strong with us.</p>
            <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                <a href="#schedule" class="btn btn-gold px-5 py-2">BOOK CLASS</a>
                <a href="#" class="btn btn-outline-light rounded-pill px-5 py-2">GET OFFER</a>
            </div>
        </div>
        <div class="col-lg-6 mt-5 mt-lg-0 text-center">
            <img src="https://via.placeholder.com/500x400/112240/FFFFFF?text=Yoga+Illustration" alt="Yoga Pose" class="img-fluid rounded">
        </div>
    </div>

    <div id="schedule" class="py-5 mt-5">
        <h2 class="text-center text-gold mb-5 fw-bold">Class Schedule</h2>
        
        <div class="row g-4">
            @foreach($schedules as $schedule)
                @php
                    // Hitung sisa slot
                    $sisaSlot = $schedule->quota - $schedule->bookings_count;
                @endphp
                
                <div class="col-md-6 col-lg-3">
                    <div class="bg-card p-4 h-100 d-flex flex-column">
                        <h4 class="text-white fw-bold mb-3">{{ $schedule->yogaClass->name }}</h4>
                        
                        <div class="mb-3 text-secondary">
                            <div class="mb-2">
                                🕒 {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                            </div>
                            <div class="mb-2">
                                👤 Trainers : {{ $schedule->trainer ? $schedule->trainer->name : 'TBA' }}
                            </div>
                            <div>
                                👥 Slots : <span class="{{ $sisaSlot > 0 ? 'text-success' : 'text-danger' }} fw-bold">{{ $sisaSlot }}</span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            @if($sisaSlot > 0)
                                <a href="{{ route('member.booking.store', $schedule->id) }}" class="btn btn-gold w-100" 
                                   onclick="event.preventDefault(); document.getElementById('book-form-{{ $schedule->id }}').submit();">
                                   Book Now
                                </a>
                                <form id="book-form-{{ $schedule->id }}" action="{{ route('member.booking.store', $schedule->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled>Fully Booked</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection