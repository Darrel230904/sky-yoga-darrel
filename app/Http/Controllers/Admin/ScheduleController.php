<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\YogaClass;
use App\Models\Trainer;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function create()
    {
        return view('admin.schedules.create', [
            'classes' => YogaClass::all(), // [cite: 40]
            'trainers' => Trainer::all(), // [cite: 41]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required',
            'trainer_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'quota' => 'required|integer', // Set Quota [cite: 43]
        ]);

        Schedule::create($validated);
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dibuat.');
    }
}