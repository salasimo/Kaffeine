<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drinks = [
            [
                'type' => 'Caffè Espresso',
                'amount' => 55
            ],
            [
                'type' => 'Caffè Espresso Lungo',
                'amount' => 80
            ],
            [
                'type' => 'Caffè Americano',
                'amount' => 100
            ],
            [
                'type' => 'Tazzina Caffè Moka',
                'amount' => 95
            ],
            [
                'type' => 'Tazza di tè',
                'amount' => 50
            ],
            [
                'type' => 'Bicchiere di Coca-Cola',
                'amount' => 30
            ],
            [
                'type' => 'Lattina di Coca-Cola',
                'amount' => 60
            ],
            [
                'type' => 'Lattina di Red Bull',
                'amount' => 110
            ],
        ];

        foreach ($drinks as $drink) {
            DB::table('drinks')->insert([
                'type' => $drink['type'],
                'amount' => $drink['amount'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
