<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = json_decode(file_get_contents(database_path('data/customers.json')), true);
        foreach ($customers as $customer) {
            \App\Models\Customer::create([
                'id' => $customer['id'],
                'name' => $customer['name'],
                'since' => $customer['since'],
                'revenue' => $customer['revenue'],
            ]);
        }
    }
}
