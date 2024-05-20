@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = 'Painel';
    $painel = true;
@endphp

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />

    <style>
        /* text-amber-700 bg-amber-100 rounded-full dark:bg-amber-700 dark:text-amber-100 */
        .text-amber-700 {
            color: #b45309;
        }

        .text-amber-100 {
            color: #fef3c7;
        }

        .bg-amber-700 {
            background-color: #b45309;
        }

        .bg-amber-100 {
            background-color: #fef3c7;
        }
    </style>
@endsection

@section('content')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Painel de Controle
    </h2>
    <!-- CTA -->
    <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-green-100 bg-green-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-green" href="#" target="_blank">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
            </svg>
            <span>
                Essa é uma versão em
                @if (env('APP_ENV') == 'prod')
                    Produção!
                @else
                    Desenvolvimento!
                @endif
                 v1.1.0
            </span>
        </div>
        <span>Deixe seu feedback &RightArrow;</span>
    </a>
    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div
                class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total de Clientes
                </p>
                <p class="countable text-lg font-semibold text-gray-700 dark:text-gray-200" data-from="0" data-to="{{ $dashboard['totalClients'] ?? '0' }}">
                    {{ $dashboard['totalClients'] ?? '0' }}
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div
                class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    Ganhos
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    <span class="countableMoney" data-from="0" data-to="{{ $dashboard['earnings'] ?? '0' }}"></span>
                </p>
                <p class="text-xs text-gray-500">Ultimos 30 dias</p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div
                class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    Novos Serviços
                </p>
                <p class="countable text-lg font-semibold text-gray-700 dark:text-gray-200" data-from="0" data-to="{{ $dashboard['totalServices'] ?? '0' }}">
                    {{ $dashboard['totalServices'] ?? '0' }}
                </p>
                <p class="text-xs text-gray-500">Ultimos 30 dias</p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div
                class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Clientes Pendentes
                </p>
                <p class="countable text-lg font-semibold text-gray-700 dark:text-gray-200" data-from="0" data-to="{{ $dashboard['contactPending'] ?? '0' }}">
                    {{ $dashboard['contactPending'] ?? '0' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <span>Serviços Pendentes</span>
    </h2>

    <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
        <div class="w-full overflow-hidden">
            <table class="w-full whitespace-no-wrap" id="servicesTable">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Tipo de Serviço</th>
                        <th class="px-4 py-3">Executado em</th>
                        <th class="px-4 py-3">Vence em</th>
                        <th class="px-4 py-3">Atualizado</th>
                        <th class="px-4 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto">
                        @foreach ($services as $service)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $service->clients->companyName }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ ($service->clients->fantasyName) ? $service->clients->fantasyName : $service->clients->companyName }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $service->documents->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $service->dateExecution->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($service->expired == 2)
                                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            {{ $service->dateValidity->format('d/m/Y') }} (Vencido)
                                        </span>
                                    @else
                                        <span class="px-2 py-1 font-semibold leading-tight text-amber-700 bg-amber-100 rounded-full dark:bg-amber-700 dark:text-amber-100">
                                            {{ $service->dateValidity->format('d/m/Y') }} (Em prazo)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $service->updated_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center  text-sm">
                                        <a href="{{ route('clientes.show', ['cliente' => $service->clients->id]) }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="View Client">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="#"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Email">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Charts -->
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Estatisticas
    </h2>
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Serviços
            </h4>
            <canvas id="pie"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-blue-500 rounded-full"></span>
                    <span>Dedetizações</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                    <span>Desratizações</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                    <span>Desinfecção de Caixa D’água</span>
                </div>
            </div>
        </div>
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Receita
            </h4>
            <canvas id="line"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                    <span>Receita</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
<script type="text/javascript" src="{{ asset('js/plugins/countTo.js') }}"></script>

