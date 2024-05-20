@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
    $titlePage = 'Nova Declaração';
    $declarationActivePage = true;
@endphp

@section('content')

<h2 class="mt-8 text-3xl font-semibold text-gray-700 dark:text-gray-200">
    Nova Declaração
</h2>

<div class="px-4 py-3 mt-2 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">

    <h4 class="mb-2 text-md font-semibold text-gray-600 dark:text-gray-300">
        Gerar declaração estudal para Escolas e APM's
    </h4>

    <form action="{{ route('declarations.generate') }}" method="POST" id="declarationForm">
        @csrf

        <div class="grid md:grid-cols-1 gap-4 mt-4">
            <label class="block">
                <span class="text-gray-700 text-md dark:text-gray-400">Nome da APM</span>
                <input
                    type="text"
                    class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    required minlength="3" placeholder="Exemplo APM da E.E Dr Cesário Coimbra" 
                    id="companyName" name="companyName" />
           </label>

            <label class="block">
                <span class="text-gray-700 text-md dark:text-gray-400">Data</span>
                <input
                    type="date"
                    class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    required placeholder="Exemplo APM da E.E Dr Cesário Coimbra" 
                    id="date" name="date" value="{{ date('Y-m-d') }}" />
           </label>
        </div>

        <div>
            <button type="submit"
                class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                Gerar Declaração
            </button>
        </div>
    </form>
</div>

@endsection
