<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $documentData['fileName'] }}</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <style>
        @import url('http://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        html, * {
            font-family: 'Open Sans' !important;
        }

        h1, h2, h3, h4, p {
            margin: 0;
        }
        
        .page-break {
            page-break-after: always;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-13 {
            font-size: 13px;
        }

        .header-title {
            border: 1px solid black;
            text-align: center;
            margin: 2em 0;
            padding: 2px 0;
        }

        .table {
            font-size: 14px;
            white-space: nowrap;
            text-align: center;
        }

        .table tr td {
            padding: 2px;
        }

        .signature {
            text-align: right;
            margin-top: 6em;
        }

        .h4-custom {
            font-weight: bold;
            margin-bottom: 4px;
            font-size: 24px;
        }

        .wrap {
            overflow: hidden;
            position: relative;
        }

        .wrap-bg {
            opacity: 0.1;
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            top: 0;
            right: 0;
            text-align: center;
            height: auto;
            width: 40%;
        }

        .wrap-content {
            position: relative;
        }

        .mb-45 {
            margin-bottom: 2rem;
        }

    </style>
</head>
<body>
    <div class="container">
        @include('docs.header')
        
        <div class="header-title">
            <h3 class="font-weight-bold">CERTIFICADO DESRATIZAÇÃO</h3>
        </div>

        <div class="row justify-content-between ml-2 mb-4">
            <div class="col-xs-6">
                <p class="fs-18">
                    <strong>Execução do Serviço: {{ $documentData['dataexecucao'] }}</strong> <br/>
                    <strong>Empresa: </strong> {{ $documentData['socialname'] }} <br/>
                    <strong>Endereço: </strong> {{ $documentData['logradouro'] }}, {{ $documentData['numero'] }} <br/>
                    <strong>Bairro: </strong> {{ $documentData['bairro'] }}
                </p>
            </div>
            <div class="col-xs-6">
                <p class="fs-18">
                    <strong>Validade: {{ $documentData['datavalidade'] }}</strong> <br/>
                    <strong>{{ $documentData['labeldn'] }}: </strong> {{ $documentData['dn'] }} <br/>
                    <strong>CEP: </strong> {{ $documentData['cep'] }} <br/>
                    <strong>Municipio: </strong> {{ $documentData['municipio'] }}
                </p>
            </div>
        </div>

        @include('docs.products-table')

        <p class="mb-3">
            <strong>Intoxicação por Raticidas:</strong> Por ingestão, náuseas, vômitos e após alguns dias, equimoses, sangramento excessivo após traumatismos, sangramento nasal e gengival, sangue nas fezes e urina, hemorragias maciças nos casos mais graves.
        </p>

        <p class="mb-3">
            <strong>Antídoto e Tratamento:</strong> aplicar Vitamina K 1 injetável. Obs.: os raticidas granulados possuem uma substância chamada BITREX que faz com que qualquer criança ou animal ao tentar ingerir a isca, rejeite-a pelo amargor que causa.
        </p>

        <p class="mb-3">
            <strong>Primeiros Socorros:</strong> Em caso de contato acidental com a pele e olhos, lavar com água limpa e abundante, em caso de aparecimento de dois ou mais sintomas de intoxicação, levar a pessoa imediatamente para local arejado e procurar auxílio médico o mais rápido possível. O Centro de Controle de Intoxicação da UNICAMP é o local do encaminhamento. O número do telefone é: (19) 3521-7555.
        </p>

        <section class="text-center" style="margin-top: 3em;">
            <h3 style="margin-bottom: 1em;">Araras, {{ $documentData['dataextenso'] }}</h3>
            @include('docs.qrcode')
        </section>
    </div>
</body>
</html>