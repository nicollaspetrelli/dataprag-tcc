@extends('certificates.layout')

@section('content')
    <div class="flex h-screen overflow-y-scroll">
        <div class="m-auto bg-white px-6 py-6 rounded-lg">
            <div class="text-center">
                <svg class="svg-icon" style="width: 150px; margin: 0 auto;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M1024 512c0-282.763636-229.236364-512-512-512C229.236364 0 0 229.236364 0 512c0 282.763636 229.236364 512 512 512C794.763636 1024 1024 794.763636 1024 512zM281.6 709.492364 479.092364 512 281.6 314.507636 314.507636 281.6 512 479.092364l197.492364-197.492364 32.907636 32.907636L544.907636 512l197.492364 197.492364-32.907636 32.907636L512 544.907636 314.507636 742.4 281.6 709.492364z" fill="#f35051" /></svg>
            </div>

            <section class="my-6">
                <h1 class="text-center text-3xl font-bold">Certificado inválido!</h1>
                <p class="text-center text-lg">
                    O certificado que você está tentando acessar é inválido.
                </p>
            </section>

            <p class="text-center text-lg">
                Caso você esteja tentando consultar um certificado válido expedido pela empresa Ambientalis, por favor, entre em contato.
            </p>

            <div class="text-center my-6">
                <img class="mx-auto mb-3" src="{{ asset('img/Ambientalis_Logo.png') }}" alt="Logo" width="150rem">
                <p class="text-center text-xl font-bold">Dedetizadora Ambientalis:</p>
                <p class="text-center text-xl">
                    Whatsapp: (19) 3352-5152
                </p>
            </div>
        </div>
    </div>
@endsection
