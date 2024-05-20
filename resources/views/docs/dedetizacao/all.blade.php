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
            /* text-decoration: underline; */
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
        @include('docs.dedetizacao.page1')
        
        <div class="page-break"></div>

        @include('docs.header')
        @include('docs.dedetizacao.page2')

        <div class="page-break"></div>

        @include('docs.header')
        @include('docs.dedetizacao.page3')
    </div>
</body>
</html>