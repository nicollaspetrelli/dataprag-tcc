@extends('certificates.layout')

@section('content')
    <div class="flex h-screen overflow-y-scroll">
        <div class="m-auto bg-white px-6 py-6 rounded-lg">
            <div class="text-center">

                @if ($service->expired == 3)
                    <svg class="svg-icon" style="width: 150px; margin: 0 auto; vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M1001.661867 796.544c48.896 84.906667 7.68 157.013333-87.552 157.013333H110.781867c-97.834667 0-139.050667-69.504-90.112-157.013333l401.664-666.88c48.896-87.552 128.725333-87.552 177.664 0l401.664 666.88zM479.165867 296.533333v341.333334a32 32 0 1 0 64 0v-341.333334a32 32 0 1 0-64 0z m0 469.333334v42.666666a32 32 0 1 0 64 0v-42.666666a32 32 0 1 0-64 0z" fill="#FAAD14" /></svg>
                @else
                    <svg class="svg-icon" style="width: 150px; margin: 0 auto; vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1"><path d="M512 981.333333C252.8 981.333333 42.666667 771.2 42.666667 512S252.8 42.666667 512 42.666667s469.333333 210.133333 469.333333 469.333333-210.133333 469.333333-469.333333 469.333333z m-50.432-326.101333L310.613333 504.32a32 32 0 0 0-45.226666 45.226667l174.72 174.762666a32.341333 32.341333 0 0 0 0.341333 0.341334l0.256 0.213333a32 32 0 0 0 50.048-6.144l337.450667-379.605333a32 32 0 1 0-47.872-42.496l-318.762667 358.613333z" fill="#52C41A"/></svg>
                @endif

            </div>

            <section class="my-6">
                <h1 class="text-center text-3xl font-bold">Certificado válido!</h1>
                <h2 class="text-center text-2xl">Status: 

                    @if ($service->expired == 3)
                        <span class="text-red-500 font-bold">Expirado</span>
                    @else
                        <span class="text-green-500 font-bold">Válido / Em prazo</span>
                    @endif
                </h2>
            </section>

            <section class="mb-6">
                <p class="text-center text-xl font-bold">VALIDADE DO CERTIFICADO:</p>
                <p class="text-center text-xl">{{ $service->dateValidity->diffInMonths($service->dateExecution) }} meses</p>
                <p class="text-center text-xl font-bold">EXECUÇÃO DO SERVIÇO:</p>
                <p class="text-center text-xl">{{ $service->dateExecution->format('d/m/Y') }}</p>
                <p class="text-center text-xl font-bold">DATA PARA PRÓXIMA EXECUÇÃO:</p>
                <p class="text-center text-xl ">{{ $service->dateValidity->format('d/m/Y') }}</p>
            </section>

            <section class="mb-6">
                <p class="text-center text-xl font-bold">CLIENTE:</p>
                <p class="text-center text-xl">
                    {{ $client->companyName }} <br/>

                    @if ($client->type == 0)
                        {{ $client->documentNumber }} <br/>
                    @endif

                    {{ $client->street }} -
                    {{ $client->number }} <br/>
                    {{ $client->city }} - {{ $client->state }} <br/>
                    {{ $client->zipcode }}
                </p>
            </section>

            <section class="mb-6">
                <p class="text-center text-xl font-bold">SERVIÇO:</p>
                <p class="text-center text-xl">
                    {{ $service->documents->name }} <br/>
                </p>
            </section>

            <div class="text-center my-6">
                <img class="mx-auto mb-3" src="{{ asset('img/Ambientalis_Logo.png') }}" alt="Logo" width="150rem">
                <p class="text-center text-xl font-bold">Biologa Responsável:</p>
                <p class="text-center text-xl">
                    Cintia F. Petrelli dos Santos <br/> CRbio - 61204/01D
                </p>
            </div>

            <p class="text-center text-md font-bold">Assinatura eletronica obtida em:</p>
            <p class="text-center text-md">{{$service->dateExecution->format('d/m/Y')}}</p>

            <p class="text-center text-md font-bold">Assinatura de autenticação:</p>
            <p class="text-center text-md">{{$service->uuid}}</p>
        </div>
    </div>
@endsection
