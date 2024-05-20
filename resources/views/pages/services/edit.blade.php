@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = 'Editando Serviço';
    $servicesActivePage = true;
@endphp

@section('styles')

<link rel="stylesheet" href="{{ asset('css/plugins/daterangepicker.css') }}">
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

<div class="px-6 py-4 mt-8 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

    <h2 class="mt-2 text-3xl font-semibold text-gray-700 dark:text-gray-200">
        Edição de Serviço
    </h2>

    <h4 class="mb-2 text-md font-semibold text-gray-600 dark:text-gray-300">
        Cliente: {{ $client->companyName }} <br/>
        Serviço: {{ $service->documents->name }}
    </h4>

    <form method="POST" id="editServicesForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="clients_id" value="{{ $client->id }}">

        <section id="document" class="mt-8 border-solid border-2 border-green-400 rounded p-5">
            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-300">{{ $service->documents->name }}</h4>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Data de execução e validade </span>
                    <div class="relative text-gray-500 focus-within:text-green-600">
                        <input
                            class="validity block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Data de execução e validade"
                            id="validity"
                            name="validity"
                            start=""
                            end=""
                            value="{{ old('validity', $service->validity) }}" />
                    </div>
                </label>
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Valor </span>
                    <div class="relative text-gray-500 focus-within:text-green-600 dark:focus-within:text-green-400">
                        <input
                            class="value money-input money-mask block w-full pl-10 mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                            placeholder="Valor" id="value" name="value" maxlength="9"
                            value="{{ old('value', str_replace('.', ',', $service->value)) }}" />
                        <div class="money-currency-icon absolute inset-y-0 flex items-center ml-3 mr- pointer-events-none">
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
            @if ($service->documents->id !== 3)
                <div class="grid md:grid-cols-1 gap-4 mt-8">
                    <label class="block">
                        <span class="text-gray-700 mb-3 text-md dark:text-gray-400"> Selecione um ou mais produtos </span>
                        <select multiple id="products" name="products[]" class="searchProducts mt-6 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green">
                            @foreach ($products[$service->documents_id] as $product)
                                <option value="{{ $product->id }}" {{ $service->hasProduct($product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select> 
                    </label>
                </div>
            @endif
            <div class="grid md:grid-cols-1 gap-4 mt-8">
                <label class="block">
                    <span class="text-gray-700 text-md dark:text-gray-400"> Descrição do serviço de {{ $service->documents->name }} </span>
                    <textarea
                        class="description block w-full mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                        rows="3" placeholder="Escreva suas observações aqui" name="description">{{ old('description', $service->description) }}</textarea>
                </label>
            </div>
        </section>

        <div class="mb-5 mt-10">
            <a href="#" id="submitServiceBtn" data-id="{{$service->id}}"
                class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                Atualizar Serviço
            </a>
            <a href="javascript:history.back()"
                class="ml-3 mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                Voltar ao cliente
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

    $("#value").maskMoney({
        allowNegative: false,
        thousands:'.',
        decimal:',',
        affixesStay: false
    })

    $('.money-input').focusin(function (e) {
        $('.money-currency-icon').addClass('money-currency-icon-active');
    });

    $('.money-input').focusout(function (e) {
        $('.money-currency-icon').removeClass('money-currency-icon-active');
    });

    $(".searchProducts").select2({
        width: '100%',
        placeholder: 'Selecione um ou mais produtos',
        multiple: true,
        closeOnSelect: false
    });

    // Date range picker
    var startDate = moment("{{ $service->dateExecution }}");
    var endDate = moment("{{ $service->dateValidity }}");

    dateRanges = {
        '6 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(6, 'M')],
        '5 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(5, 'M')],
        '4 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(4, 'M')],
        '3 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(3, 'M')],
        '2 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(2, 'M')],
        '1 Mês': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(1, 'M')]
    }

    $('#validity').daterangepicker({
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
        $('#validity').attr('start', start.format('YYYY/MM/DD'));
        $('#validity').attr('end', end.format('YYYY/MM/DD'));
        
        startDate = start;
        endDate = end;

        RevalidateDatePredefinedRanges();
    }

    function RevalidateDatePredefinedRanges() {
        $('#validity').data().daterangepicker.ranges = {
            '6 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(6, 'M')],
            '5 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(5, 'M')],
            '4 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(4, 'M')],
            '3 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(3, 'M')],
            '2 Meses': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(2, 'M')],
            '1 Mês': [moment(startDate.format('YYYY-MM-DD')), moment(startDate.format('YYYY-MM-DD')).add(1, 'M')]
        }
    }

    $('#submitServiceBtn').click(function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');

        Swal.fire({
            title: 'Você tem certaza?',
            text: "Ao editar o serviço os dados são sobrescritos e não podem ser recuperados. Se você deseja mante-los, clique em cancelar.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#2d3748',
            confirmButtonText: 'Alterar!'
        }).then((result) => {
            if (result.isConfirmed) {
                sendFormViaAjax();
            }
        })
    });

    function sendFormViaAjax() {
        var startInputDate = $('#validity').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var endInputDate = $('#validity').data('daterangepicker').endDate.format('YYYY-MM-DD');
        var value = $('#value').maskMoney('unmasked')[0];

        var data = $('#editServicesForm').serialize() 
            + '&start=' + startInputDate + '&end=' + endInputDate 
            + '&value=' + value;

        $.ajax({
            type: 'ajax',
            method: 'PUT',
            url: "{{ route('services.update', ['service' => $service->id]) }}",
            data: data,
            dataType: 'json',
            beforeSend: function (xhr, settings) {
                Swal.showLoading();
                xhr.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Dados do serviço atualizado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'Ok! voltar ao cliente',
                    confirmButtonColor: '#37a169',
                    showCancelButton: true,
                    cancelButtonText: "Editar mais",
                    cancelButtonColor: '#2d3748',
                }).then((result) => {
                    if (result.isConfirmed) {
                       window.location.href = "{{ route('clientes.show', $client->id) }}";
                    }
                })
            },
            error: function (xhr, status, error) {
                console.log(error);

                Swal.fire(
                    'Oops algo deu errado!',
                    'Não foi possível atualizar esse serviço!' + '<br/>' +
                    'Status: ' + xhr.statusText, 
                    'error'
                );
            },
            complete: function() {
                Swal.hideLoading();
            }
        });
    }
});
</script>
@endsection
