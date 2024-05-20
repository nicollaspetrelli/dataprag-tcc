@extends('dash.layout')

{{-- Define Title of The Page --}}
@php
$titlePage = 'Novo Cliente';
$clientsActivePage = true;
@endphp

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loader.css') }}" />

    <style>
        .toggle-content {
            display: none;
            height: 0;
            opacity: 0;
            overflow: hidden;
            transition: height 350ms ease-in-out, opacity 750ms ease-in-out;
        }

        .toggle-content.is-visible {
            display: block;
            height: auto;
            opacity: 1;
        }

    </style>
@endsection

@section('content')

    <div class="flex flex-wrap mt-5" id="tabs-id">
        <div class="w-full">
            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="flex items-center justify-center text-sm font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal {{ $clientType == 0 ? 'text-white bg-green-600' : 'text-green-600 bg-white dark:bg-gray-800 dark:text-white' }}"
                        onclick="changeAtiveTab(event,'tab-legal')"
                        href="{{ route('clientes.create', ['client_type' => \App\Models\Clients::LEGAL]) }}">

                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        &nbsp; Pessoa Juridica
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="flex items-center justify-center text-sm font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal {{ $clientType == 1 ? 'text-white bg-green-600' : 'text-green-600 bg-white dark:bg-gray-800 dark:text-white' }}"
                        onclick="changeAtiveTab(event,'tab-individual')"
                        href="{{ route('clientes.create', ['client_type' => \App\Models\Clients::INDIVIDUAL]) }}">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        &nbsp; Pessoa Física
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a href="#"
                        class="flex items-center justify-center text-sm font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-green-600 bg-white dark:bg-gray-800 dark:text-white"
                        onclick="changeAtiveTab(event,'tab-subsidiary')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        &nbsp; Empresa Filial
                    </a>
                </li>
            </ul>
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6">
                <div class="flex-auto">
                    <div class="tab-content tab-space">
                        <div class="toggle-content {{ $clientType == 0 ? 'is-visible' : '' }} " id="tab-legal">
                            <div class="px-4 py-3 mb-8 mt-4 bg-white rounded-lg shadow-md dark:bg-gray-800 loading">
                                <h2 class="mb-1 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    <span>Cadastro de Cliente</span>
                                </h2>
                                <h4 class="mb-4 text-md font-semibold text-gray-600 dark:text-gray-300">
                                    Pessoa Juridica
                                </h4>

                                <form id="ClientCreateFormLegal" method="POST">
                                    @csrf
                                    @include('pages.clients.forms.client-legal')
                                </form>
                            </div>
                        </div>

                        <div class="toggle-content {{ $clientType == 1 ? 'is-visible' : '' }} " id="tab-individual">
                            <div class="px-4 py-3 mb-8 mt-4 bg-white rounded-lg shadow-md dark:bg-gray-800 loading">
                                <h2 class="mb-1 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    <span>Cadastro de Cliente</span>
                                </h2>
                                <h4 class="mb-4 text-md font-semibold text-gray-600 dark:text-gray-300">
                                    Pessoa Física
                                </h4>

                                <form id="ClientCreateFormIndividual" method="POST">
                                    @csrf
                                    @include('pages.clients.forms.client-individual')
                                </form>
                            </div>
                        </div>

                        <div class="toggle-content" id="tab-subsidiary">
                            <div
                                class="px-4 py-8 mb-8 mt-4 bg-white justify-self-center rounded-lg shadow-md dark:bg-gray-800 loading flex justify-center items-center">
                                <div class="text-gray-700 dark:text-gray-200 mr-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h2 class="mb-1 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    Funcionalidade em Construção...
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed top-0 left-0 z-50 w-screen h-screen flex items-center justify-center hidden"
        style="background: rgba(0, 0, 0, 0.3);" id="complete-loader">
        <div class="bg-white border py-2 px-5 rounded-lg flex items-center flex-col" id="loader">
            <div class="loader-dots block relative w-20 h-5 mt-2">
                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
            </div>
            <div waitv class="text-gray-500 text-lg font-light mt-2 text-center">
                Processando...
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
    {{-- <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/localization/messages_pt_BR.js') }}"></script> --}}

<script>
    $(document).ready(function() {
        // Mask
        $('#documentNumberCnpj').mask('00.000.000/0000-00');
        $('#documentNumberCPF').mask('000.000.000-00');
        $('.zipcode').mask('00.000-000');

        // Consultar CNPJ
        lastCnpj = 'none';
        $('#cnpjBtn').click(function(e) {
            e.preventDefault();

            var cnpj = $("#documentNumberCnpj").val() || ''

            if (cnpj == '') {
                console.info('[DataPrag] CNPJ is empty!')
                return
            }

            cnpj = cnpj.replace('/', '')
            cnpj = cnpj.replace('-', '')
            cnpj = cnpj.replace('.', '')
            cnpj = cnpj.replace('.', '')

            console.log(cnpj + ' é igual a: '+ lastCnpj)
            if (cnpj == lastCnpj) {
                console.info('[DataPrag] CNPJ has Prevent to search!')
                return
            }

            lastCnpj = cnpj;

            if (cnpj.length > 14) {
                console.warn('O CNPJ inserido tem mais de 14 numeros')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'O CNPJ digitado é invalido!',
                })
                return
            }

            $('#complete-loader').removeClass('hidden');
            buscaCNPJ(cnpj);
        });

        function buscaCNPJ(cnpj) {
            if (!cnpj) {
                console.warn('O CNPJ está em vázio!')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'O campo de CNPJ está vázio ou encontra-se inválido!',
                })
                $('#complete-loader').addClass('hidden');
                return
            }

            var url = 'https://www.receitaws.com.br/v1/cnpj/' + cnpj
            //var url = 'https://nicollas.dev/api/cnpj/' + cnpj

            $.ajax({
                url: url,
                dataType: "jsonp",
                type: "GET",
                jsonpCallback: 'processJSONPResponse',
                contentType: "application/json; charset=utf-8",

                beforeSend: function() {
                    console.time('Tempo da Consulta')
                    $('#complete-loader').removeClass('hidden');
                },
                complete: function() {
                    console.timeEnd('Tempo da Consulta')
                    $('#complete-loader').addClass('hidden');
                },

                success: function(result, status, xhr) {
                    if (result.status == 'OK') {
                        lastCnpj = cnpj;
                        preencheCampos(result);
                        console.info('Consulta CNPJ realizada com succeso!')
                    } else {
                        // result.stauts == 'ERROR'
                        console.warn('A requisição foi realizada porém a API retornou ERRO!')
                        console.debug(result); // Debug

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo deu errado! o CNPJ informado é inválido!',
                            //footer: '<a href="https://www.twitter.com/nicolalsdev">Por que estou tendo esse problema?</a>'
                        })

                        $('#complete-loader').addClass('hidden');
                    }
                },

                error: function(xhr, status, error) {
                    console.error('A requisição retornou o status code de ERRO!')
                    console.error("Result: " + status + " " + error + " " + xhr.status + " " + xhr
                        .statusText)

                    $('#complete-loader').addClass('hidden');

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo deu errado!',
                        footer: '<a href="https://www.twitter.com/nicolalsdev" target="_blank">Por que estou tendo esse problema?</a>'
                    })
                }
            });
        }

        // Search CEP function
        $('#btnCep').click(function(e) {
            e.preventDefault();

            var cep = $("#zipcodeForSearch").val() || ''

            cep = cep.replace('-', '')
            cep = cep.replace('.', '')

            console.log(cep);

            if (cep.length > 8) {
                console.warn('O CEP inserido tem mais de 8 numeros')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'O CEP digitado é invalido!',
                })
                return
            }

            $('#complete-loader').removeClass('hidden');
            buscaCep(cep);
        });

        function buscaCep(cep) {
            if (!cep) {
                console.warn('O CEP está em vázio!')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'O campo de CEP está vázio ou encontra-se inválido!',
                })
                $('#complete-loader').addClass('hidden');
                return
            }

            var url = 'https://viacep.com.br/ws/' + cep + '/json/'

            console.log(url)

            $.ajax({
                url: url,
                dataType: "json",
                type: "GET",
                contentType: "application/json; charset=utf-8",

                beforeSend: function() {
                    console.time('Tempo da Consulta CEP')
                    $('#complete-loader').removeClass('hidden');
                },
                complete: function() {
                    console.timeEnd('Tempo da Consulta CEP')
                    $('#complete-loader').addClass('hidden');
                },

                success: function(result, status, xhr) {
                    preencheCamposEndereco(result);
                    console.info('Consulta CEP realizada com succeso!')
                },
                error: function(xhr, status, error) {
                    console.error('A requisição retornou o status code de ERRO!')
                    console.error("Result: " + status + " " + error + " " + xhr.status + " " + xhr
                        .statusText)

                    $('#complete-loader').addClass('hidden');

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo deu errado!',
                        footer: '<a href="https://www.twitter.com/nicolalsdev" target="_blank">Por que estou tendo esse problema?</a>'
                    })
                }
            });
        }

        function preencheCamposEndereco(dados) {
            console.log(dados)

            $('#street').val(dados.logradouro)
            $('#number').val(dados.numero)
            $('#referencePoint').val(dados.complemento)
            $('#neighborhood').val(dados.bairro)
            $('#zipcode').val(dados.cep)
            $('#city').val(dados.localidade)

            let state = dados.uf
            $('#state').val(state.toUpperCase())
        }

        function preencheCampos(dados) {
            $('#companyNameCnpj').val(capitalize(dados.nome))

            if (dados.fantasia == '') {
                $('#identificationNameCnpj').val(capitalize(dados.nome))
                $('#fantasyNameCnpj').val(capitalize(dados.nome))
            } else {
                $('#identificationNameCnpj').val(capitalize(dados.fantasia))
                $('#fantasyNameCnpj').val(capitalize(dados.fantasia))
            }

            $('#streetCnpj').val(capitalize(dados.logradouro))
            $('#numberCnpj').val(capitalize(dados.numero))
            $('#referencePointCnpj').val(capitalize(dados.complemento))
            $('#neighborhoodCnpj').val(capitalize(dados.bairro))
            $('#zipcodeCnpj').val(capitalize(dados.cep))
            $('#cityCnpj').val(capitalize(dados.municipio))

            let state = dados.uf
            $('#stateCnpj').val(state.toUpperCase())
        }

        function capitalize(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

    });

    // Clear Form function
    $('.clearFormBtn').click(function(e) {
        e.preventDefault();
        lastCnpj = 'none';
        $('.clearableInput').val('');
    });

    // Button Back to Page
    $('.backToClientsBtn').click(function (e) { 
        e.preventDefault();
        window.location.href = "{{ route('clientes.index') }}";
    });

    // Tabs
    function changeAtiveTab(event, tabID) {
        let element = event.target;
        while (element.nodeName !== "A") {
            element = element.parentNode;
        }
        ulElement = element.parentNode.parentNode;
        aElements = ulElement.querySelectorAll("li > a");
        tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");
        for (let i = 0; i < aElements.length; i++) {
            aElements[i].classList.remove("text-white");
            aElements[i].classList.remove("bg-green-600");
            aElements[i].classList.add("text-green-600");
            aElements[i].classList.add("bg-white");
            aElements[i].classList.add("dark:bg-gray-800");
            aElements[i].classList.add("dark:text-white");
            tabContents[i].classList.remove("is-visible");
        }
        element.classList.remove("text-green-600");
        element.classList.remove("bg-white");
        element.classList.remove("dark:bg-gray-800");
        element.classList.remove("dark:text-white");
        element.classList.add("text-white");
        element.classList.add("bg-green-600");
        document.getElementById(tabID).classList.add("is-visible");
    }

    // Send Forms
    $('#ClientCreateFormLegal').submit(function (e) { 
        e.preventDefault();
        var data = $(this).serializeArray();
        sendDataToCreateClientViaAjax(data);
    });

    $('#ClientCreateFormIndividual').submit(function (e) { 
        e.preventDefault();
        var data = $(this).serializeArray();
        sendDataToCreateClientViaAjax(data);
    });

    function sendDataToCreateClientViaAjax(data) {
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: "{{ route('clientes.store') }}",
            data: data,
            // processData: false,
            // contentType: false,
            // async: true,
            dataType: 'json',
            beforeSend: function (xhr, settings) {
                Swal.showLoading();
                xhr.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                // Clear all fields
                lastCnpj = 'none';
                $('.clearableInput').val('');    

                // Alert
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Cliente cadastrado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'Ok! voltar',
                    confirmButtonColor: '#37a169',
                    showCancelButton: true,
                    cancelButtonText: "Cadastrar mais",
                    cancelButtonColor: '#2d3748',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('clientes.index') }}";
                    }
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

                Swal.fire(
                    'Oops algo deu errado!',
                    'Não foi possível cadastra esse cliente!' + '<br/>' +
                    'Status: ' + xhr.statusText, 
                    'error'
                );
            },
            complete: function() {
                Swal.hideLoading();
            }
        });
    }
</script>
@endsection
