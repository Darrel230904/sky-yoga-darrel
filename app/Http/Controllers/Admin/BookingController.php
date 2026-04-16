<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar seluruh booking yang dilakukan oleh member.
     * Ini memenuhi kebutuhan monitoring transaksi di CMS.
     */
    public function index(Request $request)
    {
        // Mengambil data booking beserta relasi user (member) dan jadwal kelasnya
        $query = Booking::with(['user', 'schedule.yogaClass', 'schedule.trainer']);

        // Opsi: Filter berdasarkan status jika diperlukan
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Urutkan berdasarkan tanggal booking terbaru
        $bookings = $query->orderBy('created_at', 'desc')->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Opsional: Fitur untuk mengubah status booking (misal: Mark as Completed)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,cancelled,completed'
        ]);

        $booking->update($validated);

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }
}