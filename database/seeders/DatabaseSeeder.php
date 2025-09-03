<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'COCEC',
            'email' => 'contact@cocec.com',
            'password' => Hash::make("Jq]\hE[Wh?]~,Npq048U-7uNpw"),
            'is_admin' => true,
        ]);

        // Ajouter le seeder des plaintes
        // $this->call([
        //     ComplaintSeeder::class,
        // ]);
    }
}
