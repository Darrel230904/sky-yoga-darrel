@extends('layouts.app')

@section('content')

<section class="max-w-[1400px] mx-auto px-8 py-12 md:py-20 flex flex-col lg:flex-row items-center justify-between">
    <div class="lg:w-1/2 z-10 text-center lg:text-left">
        <h1 class="text-4xl md:text-5xl lg:text-[56px] font-bold leading-[1.2] mb-6 text-white">
            Your Yoga Journey Starts Here
        </h1>
        <p class="text-white text-lg mb-10 max-w-[450px] mx-auto lg:mx-0 leading-relaxed">
            Unlimited Yoga Classes For 1 Month.<br>
            Start Your Journey Strong With Us
        </p>
        <div class="flex flex-wrap justify-center lg:justify-start gap-5">
            <a href="#classes" class="bg-[#FACC15] text-[#0A1628] font-bold py-3 px-8 rounded-md hover:bg-yellow-500 transition-colors">
                BOOK CLASS
            </a>
            <a href="#pricing" class="border-2 border-[#FACC15] text-[#FACC15] font-bold py-3 px-8 rounded-md hover:bg-[#FACC15] hover:text-[#0A1628] transition-colors">
                GET OFFER
            </a>
        </div>
    </div>
    
    <div class="lg:w-1/2 flex justify-center lg:justify-end mt-12 lg:mt-0">
        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800" 
             alt="Yoga Pose" 
             class="w-full max-w-[450px] h-[350px] object-cover rounded-[30px] shadow-2xl">
    </div>
</section>

<section id="classes" class="w-full bg-[#5E6D82] py-20 mt-10">
    <div class="max-w-[1400px] mx-auto px-8">
        <h2 class="text-center text-[#FACC15] text-3xl md:text-4xl font-bold mb-12">Class Schedule</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($schedules as $schedule)
                @php $sisaSlot = $schedule->quota - $schedule->bookings_count; @endphp
                
                <div class="bg-[#0A1628] rounded-[20px] p-8 flex flex-col h-full shadow-xl">
                    <h3 class="text-2xl font-bold text-[#FACC15] mb-6">{{ $schedule->yogaClass->name }}</h3>
                    <div class="space-y-4 text-white mb-8 flex-grow">
                        <p class="flex items-center gap-3">
                            <span class="text-gray-400 border border-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-xs">🕒</span> 
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i A') }}
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="text-gray-400">🧘</span> 
                            Trainers : {{ $schedule->trainer ? $schedule->trainer->name : 'TBA' }}
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="text-gray-400">🪷</span> 
                            Slots : {{ $sisaSlot }}
                        </p>
                    </div>
                    @if($sisaSlot > 0)
                        <form action="{{ route('member.booking.store', $schedule->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-[#FACC15] text-[#0A1628] font-bold py-3 rounded-md hover:bg-yellow-500 transition-colors">Book Now</button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-600 text-gray-300 font-bold py-3 rounded-md cursor-not-allowed">Fully Booked</button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="max-w-[1400px] mx-auto px-8 pt-24 pb-12">
    <div class="bg-[#5E6D82] border-4 border-[#FACC15] rounded-[40px] px-8 py-16 text-center max-w-[1000px] mx-auto shadow-2xl">
        <h2 class="text-[#FACC15] text-3xl md:text-4xl font-bold mb-8">About Sky Yoga</h2>
        <p class="text-white text-lg leading-relaxed px-4 md:px-12">
            Sky Yoga is a premium yoga studio designed to help you reconnect with your body and mind. We provide a calm and modern environment supported by professional instructors to guide your wellness journey.
        </p>
    </div>
</section>

<section class="max-w-[1400px] mx-auto px-8 py-12">
    <h2 class="text-center text-[#FACC15] text-3xl md:text-4xl font-bold mb-16">Meet Our Trainers</h2>
    <div class="flex flex-wrap justify-center gap-8 lg:gap-16">
        @foreach($trainers as $trainer)
            <div class="text-center">
                <div class="w-40 h-40 md:w-48 md:h-48 rounded-[30px] border-4 border-[#FACC15] overflow-hidden mb-6 mx-auto bg-[#0A1628]">
                    <img src="{{ $trainer->photo_url ?? 'https://via.placeholder.com/200' }}" alt="{{ $trainer->name }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-[#FACC15] font-bold text-2xl mb-1">{{ $trainer->name }}</h3>
                <p class="text-white">{{ $trainer->bio }}</p>
            </div>
        @endforeach
    </div>
</section>

