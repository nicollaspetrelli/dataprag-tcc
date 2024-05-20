@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
$titlePage = 'Produtos';
$productsActivePage = true;
@endphp

@section('content')

@section('styles')

@endsection

<!-- Data Table -->
<h2 class="mt-8 mb-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
    <span>Produtos</span>
</h2>

<div class="w-full overflow-hidden rounded-lg shadow-xs my-8 ">
    <div class="w-full overflow-hidden">
        <table class="w-full whitespace-no-wrap" id="productsTable">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Descrição</th>
                    <th class="px-4 py-3">Categorias</th>
                    <th class="px-4 py-3">Registro</th>
                    <th class="px-4 py-3">Quantidade</th>
                    <th class="px-4 py-3">Preço</th>
                    <th class="px-4 py-3">Alterado em</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto">
                @foreach ($products as $product)

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">
                        <div>
                            <p class="font-semibold">{{ $product->name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $product->manufacturer }}
                            </p>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $product->getDescription('chemicalGroup') . '-' . $product->getDescription('defensives') . '-' . $product->getDescription('activeIngredient') . '-' . $product->getDescription('toxicologicalClass') }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @foreach ($product->documentName as $documentName)
                            <span class="px-2 py-1 mx-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                {{ $documentName }}
                            </span>
                        @endforeach
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $product->registryNumber }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $product->quantity }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        R$ {{ $product->price }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $product->updated_at->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                            </a>
                            <a href="#" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                class="confirmDeleteButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
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

<!-- Moment.js: -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!-- Brazilian locale file for moment.js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>

<!-- Ultimate date sorting plug-in-->
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        moment.locale('pt-br');
        $.fn.dataTable.moment('DD/MM/YYYY H:mm');

        // Confirmation Modal com SweetAlert e deleção com AJAX!
        $(document).on('click', '.confirmDeleteButton', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Você tem certaza?',
                text: "Deseja remover o produto: " + name +
                    " ? Essa ação não pode ser desfeita!",
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
                        url: "/products/" + id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                            "_method": "DELETE",
                        },
                        success: function(result) {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: 'Produto foi removido com exito!',
                                icon: 'success',
                                confirmButtonColor: '#37a169',
                                cancelButtonColor: '#2d3748',
                                allowOutsideClick: false,
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(result) {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao remover o produto!',
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

        let table = $('#productsTable').DataTable({
            autoWidth: false,
            responsive: false,

            // Apply Styles

            //<"py-3"lfr>
            //<"w-full overflow-hidden rounded-lg shadow-xs"<"w-full overflow-hidden"<"bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto"t>> <"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"<"flex items-center col-span-5"i> <"flex col-span-4 mt-2 sm:mt-auto sm:justify-end"p>>>

            dom: '<"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9 dark:text-gray-400" <"#tableTitle.flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-gray-300"> <"#dtPaymentsSearch.flex items-center justify-center col-span-3"> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"B>>    <"w-full overflow-hidden rounded-lg shadow-xs"<"w-full overflow-hidden"<"bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 overflow-x-auto"t>><"grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"<"flex items-center col-span-3"i><"flex items-center justify-center col-span-3"l> <"flex col-span-3 mt-2 sm:mt-auto sm:justify-end"p>>>',

            buttons: [
                {
                    text: '+ Novo Produto',
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('products.create') }}";
                    }
                },
                'excel', 'pdf',
            ],

            "order": [
                [6, "desc"]
            ],

            "lengthMenu": [
                [8, 10, 25, 50, -1],
                [8, 10, 25, 50, "Todos"]
            ],

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

        let tableName = 'Produtos'
        $("#tableTitle").append('<p>' + tableName + '</p>');

        $("#dtPaymentsSearch").append(
            '<div class="relative w-full max-w-xl mr-6 focus-within:text-green-500">' +
            '<div class="absolute inset-y-0 flex items-center pl-2 text-green-500">' +
            '<svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">' +
            '<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd">' +
            '</path>' +
            '</svg>' +
            '</div>' +
            '<input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-green-600 dark:bg-gray-700 dark:text-gray-400 focus:placeholder-gray-500 focus:bg-white focus:border-green-500 focus:outline-none focus:shadow-outline-green form-input" type="text" id="dtPaymentsSearchInput" placeholder="Pesquisar por Produtos" aria-label="Search">' +
            '</div>');

        $('#dtPaymentsSearchInput').keyup(function() {
            table.search($(this).val()).draw();
        })

        $('#headerSearch').keyup(function() {
            table.search($(this).val()).draw();
        })
    });
</script>
@endsection
