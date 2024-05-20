<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt_BR">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>
        @if($titlePage)
            {{ $titlePage }}
        @else
            {{ config('app.name', 'DataPrag') }}
        @endif
    </title>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#356c31">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/tailwind.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tailwind.output.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable-theme.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/r-2.2.7/datatables.min.css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.0/dark/dark.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji
        }

        * {
            outline: none !important;
            /* transition: 250ms; */
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background-color: white;
        }

        ::-moz-selection { background: #37a169; color: white; }
        ::selection { background: #37a169; color: white; }

        html.theme-dark ::-webkit-scrollbar-track {
            background-color: #121317 !important;
        }
        
        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #37a169;
        }

        #fixedbutton {
            position: fixed;
            bottom: 0px;
            right: 0px; 
            z-index: 999;
        }

        .text-green-600 {
            color: #38a169;
        }
    </style>

    {{-- Custom CSS Styles per Page --}}
    @yield('styles')

</head>
<body x-cloak>

    @include('dash.aside')

    @yield('modals')

    {{-- JS Scripts --}}
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/init-alpine.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/r-2.2.7/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    {{-- JS Scripts --}}
    @yield('scripts')

</body>
</html>
