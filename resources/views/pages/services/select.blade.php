@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = 'Novo Serviço';
    $servicesActivePage = true;
@endphp

@section('styles')
 <style>
    .select2-container--default .select2-selection--single {
        background-color: #24262d;
        border: none;
    }

    .select2-container--default.select2-container--open.select2-container--below .select2-selection--single, .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
        border-bottom-left-radius: 4px !important;
        border-bottom-right-radius: 4px !important;
    }

    html.theme-dark body span.select2-container.select2-container--default.select2-container--open span.select2-dropdown.select2-dropdown--below span.select2-search.select2-search--dropdown input.select2-search__field {
        background-color: #24262d;
        border: none;
        border-radius: .375rem;
        color: #999;
        padding-left: 2rem;
        padding-right: .5rem;
        line-height: 1.5;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        font-size: .875rem;
    }

    html.theme-dark body span.select2-container.select2-container--default.select2-container--open span.select2-dropdown.select2-dropdown--below span.select2-search.select2-search--dropdown {
        background-color: #121317;
    }

    html.theme-dark body span.select2-container.select2-container--default.select2-container--open span.select2-dropdown.select2-dropdown--below {
        background-color: #24262d;
        color: #999;
    }

    html.theme-dark body span.select2-container.select2-container--default.select2-container--open span.select2-dropdown.select2-dropdown--below {
        border: none !important;
    }

    html.theme-dark body span.select2-container.select2-container--default.select2-container--open span.select2-dropdown.select2-dropdown--below span.select2-results ul#select2-searchClients-results.select2-results__options li.select2-results__option.select2-results__option--selectable.select2-results__option--highlighted {
        background-color: #38a169;
    }

 </style>
@endsection

@section('content')

<div class="text-center">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <span>Selecione um Cliente</span>
    </h2>

    <div class="flex justify-center flex-1 text-green-600">
        <form action="" style="width: 75%">
            <select
                id="searchClients"
                name="clientId"
                class="pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-input"
                type="text" placeholder="Pesquisar por Clientes" aria-label="Busca por cliente" >
            </select>
            <button type="button" id="continueButton"
            class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                Continuar
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')

<script>

$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $("#searchClients").select2({
        width: '100%',
        ajax: {
            url: "{{ route('clients.getClients') }}",
            type: "post",
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
        placeholder: 'Selecione um Cliente',
        multiple: false,
    });

    $('#continueButton').click(function (e) {
        e.preventDefault();

        var id = $('#searchClients').val();

        console.log('Cliente ID: ' + id);

        window.location.href = "/novoservico/" + id;
    });

});



</script>

@endsection
