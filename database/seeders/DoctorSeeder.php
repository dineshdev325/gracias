<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
DB::table('doctors')->insert([
            [
                'name' => 'Dr. Emanuel',
                'specialization' => 'Internal Medicine',
                'whatsapp_number' => '+1234567890', // replace with actual number
                'amount' => '1000',
                'image'=>'https://graciasconnect.com/storage/ngpzQR706vLMBpPSyCei8qLclGtzLw-metaSU1HXzM2NjYuanBlZw==-.jpg
'
            ],
            [
                'name' => 'Dr. Jessica',
                'specialization' => 'Pediatric and Women\'s Health',
                'whatsapp_number' => '+0987654321', // replace with actual number
                'amount' => '1000',
                'image'=>'https://graciasconnect.com/storage/4vO0JUYNnp9K2M0JAYjHAaVeb6hTfP-metaMUozQTkyNDMuanBlZw==-.jpg
'
            ]
        ]);

    }
}
