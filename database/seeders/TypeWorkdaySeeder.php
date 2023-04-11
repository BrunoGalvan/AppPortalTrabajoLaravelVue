<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeWorkday;


class TypeWorkdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeWorkday::insert(
            [
                [
                    'name' => 'FULL TIME',
                ],
                [
                    'name' => 'PART TIME',
                ]
            ]

        );
    }
}
