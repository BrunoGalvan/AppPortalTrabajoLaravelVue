<?php

namespace Database\Seeders;

use App\Models\TypeDocument;


use Illuminate\Database\Seeder;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDocument::insert(
            [
                [
                    'name' => 'L.E / DNI',
                ],
                [
                    'name' => 'CARNET EXT.',
                ],
                [
                    'name' => 'RUC',
                ],
                [
                    'name' => 'PASAPORTE',
                ],
                [
                    'name' => 'P. NAC.',
                ],
                [
                    'name' => 'OTROS',
                ]
            ]

        );
    }
}
