@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = $client->companyName;
    $clientsActivePage = true;
@endphp

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loader.css') }}"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

    <link rel="stylesheet" href="{{ asset('css/plugins/select2-multiple-dark.css') }}">

    <style>
        #mapid {
            width: 100%;
            height: 70%;
            border-radius: 10px;
            z-index: 0;
        }

        a.close-modal {
            display: none !important;
        }

        html.theme-dark .money-currency-icon-active {
            color: #b0ffce7e;
        }

        .money-currency-icon-active {
            color: #38a169;
        }
    </style>
@endsection

@section('content')

<input type="hidden" id="mapCords" value="{{ $client->street }} {{ $client->city }} {{ $client->state }}">

<div class="mt-8 mb-8">
    <h2 class="mb-1 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <span id="teste">Pasta do Cliente</span>
    </h2>

    <h4 class="mb-1 text-lg font-semibold text-gray-600 dark:text-gray-300">
        {{ $client->companyName }}
    </h4>

    <h4 class="mb-2 text-md font-semibold text-gray-600 dark:text-gray-300">
        @if ($client->type)
            Pessoa Fisica
        @else
            Pessoa Juridica
        @endif
    </h4>
</div>

<!-- Cards -->
<div class="grid gap-6 mb-8 md:grid-cols-2">
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Informações de Cadastro
        </h4>
        <div class="text-gray-600 dark:text-gray-400">
            <table class="table-fixed mb-4">
                <tbody>
                    <tr>
                        <td style="width: 200px">CNPJ/CPF:</td>
                        <td>{{ $client->documentNumber }}</td>
                    </tr>

                    <tr>
                        <td style="width: 200px">Razão Social:</td>
                        <td>{{ $client->companyName }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">Nome Fantasia:</td>
                        <td>{{ $client->fantasyName }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">Nome de Identificação:</td>
                        <td>{{ $client->identificationName }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table-fixed mt-1 mb-4">
                <tbody>
                    <tr>
                        <td style="width: 200px">Endereço:</td>
                        <td>{{ $client->street }}, {{ $client->number }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">Bairro:</td>
                        <td>{{ $client->neighborhood }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">CEP:</td>
                        <td>{{ $client->zipcode }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">Municipio:</td>
                        <td>{{ $client->city }}, {{ $client->state }}</td>
                    </tr>
                </tbody>
            </table>

            <p>Responsável:</p>
            <table class="table-fixed mt-1 mb-4">
                <tbody>
                    <tr>
                        <td style="width: 200px">Nome:</td>
                        <td>{{ $client->respName }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">Telefone/Celular:</td>
                        <td>{{ $client->respPhone }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px">Email:</td>
                        <td>{{ $client->respEmail }}</td>
                    </tr>
                </tbody>
            </table>

            <p>Observações:</p>
            <p>{{ $client->notes }}</p>
        </div>

    </div>
    <div class="min-w-0 p-4 text-white bg-green-600 rounded-lg shadow-xs">
        <h4 class="mb-4 font-semibold">
            Localização
        </h4>
        <div id="mapid"></div>
        <p class="mt-3">
            Endereço: {{ $client->street }}, {{ $client->number }} - {{ $client->neighborhood }} - CEP: {{ $client->zipcode }} - {{ $client->city }} {{ $client->state }}
        </p>
        <p>Ponto de Referencia: {{ $client->referencePoint }}</p>
        <p>Complemento: {{ $client->complement }}</p>
    </div>
</div>

<!-- Data Table -->
<h2 class="mt-8 mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
    <span>Serviços Realizados</span>
</h2>

{{-- <div>
    <a href="{{ route('services.newByClient', $client->id) }}" class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
        Cadastrar um Novo Serviço
    </a>
</div> --}}

<div class="w-full overflow-hidden rounded-lg shadow-xs mb-8 ">
    <div class="w-full overflow-hidden">
        <table class="w-full whitespace-no-wrap" id="ServicesClientsTable">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Tipo de Serviço</th>
                    <th class="px-4 py-3">Descrição</th>
                    <th class="px-4 py-3">Produtos Utilizados</th>
                    <th class="px-4 py-3">Executado em</th>
                    <th class="px-4 py-3">Vence em</th>
                    <th class="px-4 py-3">Valor</th>
                    <th class="px-4 py-3">Pagamento</th>
                    <th class="px-4 py-3">Atualizado</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto">
                @foreach ($services as $service)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">
                        {{ $service->documents->name }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if ($service->description)
                            {{ $service->description }}
                        @else
                            {{ "-" }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if ($service->hasProducts())
                            {{ $service->productsNames() }}
                        @else
                            {{ "Nenhum produto" }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm" data-sort='YYYYMMDD'>
                        {{ $service->dateExecution->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm" data-sort='YYYYMMDD'>
                        @if ($service->dateValidity->lte(now()))
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                {{ $service->dateValidity->format('d/m/Y') }} (Vencido)
                            </span>
                        @else
                            {{ $service->dateValidity->format('d/m/Y') }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        R$ {{ number_format($service->value, 2, ",", ".") }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if ($service->payStatus())
                            <a href="{{ route('payments.doc', ['paymentId' => $service->payments_id]) }}" target="_blank" class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                Pago
                                <svg class="h-4 w-4" style="display: inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @else
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                Não pago
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $service->updated_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center  text-sm">
                            <a href="{{ route('docs.services', ['serviceId' => $service->id]) }}" target="_blank"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Edit">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('services.edit', ['service' => $service->id]) }}"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20">
                                    <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                            </a>
                            <a href="#" data-id="{{$service->id}}" data-name="{{$service->documents->name}}"
                                class="confirmDeleteButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd">
                                    </path>
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

    <div id="paymentsModal"
    class="w-full px-6 py-4 overflow-hidden rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl modal"
    role="dialog">

    <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
    <header class="flex justify-end">
        <a href="#" rel="modal:close"
            class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
            aria-label="close"
            >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                <path
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </a>
    </header>

    <!-- Modal body -->
    <div class="mt-4 mb-6">
        <!-- Modal title -->
        <p class="mb-2 text-xl font-semibold text-gray-700 dark:text-gray-300">
            Confirmação de Pagamento
        </p>
        <!-- Modal description -->
        {{-- <p class="text-sm text-gray-700 dark:text-gray-400">
            teste
        </p> --}}

        <form id="paymentModal">
            @csrf
            <input type="hidden" name="clients_id" value={{ $client->id }}>

            <label class="block text-2xl mt-0">
                <span class="text-gray-700 text-sm dark:text-gray-400">Método de Pagamento *</span>
                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green"
                        name="paymentMethod" required>
                    <option value="money">Á vista (dinheiro)</option>
                    <option value="pix">Pix</option>
                    <option value="boleto">Boleto</option>
                    <option value="ted">Transferencia Bancaria</option>
                    <option value="credit">Cartão de Crédito</option>
                    <option value="debit">Cartão de Débito</option>
                    <option value="other">Outros</option>
                </select>
            </label>

            <label class="block text-2xl mt-2">
                <span class="text-gray-700 text-sm dark:text-gray-400">Serviços correspondentes *</span>
                <select class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                        name="paymentServices[]" multiple="multiple" id="paymentServices">
                    @foreach ($servicesPayment as $service)
                        <option service-value="{{ $service->value }}" value="{{ $service->id }}">{{ $service->documents->name }} - {{ $service->dateExecution->format('d/m/Y') }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block text-2xl mt-2">
                <span class="text-gray-700 text-sm dark:text-gray-400">Data do Pagamento *</span>
                <input
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    placeholder="Data do pagamento realizado" name="paymentDate" type="date"
                    required
                    value="{{ date("Y-m-d") }}"/>
            </label>

            <label class="block text-2xl mt-2">
                <span class="text-gray-700 text-sm dark:text-gray-400">Valor Total *</span>
                <div class="relative text-gray-500 focus-within:text-green-600 dark:focus-within:text-green-400">
                    <input
                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                        placeholder="Valor total incluindo descontos" id="totalValue" name="totalValue"
                        required
                        maxlength="13"
                        value="{{ old('totalValue') }}"
                    />
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

            <label class="block text-2xl mt-2" style="margin-bottom: 100px">
                <span class="text-gray-700 text-sm dark:text-gray-400">Descrição do Pagamento</span>
                <input
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    placeholder="Descrição do Pagamento" name="paymentDescription"
                    value="" />
            </label>

            <div>
                <a href="#" id="paymentModalBtn"
                  class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                  Gerar recibo
                </a>
                <a href="#"  rel="modal:close"
                  class="ml-3 mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                  Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<!-- End of modal backdrop -->

@endsection

@section('scripts')

<!-- Moment.js: -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!-- Brazilian locale file for moment.js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>

<!-- Ultimate date sorting plug-in-->
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<script type="text/javascript" src="{{ asset('js/plugins/jquery.maskMoney.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {

        moment.locale('pt-br');
        $.fn.dataTable.moment('DD/MM/YYYY H:mm');

        $('#totalValue').focusin(function (e) {
            $('.money-currency-icon').addClass('money-currency-icon-active');
        });

        $('#totalValue').focusout(function (e) {
            $('.money-currency-icon').removeClass('money-currency-icon-active');
        });

        $("#totalValue").maskMoney({
            allowNegative: false,
            thousands:'.',
            decimal:',',
            affixesStay: false
        })

        $('#paymentServices').select2({
            width: '100%',

            "language": {
                "noResults": function(){
                    return "Nenhum serviço sem pagamento encontrado! 🤔";
                }
            },
        });

        $('#paymentServices').on('change.select2', function (e) {
            var services = $('#paymentServices').select2('data');
            var values = [];

            services.forEach(service => {
                let value = $(service.element).attr('service-value');

                values.push(value);
            });

            var valuesNumbers = values.map(Number);
            var totalValueCalculated = valuesNumbers.reduce((a, b) => a + b, 0);
            var totalValueBRL = totalValueCalculated.toLocaleString('pt-br', {minimumFractionDigits: 2});;

            $('#totalValue').val('');

            if (totalValueBRL != 0) {
                $('#totalValue').val(totalValueBRL);
            }
        });

        // Modal de pagamento
        $("#paymentServices > option").prop("selected","selected");
        $("#paymentServices").trigger("change");

        // Processa o Modal de pagamento
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#paymentModalBtn').click(function (e) {
            e.preventDefault();

            var data = $('form#paymentModal').serializeArray();

            $.ajax({
                type: "POST",
                url: "{{ route('payment.generate') }}",
                data: data,
                dataType: "json",
                success: function (response) {
                    $.modal.close();

                    Swal.fire(
                    {
                        title: 'Sucesso!',
                        text: 'Pagamento gerado com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'Visualizar recibo',
                        confirmButtonColor: '#37a169',
                        showDenyButton: true,
                        denyButtonText: 'Voltar',
                        denyButtonColor: '#2d3748',
                        allowOutsideClick: false,
                    }
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.open(response.url, '_blank');
                        }

                        location.reload();
                    })
                },
                error: function (xhr, status, error) {
                    if (xhr.status == 422) {
                        Swal.fire({
                            title: 'Oops algo deu errado!',
                            text: 'Alguns campos requeridos não foram preenchidos ou validados corretamente!',
                            icon: 'error',
                            confirmButtonText: 'Ok!',
                            confirmButtonColor: '#2d3748'
                        });
                        return
                    };

                    Swal.fire({
                        title: 'Oops algo deu errado!',
                        text: 'Não foi possivel realizar essa pagamento nesse momento!' + '<br/>' +
                        'Status: ' + xhr.statusText,
                        icon: 'error',
                        confirmButtonText: 'Ok!',
                        confirmButtonColor: '#2d3748'
                    });
                }
            });
        });

        // Confirmation Modal com SweetAlert e deleção com AJAX!
        $(document).on('click', '.confirmDeleteButton', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Você tem certaza?',
                text: "Você tem certeza que deseja remover o serviço de: "+ name + " ?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: '#2d3748',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "/services/" + id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                            "_method": "DELETE",
                        },
                        success: function(result) {
                            Swal.fire(
                            {
                                title: 'Sucesso!',
                                text: 'Serviço foi removido com exito!',
                                icon: 'success',
                                confirmButtonColor: '#37a169',
                                allowOutsideClick: false,
                            }
                            ).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            })
        });

        // Datatable
        let table = $('#ServicesClientsTable').DataTable({
            autoWidth: false,
            responsive: false,

            dom: '<"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9 dark:text-gray-400" <"#tableTitle.flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-gray-300"> <"#dtServicesSearch.flex items-center justify-center col-span-3"> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"B>>    <"w-full overflow-hidden rounded-lg shadow-xs"<"w-full overflow-hidden"<"bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto"t>><"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"<"flex items-center col-span-3"i><"flex items-center justify-center col-span-3"l> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"p>>>',

            buttons: [
                {
                    text: '+ Novo Serviço',
                    action: function ( e, dt, node, config ) {
                        window.location.href = "{{ route('services.newByClient', $client->id) }}";
                    }
                },
                {
                    text: 'Emitir Recibo',
                    action: function ( e, dt, node, config ) {
                        $("#paymentsModal").modal({
                            escapeClose: false,
                            clickClose: false,
                            fadeDuration: 500,
                            fadeDelay: 0.10
                        });
                    }
                },
                'excel',
                'pdf',
            ],

            "order": [[ 7, "desc" ]],

            "lengthMenu": [[8, 10, 25, 50, -1], [8, 10, 25, 50, "Todos"]],

            "pagingType": "simple_numbers",

            "language": {
                "lengthMenu": "Mostrando _MENU_ por página",
                "zeroRecords": "Desculpe! Não encontramos nada! 🤔",
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

        let tableName = 'Serviços'
        $("#tableTitle").append('<p>'+tableName+'</p>');

        $("#dtServicesSearch").append('<div class="relative w-full max-w-xl mr-6 focus-within:text-green-500">' +
                        '<div class="absolute inset-y-0 flex items-center pl-2 text-green-500">' +
                            '<svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">' +
                                '<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd">' +
                                '</path>' +
                            '</svg>' +
                        '</div>' +
                        '<input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-green-600 dark:bg-gray-700 dark:text-gray-400 focus:placeholder-gray-500 focus:bg-white focus:border-green-500 focus:outline-none focus:shadow-outline-green form-input" type="text" id="dtServicesSearchInput" placeholder="Pesquisar por Serviços" aria-label="Search">' +
                    '</div>');

        $('#dtServicesSearchInput').keyup(function(){
            table.search($(this).val()).draw() ;
        })

        $('#headerSearch').keyup(function(){
            table.search($(this).val()).draw() ;
        })

        // Maps
        var mymap = L.map('mapid').setView([0,0], 1);
        var marker = L.marker([0,0]).addTo(mymap);

        disableMapUserControl(mymap, 'mapid');

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data NicollasDev &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> self-hosted contributors ',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
	    }).addTo(mymap);

        // search handler
        function searchLocation(keyword) {
            if(keyword) {
                // request to nominatim api
                fetch(`https://nominatim.openstreetmap.org/?addressdetails=1&q=${keyword}&format=json&limit=1`)
                .then((response) => {
                    return response.json()
                }).then(json => {
                // get response data from nominatim
                console.log("json", json)
                    if(json.length > 0) return renderResults(json)
                    else console.error("[MapGeocoderAPI]: Localização não encontrada!")
                })
            }
        }

        // render results
        function renderResults(result) {
            result.map((n) => {
                return setLocation(n.lat, n.lon);
            })
        }

        // set location from search result
        function setLocation(lat, lon) {
            // set map focus
            mymap.setView(new L.LatLng(lat, lon), 15)

            // regenerate marker position
            marker.setLatLng([lat, lon])
        }

        function disableMapUserControl(map, mapid) {
            map.dragging.disable();
            map.touchZoom.disable();
            map.doubleClickZoom.disable();
            map.scrollWheelZoom.disable();
            map.boxZoom.disable();
            map.keyboard.disable();
            if (map.tap) map.tap.disable();
            document.getElementById(mapid).style.cursor='default';
        }

        let mapLocation = $("#mapCords").val();
        console.info('Pesquisando localização...');
        searchLocation(mapLocation);
        console.info('Localização concluida...');
    });

</script>
@endsection
