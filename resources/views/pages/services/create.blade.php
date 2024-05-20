@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = 'Novo Serviço';
    $servicesActivePage = true;
@endphp

@section('styles')

<link rel="stylesheet" href="{{ asset('css/plugins/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/daterangerpicker-dark-theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/select2-multiple-dark.css') }}">

<style>
    html.theme-dark .money-currency-icon-active {
        color: #b0ffce7e;
    }

    .money-currency-icon-active {
        color: #38a169;
    }
</style>

@endsection

@section('content')

<h2 class="mt-8 text-3xl font-semibold text-gray-700 dark:text-gray-200">
    Cadastro de Serviço
</h2>


<div class="px-4 py-3 mt-2 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">

    <h4 class="mb-2 text-md font-semibold text-gray-600 dark:text-gray-300">
        Cliente: <br/> {{ $client->companyName }}
    </h4>

    <form action="#" method="POST" id="serviceForm">
        @csrf
        <input type="hidden" name="clients_id" value="{{ $client->id }}">

        <div class="grid md:grid-cols-1 gap-4 mt-4">
            <label class="block">
                <span class="text-gray-700 text-md dark:text-gray-400"> Selecione um ou mais serviços </span>
                <select multiple required id="searchServices" name="documents_id[]" class="mt-6 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green">
                </select>
            </label>
        </div>

        <section id="document1" class="mt-8 border-solid border-2 border-green-400 rounded p-5 hidden">
            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-300">Dedetização</h4>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Data de execução e validade </span>
                    <div class="relative text-gray-500 focus-within:text-green-600">
                        <input
                            class="validity block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Data de execução e validade"
                            id="validity-doc1"
                            name="validity-doc1"
                            value="{{ old('validity-doc1') }}" />
                    </div>
                </label>
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Valor </span>
                    <div class="relative text-gray-500 focus-within:text-green-600 dark:focus-within:text-green-400">
                        <input
                            class="value money-input-1 money-mask block w-full pl-10 mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Valor" id="value-doc1" name="value-doc1" maxlength="9"
                            value="{{ old('value-doc1') }}" />
                        <div class="money-currency-icon-1 absolute inset-y-0 flex items-center ml-3 mr- pointer-events-none">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 96.000000 96.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,96.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                    <path d="M732 828 c-6 -7 -12 -26 -14 -42 -2 -24 -9 -31 -34 -38 -67 -17 -114 -99 -99 -174 9 -52 66 -106 134 -130 102 -36 138 -98 86 -149 -45 -45 -141 -24 -160 35 -8 25 -50 37 -70 20 -48 -40 22 -131 117 -154 19 -4 28 -13 30 -33 7 -58 68 -52 68 7 0 23 5 30 29 35 52 11 101 79 101 140 0 74 -39 117 -152 169 -83 37 -106 64 -94 110 9 38 33 56 77 56 38 0 50 -7 91 -58 10 -12 24 -22 32 -22 21 0 46 28 46 52 0 28 -62 87 -99 94 -27 6 -31 11 -31 38 0 48 -34 73 -58 44z"/>
                                    <path d="M105 735 l-25 -24 0 -240 c0 -204 2 -242 16 -255 19 -19 48 -21 62 -3 6 7 13 56 14 108 l3 94 51 3 51 3 63 -106 c34 -58 67 -108 72 -111 19 -12 58 6 64 29 4 18 -9 47 -50 111 l-55 88 44 41 c32 31 44 53 50 83 14 89 -33 171 -111 193 -21 6 -81 11 -132 11 -85 0 -95 -2 -117 -25z m224 -70 c33 -17 41 -33 41 -84 0 -27 -7 -44 -26 -62 -22 -21 -35 -24 -97 -24 l-72 0 -3 93 -3 92 66 0 c38 0 78 -6 94 -15z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>
            <div class="grid md:grid-cols-1 gap-4 mt-8">
                <label class="block">
                    <span class="text-gray-700 mb-3 text-md dark:text-gray-400"> Selecione um ou mais produtos </span>
                    <select multiple id="products-1" name="products-1[]" class="searchProducts mt-6 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green">
                        @foreach ($products[1] as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="grid md:grid-cols-1 gap-4 mt-8">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Descrição do serviço de Dedetização </span>
                    <textarea
                        class="description block w-full mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                        rows="3" placeholder="Escreva aqui" name="description-doc1">{{ old('description-doc1') }}</textarea>
                </label>
            </div>
        </section>

        <section id="document2" class="mt-8 border-solid border-2 border-green-400 rounded p-5 hidden">
            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-300">Desratização</h4>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Data de execução e validade </span>
                    <div class="relative text-gray-500 focus-within:text-green-600">
                        <input
                            class="validity block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Data de execução e validade"
                            id="validity-doc2"
                            name="validity-doc2"
                            value="{{ old('validity-doc2') }}" />
                    </div>
                </label>
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Valor </span>
                    <div class="relative text-gray-500 focus-within:text-green-600 dark:focus-within:text-green-400">
                        <input
                            class="value money-input-2 money-mask block w-full pl-10 mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Valor" id="value-doc2" name="value-doc2" maxlength="9"
                            value="{{ old('value-doc2') }}" />
                        <div class="money-currency-icon-2 absolute inset-y-0 flex items-center ml-3 mr- pointer-events-none">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 96.000000 96.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,96.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                    <path d="M732 828 c-6 -7 -12 -26 -14 -42 -2 -24 -9 -31 -34 -38 -67 -17 -114 -99 -99 -174 9 -52 66 -106 134 -130 102 -36 138 -98 86 -149 -45 -45 -141 -24 -160 35 -8 25 -50 37 -70 20 -48 -40 22 -131 117 -154 19 -4 28 -13 30 -33 7 -58 68 -52 68 7 0 23 5 30 29 35 52 11 101 79 101 140 0 74 -39 117 -152 169 -83 37 -106 64 -94 110 9 38 33 56 77 56 38 0 50 -7 91 -58 10 -12 24 -22 32 -22 21 0 46 28 46 52 0 28 -62 87 -99 94 -27 6 -31 11 -31 38 0 48 -34 73 -58 44z"/>
                                    <path d="M105 735 l-25 -24 0 -240 c0 -204 2 -242 16 -255 19 -19 48 -21 62 -3 6 7 13 56 14 108 l3 94 51 3 51 3 63 -106 c34 -58 67 -108 72 -111 19 -12 58 6 64 29 4 18 -9 47 -50 111 l-55 88 44 41 c32 31 44 53 50 83 14 89 -33 171 -111 193 -21 6 -81 11 -132 11 -85 0 -95 -2 -117 -25z m224 -70 c33 -17 41 -33 41 -84 0 -27 -7 -44 -26 -62 -22 -21 -35 -24 -97 -24 l-72 0 -3 93 -3 92 66 0 c38 0 78 -6 94 -15z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>
            <div class="grid md:grid-cols-1 gap-4 mt-8">
                <label class="block">
                    <span class="text-gray-700 mb-3 text-md dark:text-gray-400"> Selecione um ou mais produtos </span>
                    <select multiple id="products-2" name="products-2[]" class="searchProducts mt-6 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green">
                        @foreach ($products[2] as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="grid md:grid-cols-1 gap-4 mt-8">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Descrição do serviço de Desratização </span>
                    <textarea
                        class="description block w-full mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                        rows="3" placeholder="Escreva aqui" name="description-doc2">{{ old('description-doc2') }}</textarea>
                </label>
            </div>
        </section>

        <section id="document3" class="mt-8 border-solid border-2 border-green-400 rounded p-5 hidden">
            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-300">Desinfecção de Caixa D’água</h4>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Data de execução e validade </span>
                    <div class="relative text-gray-500 focus-within:text-green-600">
                        <input
                            class="validity block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Data de execução e validade"
                            id="validity-doc3"
                            name="validity-doc3"
                            value="{{ old('validity-doc3') }}" />
                    </div>
                </label>
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Valor </span>
                    <div class="relative text-gray-500 focus-within:text-green-600 dark:focus-within:text-green-400">
                        <input
                            class="value money-input-3 money-mask block w-full pl-10 mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Valor" id="value-doc3" name="value-doc3" maxlength="9"
                            value="{{ old('value-doc3') }}" />
                        <div class="money-currency-icon-3 absolute inset-y-0 flex items-center ml-3 mr- pointer-events-none">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 96.000000 96.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,96.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                    <path d="M732 828 c-6 -7 -12 -26 -14 -42 -2 -24 -9 -31 -34 -38 -67 -17 -114 -99 -99 -174 9 -52 66 -106 134 -130 102 -36 138 -98 86 -149 -45 -45 -141 -24 -160 35 -8 25 -50 37 -70 20 -48 -40 22 -131 117 -154 19 -4 28 -13 30 -33 7 -58 68 -52 68 7 0 23 5 30 29 35 52 11 101 79 101 140 0 74 -39 117 -152 169 -83 37 -106 64 -94 110 9 38 33 56 77 56 38 0 50 -7 91 -58 10 -12 24 -22 32 -22 21 0 46 28 46 52 0 28 -62 87 -99 94 -27 6 -31 11 -31 38 0 48 -34 73 -58 44z"/>
                                    <path d="M105 735 l-25 -24 0 -240 c0 -204 2 -242 16 -255 19 -19 48 -21 62 -3 6 7 13 56 14 108 l3 94 51 3 51 3 63 -106 c34 -58 67 -108 72 -111 19 -12 58 6 64 29 4 18 -9 47 -50 111 l-55 88 44 41 c32 31 44 53 50 83 14 89 -33 171 -111 193 -21 6 -81 11 -132 11 -85 0 -95 -2 -117 -25z m224 -70 c33 -17 41 -33 41 -84 0 -27 -7 -44 -26 -62 -22 -21 -35 -24 -97 -24 l-72 0 -3 93 -3 92 66 0 c38 0 78 -6 94 -15z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>
            <div class="grid md:grid-cols-1 gap-4 mt-8">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Descrição do serviço de Desinfecção de Caixa D’água </span>
                    <textarea
                        class="description block w-full mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                        rows="3" placeholder="Escreva aqui" name="description-doc3">{{ old('description-doc3') }}</textarea>
                </label>
            </div>
        </section>

        <div>
            <button type="submit"
                class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                Cadastrar Serviço
            </button>
            <a href="{{ route('clientes.show', $client->id) }}"
                class="ml-3 mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                Voltar ao Cliente
            </a>
        </div>
    </form>
</div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/jquery.maskMoney.min.js') }}"></script>

<script>
$(document).ready(function () {

    // Money Format Field
    $('.money-input-1').focusin(function (e) {
        $('.money-currency-icon-1').addClass('money-currency-icon-active');
    });

    $('.money-input-1').focusout(function (e) {
        $('.money-currency-icon-1').removeClass('money-currency-icon-active');
    });

    $('.money-input-2').focusin(function (e) {
        $('.money-currency-icon-2').addClass('money-currency-icon-active');
    });

    $('.money-input-2').focusout(function (e) {
        $('.money-currency-icon-2').removeClass('money-currency-icon-active');
    });

    $('.money-input-3').focusin(function (e) {
        $('.money-currency-icon-3').addClass('money-currency-icon-active');
    });

    $('.money-input-3').focusout(function (e) {
        $('.money-currency-icon-3').removeClass('money-currency-icon-active');
    });

    $("#value-doc1").maskMoney({
        allowNegative: false,
        thousands:'.',
        decimal:',',
        affixesStay: false
    })

    $("#value-doc2").maskMoney({
        allowNegative: false,
        thousands:'.',
        decimal:',',
        affixesStay: false
    })

    $("#value-doc3").maskMoney({
        allowNegative: false,
        thousands:'.',
        decimal:',',
        affixesStay: false
    })

    // Select2 Search Services
    $("#searchServices").select2({
        width: '100%',
        placeholder: 'Selecione um ou mais serviços',
        multiple: true,
        closeOnSelect: false
    });

    $(".searchProducts").select2({
        width: '100%',
        placeholder: 'Selecione um ou mais produtos',
        multiple: true,
        closeOnSelect: false
    });

    $('#searchServices').on('select2:select', function (e) {
        var data = e.params.data;

        $('#document'+data.id).removeClass('hidden');
        $('#validity-doc'+data.id).prop('required', true);
        $('#value-doc'+data.id).prop('required', true);
        $('#description-doc'+data.id).prop('required', true);
        $('#products-'+data.id).prop('required', true);
    });

    $('#searchServices').on('select2:unselect', function (e) {
        var data = e.params.data;

        $('#document'+data.id).addClass('hidden');
        $('#validity-doc'+data.id).prop('required', false);
        $('#value-doc'+data.id).prop('required', false);
        $('#description-doc'+data.id).prop('required', false);
        $('#products-'+data.id).prop('required', false);
    });

    function clearAllServices() {
        const documentsIds = [1, 2, 3];

        $('.validity').val('');
        $('.value').val('');
        $('.description').val('');
        $('#searchServices').val('');
        $('#searchServices').trigger('change.select2');

        documentsIds.forEach(id => {
            console.log('limpando doc', id);
            $('#document'+id).addClass('hidden');
            $('#validity-doc'+id).prop('required', false);
            $('#value-doc'+id).prop('required', false);
            $('#description-doc'+id).prop('required', false);
        });
    }

    // Populate Select 2
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: "{{ route('services.getServices') }}",
        dataType: "json",
        success: function (response) {
            console.info('Cached services succefully load!')
            response.forEach(data => {
                console.log(data)
                var newOption = new Option(data.text, data.id, false, false);
                $('#searchServices').append(newOption).trigger('change');
            });
        },
        error: function (status) {
            Swal.fire(
            {
                title: 'Oops! ',
                text: 'Não conseguimos carregar seus serviços =/',
                icon: 'error',
                allowOutsideClick: false,
            }).then((result) => {
                window.location.href = "{{ route('painel') }}";
            })
        }
    });

    // Date range picker
    var startDate = moment();
    var endDate = moment().add(6, 'M');

    dateRanges = {
        '6 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(6, 'M')],
        '5 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(5, 'M')],
        '4 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(4, 'M')],
        '3 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(3, 'M')],
        '2 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(2, 'M')],
        '1 Mês': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(1, 'M')]
    }

    $('.validity').daterangepicker({
        locale: {
            format: "DD/MM/YYYY",
            separator: " - ",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
            ],
            "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ],
            "firstDay": 1
        },
        startDate: startDate,
        endDate: endDate,
        ranges: dateRanges
    }, cb);

    function cb(start, end) {
        startDate = start;
        endDate = end;

        $('.validity').each(function (index, element) {
            let count = index + 1
            let startDateOfElement = $("[name='validity-doc"+count+"']").data('daterangepicker').startDate;

            $("[name='validity-doc"+count+"']").data().daterangepicker.ranges = {
                '6 Meses': [moment(startDateOfElement.format('YYYY-MM-DD')), moment(startDateOfElement.format('YYYY-MM-DD')).add(6, 'M')],
                '5 Meses': [moment(startDateOfElement.format('YYYY-MM-DD')), moment(startDateOfElement.format('YYYY-MM-DD')).add(5, 'M')],
                '4 Meses': [moment(startDateOfElement.format('YYYY-MM-DD')), moment(startDateOfElement.format('YYYY-MM-DD')).add(4, 'M')],
                '3 Meses': [moment(startDateOfElement.format('YYYY-MM-DD')), moment(startDateOfElement.format('YYYY-MM-DD')).add(3, 'M')],
                '2 Meses': [moment(startDateOfElement.format('YYYY-MM-DD')), moment(startDateOfElement.format('YYYY-MM-DD')).add(2, 'M')],
                '1 Mês': [moment(startDateOfElement.format('YYYY-MM-DD')), moment(startDateOfElement.format('YYYY-MM-DD')).add(1, 'M')]
            }
        });
    }

    // Form Submition
    $('#serviceForm').submit(function (e) {
        e.preventDefault();

        var startdoc1 = $('#validity-doc1').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var startdoc2 = $('#validity-doc2').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var startdoc3 = $('#validity-doc3').data('daterangepicker').startDate.format('YYYY-MM-DD');

        var enddoc1 = $('#validity-doc1').data('daterangepicker').endDate.format('YYYY-MM-DD');
        var enddoc2 = $('#validity-doc2').data('daterangepicker').endDate.format('YYYY-MM-DD');
        var enddoc3 = $('#validity-doc3').data('daterangepicker').endDate.format('YYYY-MM-DD');

        var valueInt1 = $('#value-doc1').maskMoney('unmasked')[0];
        var valueInt2 = $('#value-doc2').maskMoney('unmasked')[0];
        var valueInt3 = $('#value-doc3').maskMoney('unmasked')[0];

        console.log(valueInt1, valueInt2, valueInt3);

        var data = $(this).serialize()
            + '&startDoc1=' + startdoc1 + '&endDoc1=' + enddoc1
            + '&startDoc2=' + startdoc2 + '&endDoc2=' + enddoc2
            + '&startDoc3=' + startdoc3 + '&endDoc3=' + enddoc3
            + '&valueIntDoc1=' + valueInt1
            + '&valueIntDoc2=' + valueInt2
            + '&valueIntDoc3=' + valueInt3;

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: "{{ route('services.store') }}",
            data: data,
            dataType: 'json',
            beforeSend: function (xhr, settings) {
                Swal.showLoading();
                xhr.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                clearAllServices();

                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Serviço cadastrado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'Baixar documentos e voltar',
                    confirmButtonColor: '#37a169',
                    showCancelButton: false,
                    showDenyButton: true,
                    denyButtonText: `Voltar ao cliente`,
                    denyButtonColor: '#2d3748',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let servicesIds = data.serviceIds;
                        let dataJson = {
                            services: servicesIds
                        }

                        if (servicesIds.length < 1) {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro desconhecido ao baixar os arquivos!',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#37a169',
                                showCancelButton: false,
                                showDenyButton: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('clientes.show', $client->id) }}";
                                }
                            });
                        }

                        if (servicesIds.length === 1) {
                            window.open('/doc/' + servicesIds[0], '_blank').focus();
                            showAlertDownloadComplete();
                        }

                        if (servicesIds.length > 1) {
                            Swal.fire({
                                title: 'Aguarde!',
                                text: 'Estamos gerando os seus arquivos!',
                                icon: 'info',
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });

                            // Download two or more documents in merged
                            $.ajax({
                                type: "POST",
                                url: "{{ route('services.print') }}",
                                data: dataJson,
                                dataType: "json",
                                beforeSend: function (xhr, settings) {
                                    Swal.showLoading();
                                    xhr.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                                },
                                success: function (response) {
                                    window.open(response.url, '_blank').focus();
                                    showAlertDownloadComplete();
                                },
                                error: function (error) {
                                    console.log(error);
                                    window.location.href = "{{ route('clientes.show', $client->id) }}";
                                },
                                complete: function() {
                                    Swal.hideLoading();
                                }
                            });
                        }
                    }

                    if (result.isDenied) {
                        window.location.href = "{{ route('clientes.show', $client->id) }}";
                    }
                })
            },
            error: function (xhr, status, error) {
                console.log(error);

                Swal.fire(
                    'Oops algo deu errado!',
                    'Não foi possível cadastrar esse serviço!' + '<br/>' +
                    'Status: ' + xhr.statusText,
                    'error'
                );
            },
            complete: function() {
                Swal.hideLoading();
            }
        });

        function showAlertDownloadComplete() {
            Swal.fire({
                title: 'Sucesso!',
                text: 'Documentos baixados com sucesso!',
                icon: 'success',
                confirmButtonText: 'Ok Voltar',
                confirmButtonColor: '#37a169',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('clientes.show', $client->id) }}";
                }
            })
        }

    });

    });
</script>
@endsection