<section id="pricing" class="max-w-[1400px] mx-auto px-8 py-16">
    <h2 class="text-center text-[#FACC15] text-3xl md:text-4xl font-bold mb-12">Membership & Packages</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-[1000px] mx-auto">
        <div class="bg-[#0A1628] border border-[#FACC15] rounded-[30px] p-10 shadow-lg">
            <h3 class="text-[#FACC15] font-bold text-2xl text-center mb-8">Membership</h3>
            <div class="space-y-6 text-lg">
                <div class="flex justify-between border-b border-gray-600 pb-4">
                    <span class="text-gray-300">3 Months + FREE 1 Month</span><span class="text-white font-medium">IDR 4.000.000</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">6 Months + FREE 2 Month</span><span class="text-white font-medium">IDR 5.000.000</span>
                </div>
            </div>
        </div>
        <div class="bg-[#0A1628] border border-[#FACC15] rounded-[30px] p-10 shadow-lg">
            <h3 class="text-[#FACC15] font-bold text-2xl text-center mb-8">Shession Packages:</h3>
            <div class="space-y-6 text-lg">
                <div class="flex justify-between border-b border-gray-600 pb-4">
                    <span class="text-gray-300">Buy 10 Session GET 2 FREE</span><span class="text-white font-medium">IDR 1.500.000</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Buy 20 Session GET 5 FREE</span><span class="text-white font-medium">IDR 2.700.000</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-[1400px] mx-auto px-8 py-16 text-center">
    <h2 class="text-[#FACC15] text-3xl font-bold mb-2">Bring your best friend</h2>
    <h2 class="text-white text-3xl md:text-4xl font-bold mb-10">and build a healthier, happier life together</h2>
    
    <div class="bg-[#0A1628] rounded-[40px] p-12 max-w-[800px] mx-auto border border-white/10 shadow-xl">
        <h3 class="text-white text-2xl md:text-3xl font-bold mb-8">Limited Offer - Save Up To IDR 3 Mio</h3>
        <p class="text-gray-400 text-lg line-through mb-2">Nominal Price : IDR 20.000.000</p>
        <p class="text-[#FACC15] text-2xl font-bold mb-6">Bestie Bundle : IDR 17.000.000</p>
        <p class="text-gray-300 text-lg">Valid for annual unlimited classes</p>
    </div>
</section>

<section class="max-w-[1100px] mx-auto px-8 py-16">
    <h2 class="text-center text-white text-3xl md:text-4xl font-bold mb-12">What Our Members Say</h2>
    
    <div class="flex flex-col lg:flex-row gap-8 h-full">
        <div class="lg:w-1/2 space-y-6">
            <div class="bg-white rounded-[30px] p-8 flex items-center gap-6 shadow-lg">
                <div class="w-20 h-20 bg-gray-200 rounded-full shrink-0"></div>
                <div>
                    <p class="text-black font-bold text-lg leading-snug mb-2">"Sky Yoga is the best place to wind. Love the vibe"</p>
                    <p class="text-gray-600 text-sm">- Andi</p>
                </div>
            </div>
            <div class="bg-white rounded-[30px] p-8 flex items-center gap-6 shadow-lg">
                <div class="w-20 h-20 bg-gray-200 rounded-full shrink-0"></div>
                <div>
                    <p class="text-black font-bold text-lg leading-snug mb-2">"Amazing instructor and a calming environment"</p>
                    <p class="text-gray-600 text-sm">- Maya</p>
                </div>
            </div>
        </div>
        
        <div class="lg:w-1/2 bg-[#0A1628] rounded-[30px] flex flex-col items-center justify-center p-12 border border-white/10 shadow-lg">
            <div class="text-[80px] mb-4">📍</div>
            <h3 class="text-white font-bold text-3xl mb-2 text-center">Sky Yoga Indonesia</h3>
            <p class="text-gray-400 text-lg">Tangerang, Banten</p>
        </div>
    </div>
</section>

<section class="max-w-[1400px] mx-auto px-8 pt-20 pb-32 text-center">
    <h2 class="text-[#FACC15] text-4xl md:text-5xl font-bold mb-3">Dont miss out!</h2>
    <h2 class="text-[#FACC15] text-4xl md:text-5xl font-bold mb-12">Start your yoga journey today.</h2>
    <a href="#classes" class="inline-block bg-[#FACC15] text-[#0A1628] font-bold py-4 px-12 rounded-md text-lg hover:bg-yellow-500 transition-colors">
        Book Your Class Now
    </a>
</section>

@endsection