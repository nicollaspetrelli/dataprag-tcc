@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
$titlePage = 'Novo Produto';
$productsActivePage = true;
@endphp

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/plugins/select2-multiple-dark.css') }}">
@endsection

@section('content')

    <div class="px-4 py-3 mb-8 mt-4 bg-white rounded-lg shadow-md dark:bg-gray-800 loading">
        <h2 class="mb-1 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <span>Cadastro de Produto</span>
        </h2>
        <h4 class="mb-4 text-md font-semibold text-gray-600 dark:text-gray-300">
            Novo produto em estoque
        </h4>

        <form id="ProductForm" method="POST">
            @csrf
            @include('pages.products.form', ['isCreate' => true])
        </form>
    </div>

@endsection


@section('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.maskMoney.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $("#category").select2({
                width: '100%',
                //disable search
                minimumResultsForSearch: Infinity,
                ajax: {
                    url: "{{ route('documents.getAll') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                placeholder: 'Selecione a Categoria',
                multiple: true,
            });

            $("#price").maskMoney({
                allowNegative: false,
                thousands: '.',
                decimal: ',',
                affixesStay: false
            })

            $('#ProductForm').submit(function(e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                CreateProduct(data);
            });

            function CreateProduct(data) {
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: "{{ route('products.store') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function(xhr, settings) {
                        Swal.showLoading();
                        xhr.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr(
                            'content'));
                    },
                    success: function(data) {
                        // Clear all fields
                        $('.clearableInput').val('');

                        // Alert
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Produto cadastrado com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'Ok! voltar',
                            confirmButtonColor: '#37a169',
                            showCancelButton: true,
                            cancelButtonText: "Cadastrar mais",
                            cancelButtonColor: '#2d3748',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('products.index') }}";
                            }
                        })
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
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

                        Swal.fire(
                            'Oops algo deu errado!',
                            'Não foi possível cadastra esse produto!' + '<br/>' +
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
