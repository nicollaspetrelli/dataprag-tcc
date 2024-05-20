<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::firstOrCreate(
            [
                'id' => 1,
                'name' => 'Bifentol 200sc',
                'manufacturer' => 'N/A',
                'description' => json_encode(
                    [
                        'defensives' => 'Bifentol 200sc',
                        'chemicalGroup' => 'Piretroide',
                        'activeIngredient' => 'Bifentrina',
                        'toxicologicalClass' => '2',
                    ]
                ),
                'registryNumber' => '3.0398.0035.001-9',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["1"])
            ],
        );

        Products::firstOrCreate(
            [
                'id' => 2,
                'name' => 'Lankron 2,5% ME',
                'manufacturer' => 'N/A',
                'description' => json_encode(
                    [
                        'defensives' => 'Lankron 2,5% ME',
                        'chemicalGroup' => 'Piretroide',
                        'activeIngredient' => 'Lambda-cyhalothrin',
                        'toxicologicalClass' => '2',
                    ]
                ),
                'registryNumber' => '3.0425.0085.001-3',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["1"])
            ],
        );

        Products::firstOrCreate(
            [
                'id' => 3,
                'name' => 'Fendona 6sc',
                'manufacturer' => 'N/A',
                'description' => json_encode(
                    [
                        'defensives' => 'Fendona 6sc',
                        'chemicalGroup' => 'Piretrina-Piretroide',
                        'activeIngredient' => 'Alfacipermetrina 6%',
                        'toxicologicalClass' => '2',
                    ]
                ),
                'registryNumber' => '3.0404.0031.001-1',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["1"])
            ],
        );

        Products::firstOrCreate(
            [
                'id' => 4,
                'name' => 'Cyzmic CS Lambda',
                'manufacturer' => 'Adama',
                'description' => json_encode(
                    [
                        'defensives' => 'Lambda-cialotrina',
                        'chemicalGroup' => 'Piretróides',
                        'activeIngredient' => 'Lambda-cialotrina 9,7%',
                        'toxicologicalClass' => '3',
                    ]
                ),
                'registryNumber' => '3.5331.0013.001-6',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["1"])
            ],
        );

        Products::firstOrCreate(
            [
                'id' => 5,
                'name' => 'Roden Blocos',
                'manufacturer' => 'Roden',
                'description' => json_encode(
                    [
                        'defensives' => 'Bloco Extrusado Roden',
                        'chemicalGroup' => 'Cumarínico',
                        'activeIngredient' => 'Brodifacoum 0.005%',
                        'toxicologicalClass' => '-',
                    ]
                ),
                'registryNumber' => '3.5873.0004.001-1',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["2"])
            ],
        );

        Products::firstOrCreate(
            [
                'id' => 6,
                'name' => 'Talon BlocosXT',
                'manufacturer' => 'Syngenta',
                'description' => json_encode(
                    [
                        'defensives' => 'Bloco Extrusado Talon',
                        'chemicalGroup' => 'Cumarínico',
                        'activeIngredient' => 'Brodifacoum 0.005%',
                        'toxicologicalClass' => '-',
                    ]
                ),
                'registryNumber' => '3.0119.6659.001-7',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["2"])
            ],
        );

        Products::firstOrCreate(
            [
                'id' => 7,
                'name' => 'Girasol Rigon',
                'manufacturer' => 'Rogama',
                'description' => json_encode(
                    [
                        'defensives' => 'Girasol Rigon',
                        'chemicalGroup' => 'Cumarínico',
                        'activeIngredient' => 'Brodifacoum 0.005%',
                        'toxicologicalClass' => '-',
                    ]
                ),
                'registryNumber' => '3.0425.0080.001-6',
                'quantity' => '0',
                'price' => '0',
                'category' => json_encode(["2"])
            ],
        );
    }
}
