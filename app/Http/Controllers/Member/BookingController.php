<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Schedule $schedule)
    {
        // 1. Cek apakah kuota masih tersedia (Otomatisasi Slot)
        $currentBookings = $schedule->bookings()->count();
        
        if ($currentBookings >= $schedule->quota) {
            return redirect()->back()->with('error', 'Maaf, slot kelas ini sudah penuh!');
        }

        // 2. Cek apakah user sudah booking kelas yang sama
        $exists = Booking::where('user_id', Auth::id())
            ->where('schedule_id', $schedule->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kelas ini.');
        }

        // 3. Simpan Booking
        Booking::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'status' => 'active',
            'booking_date' => now(),
        ]);

        return redirect()->route('member.booking.history')->with('success', 'Booking berhasil!');
    }
}
