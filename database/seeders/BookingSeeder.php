<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Member 1 (Budi) mem-booking jadwal pertama (Hatha Yoga)
        Booking::create([
            'user_id' => 2, // ID Budi
            'schedule_id' => 1, // ID Jadwal Hatha Yoga
            'status' => 'active',
            'booking_date' => Carbon::now(),
        ]);

        // Member 2 (Siti) mem-booking jadwal pertama (Hatha Yoga)
        Booking::create([
            'user_id' => 3, // ID Siti
            'schedule_id' => 1, // ID Jadwal Hatha Yoga
            'status' => 'active',
            'booking_date' => Carbon::now(),
        ]);
    }
}