<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Supplier::create([
            'name' => 'ATUL SUPPLIER',
            'phone' => '01854689752',
        ]);
        \App\Models\Supplier::create([
            'name' => 'RAMAN SUPPLIER',
            'phone' => '01954689752',
        ]);
    }
}