<script>
    $(document).ready(function () {

    $('.countable').countTo();

    $('.countableMoney').countTo({
        formatter: function (value, options) {
            // return value.toFixed(options.decimals);
            return value.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
        },
    });

    // SERVICES
    $.ajax({
        url: '{{ route('dashboard.services') }}',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            generateServiceTypeChart(data)
        },
        error: function (data) {
            console.log(data)
        }
    })

    // REVENUE
    $.ajax({
        url: '{{ route('dashboard.revenue') }}',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            generateRevenueChart(data)
        },
        error: function (data) {
            console.log(data)
        }
    })

    function generateServiceTypeChart(services) {
        const pieConfig = {
            type: 'doughnut',
            data: {
                datasets: [
                {
                    data: services,
                    /**
                     * These colors come from Tailwind CSS palette
                     * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
                     */
                    backgroundColor: ['#0694a2', '#1c64f2', '#7e3af2'],
                    label: 'Dataset 1',
                },
                ],
                labels: ['Dedetizações', 'Desratizações', 'Desinfecção de Caixa D’água'],
            },
            options: {
                responsive: true,
                cutoutPercentage: 80,
                /**
                 * Default legends are ugly and impossible to style.
                 * See examples in charts.html to add your own legends
                 *  */
                legend: {
                display: false,
                },
            },
        }

        // change this to the id of your chart element in HMTL
        const pieCtx = document.getElementById('pie')
        window.myPie = new Chart(pieCtx, pieConfig)
    }

    // create a function to generate revenue chart
    function generateRevenueChart(revenue) {
        const lineConfig = {
        type: 'line',
        data: {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [
                {
                    label: 'Receita',
                    /**
                     * These colors come from Tailwind CSS palette
                     * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
                     */
                    backgroundColor: '#0694a2',
                    borderColor: '#0694a2',
                    // get data via ajax
                    data: revenue,
                    fill: false,
                }
            ],
        },
        options: {
            responsive: true,
            /**
             * Default legends are ugly and impossible to style.
             * See examples in charts.html to add your own legends
             *  */
            legend: {
                display: false,
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true,
            },

            scales: {
            x: {
                display: true,
                scaleLabel: {
                    display: true,
                    abelString: 'Month',
                },
            },
            y: {
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value',
                },
            },
            },
        },
        }

        // change this to the id of your chart element in HMTL
        const lineCtx = document.getElementById('line')
        window.myLine = new Chart(lineCtx, lineConfig)
    }




    // Services Table
    let table = $('#servicesTable').DataTable({
        autoWidth: false,
        responsive: false,

        dom: '<"hidden grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9 dark:text-gray-400" <"#tableTitle.flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-gray-300"> <"#dtServicesSearch.flex items-center justify-center col-span-3"> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"B>>    <"w-full overflow-hidden rounded-lg shadow-xs"<"w-full overflow-hidden"<"bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto"t>><"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"<"flex items-center col-span-3"i><"flex items-center justify-center col-span-3"l> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"p>>>',
        buttons: [
            // {
            //     text: '+ Novo Serviço',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = "#";
            //     }
            // },
            // 'copy',
            'excel',
            'pdf',
        ],

        "order": [[ 3, "asc" ]],

        "lengthMenu": [[4, 10, 25, 50, -1], [4, 10, 25, 50, "Todos"]],

        "pagingType": "simple_numbers",

        "language": {
            "lengthMenu": "Mostrando _MENU_ por página",
            "zeroRecords": "Bom trabalho! nenhum serviço pendente! 🥳",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Sem mais registros disponiveis",
            "infoFiltered": " - filtrado",
            "search": "Pesquisar:",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior",
                "first": "Primeiro",
                "last": "Último"
            },
        }
    }).columns.adjust().responsive.recalc();

    let tableName = 'Serviços Pendentes'
    $("#tableTitle").append('<p>'+tableName+'</p>');

    // $("#dtServicesSearch").append('<div class="relative w-full max-w-xl mr-6 focus-within:text-green-500">' +
    //                 '<div class="absolute inset-y-0 flex items-center pl-2 text-green-500">' +
    //                     '<svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">' +
    //                         '<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd">' +
    //                         '</path>' +
    //                     '</svg>' +
    //                 '</div>' +
    //                 '<input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-green-600 dark:bg-gray-700 dark:text-gray-400 focus:placeholder-gray-500 focus:bg-white focus:border-green-500 focus:outline-none focus:shadow-outline-green form-input" type="text" id="dtServicesSearchInput" placeholder="Pesquisar por Serviços" aria-label="Search">' +
    //             '</div>');

    $('#dtServicesSearchInput').keyup(function(){
        table.search($(this).val()).draw();
    })

    $('#headerSearch').keyup(function(){
        table.search($(this).val()).draw();
    })

    });

</script>
@endsection
