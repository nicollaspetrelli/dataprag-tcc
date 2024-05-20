<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Dedetização',
                'description' => 'Serviço de Dedetização',
                'path' => 'public/docs/templates/DEDETIZACAO.docx'
            ]
        );
        Document::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'Desratização',
                'description' => 'Serviço de Desratização',
                'path' => 'public/docs/templates/DESRATIZACAO.docx'
            ]
        );
        Document::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Desinfecção de Caixa D’água',
                'description' => 'Limpeza e Desinfecção de Caixa D’água',
                'path' => 'public/docs/templates/DESIFENCCAO_CAIXA.docx'
            ]
        );
    }
}
