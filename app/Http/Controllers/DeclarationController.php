<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class DeclarationController extends Controller
{
    public function create()
    {
        return view('pages.declarations.create');
    }

    public function selection()
    {
        return view('pages.declarations.select');
    }

    public function generate(Request $request)
    {
        $request->validate(
            [
                'companyName' => 'required',
                'date' => 'required|date',
            ]
        );

        $companyName = $request->input('companyName');
        $date = Carbon::parse($request->input('date'))->formatLocalized('%d de %B de %Y', 'pt_BR');

        $templateFile = Storage::path('public/docs/templates/DECLARATIONS.docx');
        $templateProcessor = new TemplateProcessor($templateFile);

        $documentData = [
            'companyName' => $companyName,
            'dataExtenso' => $date,
        ];

        foreach ($documentData as $field => $value) {
            $documentData[$field] = htmlspecialchars($value);
        }

        $templateProcessor->setValues($documentData);

        $finalPatch = storage_path('app/public/' . 'Declaracao.docx');

        try {
            $templateProcessor->saveAs($finalPatch);
        } catch (Exception $e) {
            dd($e);
        }

        return response()->download($finalPatch)->deleteFileAfterSend(true);
    }
}
