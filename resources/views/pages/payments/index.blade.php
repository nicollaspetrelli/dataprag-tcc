@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = 'Pagamentos';
    $paymentsActivePage = true;
@endphp

@section('content')

@section('styles')

@endsection

<!-- Data Table -->
<h2 class="mt-8 mb-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
    <span>Pagamentos e Recibos</span>
</h2>

{{-- <div class="w-full overflow-hidden dark:bg-gray-800 rounded-lg grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9 dark:text-gray-400">
    <div class="flex items-center col-span-5">Teste1</div>
    <div class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end justify-end">Teste2</div>
</div> --}}

<div class="w-full overflow-hidden rounded-lg shadow-xs my-8 ">
    <div class="w-full overflow-hidden">
        <table class="w-full whitespace-no-wrap" id="paymentsTable">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Serviços</th>
                    <th class="px-4 py-3">Descrição</th>
                    <th class="px-4 py-3">Méotodo de pagamento</th>
                    <th class="px-4 py-3">Valor Total</th>
                    <th class="px-4 py-3">Data</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto">
                @foreach ($payments as $payment)

                @php
                    if (!$payment->clients) {
                        continue;
                    }
                    
                    if ($payment->services->isEmpty()) {
                        continue;
                    }
                @endphp

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center text-sm">
                            <div>
                                <p class="font-semibold">{{ $payment->clients->companyName }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ ($payment->clients->identificationName) ? $payment->clients->identificationName : $payment->clients->companyName }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @php

                        $serviceListName = [];

                        foreach ($payment->services as $servicePay) {
                            $serviceListName[] = $servicePay->documents->name;
                        }

                        echo implode(', ', $serviceListName);
                            
                        @endphp
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $payment->description }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{  $payment->label() }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        R$ {{ number_format($payment->totalValue, 2, "," , ".") }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $payment->created_at->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <a href="{{ route('payments.doc', ['paymentId' => $payment->id]) }}"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Print">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href=""
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20">
                                    <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                            </a>
                            <a href="#" data-id="{{ $payment->id }}" data-name="{{ $payment->clients->companyName }}"
                                class="confirmDeleteButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            {{-- Form invisivel para deleção do cliente --}}
                            <form id="form-delete" style="display: none;" action="" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {

        // Confirmation Modal com SweetAlert e deleção com AJAX!
        $(document).on('click', '.confirmDeleteButton', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Você tem certaza?',
                text: "Você tem certeza que deseja remover o pagamento do cliente: "+ name + " ?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: '#d33',
                cancelButtonColor: '#2d3748',
                confirmButtonText: 'Sim, deletar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "/payment/" + id,
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
                                text: 'Pagamento foi removido com exito!',
                                icon: 'success',
                                confirmButtonColor: '#37a169',
                                cancelButtonColor: '#2d3748',
                                allowOutsideClick: false,
                            }
                            ).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(result) {
                            Swal.fire(
                            {
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao remover o pagamento!',
                                icon: 'error',
                                confirmButtonColor: '#37a169',
                                cancelButtonColor: '#2d3748',
                                allowOutsideClick: false,
                            }).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            })
        });

        let table = $('#paymentsTable').DataTable({
            autoWidth: false,
            responsive: false,

            // Apply Styles

            //<"py-3"lfr>
            //<"w-full overflow-hidden rounded-lg shadow-xs"<"w-full overflow-hidden"<"bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto"t>> <"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"<"flex items-center col-span-5"i> <"flex col-span-4 mt-2 sm:mt-auto sm:justify-end"p>>>

            dom: '<"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9 dark:text-gray-400" <"#tableTitle.flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-gray-300"> <"#dtPaymentsSearch.flex items-center justify-center col-span-3"> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"B>>    <"w-full overflow-hidden rounded-lg shadow-xs"<"w-full overflow-hidden"<"bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto"t>><"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"<"flex items-center col-span-3"i><"flex items-center justify-center col-span-3"l> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"p>>>',

            buttons: [
                'excel', 'pdf',
            ],

            "order": [[ 5, "desc" ]],

            "lengthMenu": [[8, 10, 25, 50, -1], [8, 10, 25, 50, "Todos"]],

            "pagingType": "simple_numbers",

            "language": {
                "lengthMenu": "Mostrando _MENU_ por página",
                "zeroRecords": "Desculpe! Não encontramos nada! 🤔",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sem mais registros disponiveis",
                "search": "Pesquisar:",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                },
            }
        }).columns.adjust().responsive.recalc();

        let tableName = 'Pagamentos'
        $("#tableTitle").append('<p>'+tableName+'</p>');

        $("#dtPaymentsSearch").append('<div class="relative w-full max-w-xl mr-6 focus-within:text-green-500">' +
                        '<div class="absolute inset-y-0 flex items-center pl-2 text-green-500">' +
                            '<svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">' +
                                '<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd">' +
                                '</path>' +
                            '</svg>' +
                        '</div>' +
                        '<input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-green-600 dark:bg-gray-700 dark:text-gray-400 focus:placeholder-gray-500 focus:bg-white focus:border-green-500 focus:outline-none focus:shadow-outline-green form-input" type="text" id="dtPaymentsSearchInput" placeholder="Pesquisar por Pagamentos" aria-label="Search">' +
                    '</div>');

        $('#dtPaymentsSearchInput').keyup(function(){
            table.search($(this).val()).draw() ;
        })

        $('#headerSearch').keyup(function(){
            table.search($(this).val()).draw() ;
        })
    });


</script>
@endsection
