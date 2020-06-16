<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateDiscount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            'discount_percentage' => 10,
            'number_purchases' => 10,
            'recent_months' => 3
        ]);
    }
}
