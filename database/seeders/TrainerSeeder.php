<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    public function run(): void
    {
        Trainer::create([
            'name' => 'Anya Geraldine',
            'bio' => 'Instruktur bersertifikat internasional dengan pengalaman 5 tahun di Vinyasa Flow.',
            'photo_url' => 'https://via.placeholder.com/150'
        ]);

        Trainer::create([
            'name' => 'Zia',
            'bio' => 'Spesialis Hatha Yoga untuk pemula dan pemulihan cedera.',
            'photo_url' => 'https://via.placeholder.com/150'
        ]);
    }
}