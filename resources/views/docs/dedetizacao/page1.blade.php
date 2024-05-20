<div class="header-title">
    <h3 class="font-weight-bold">CERTIFICADO DESINSETIZAÇÃO</h3>
</div>

<div class="row justify-content-between ml-2 mb-4">
    <div class="col-xs-6">
        <p class="fs-18">
            <strong>Execução do Serviço: {{ $documentData['dataexecucao'] }}</strong> <br/>
            <strong>Empresa: </strong> {{ $documentData['socialname'] }} <br/>
            <strong>Endereço: </strong> {{ $documentData['logradouro'] }}, {{ $documentData['numero'] }} <br/>
            <strong>Bairro: </strong> {{ $documentData['bairro'] }}
        </p>
    </div>
    <div class="col-xs-6">
        <p class="fs-18">
            <strong>Validade: {{ $documentData['datavalidade'] }}</strong> <br/>
            <strong>{{ $documentData['labeldn'] }}: </strong> {{ $documentData['dn'] }} <br/>
            <strong>CEP: </strong> {{ $documentData['cep'] }} <br/>
            <strong>Municipio: </strong> {{ $documentData['municipio'] }}
        </p>
    </div>
</div>

@include('docs.products-table')

<p class="mb-3">
    <strong>Sintomas de Intoxicação por Organofosforado:</strong> fraqueza, dor de cabeça, opressão no peito, visão turva, pupilas não reativas, salivação abundante, suores, náuseas, vômitos, diarreia e cólicas abdominais.
</p>

<p class="mb-3">
    <strong>Antídoto e Tratamento:</strong> Os Organofosforado têm ação tóxica pela inibição da Colinesterase. OXIMAS (contrathion) e PAM são antídotos de emergência e tratamento sintomático em casos de intoxicação leve. NUNCA aplique sulfato de atropina antes do aparecimento dos sintomas. Contraindicações: Morfina Aminofilina e Tranquilizantes.
</p>

<p class="mb-3">
    <strong>Sintomas de Intoxicação por Cypermethrin:</strong> cefaleias, náuseas, vômitos, cólicas abdominais, pruridos, urticárias, irritação ocular, ardência e sensação de queimadura na face, podendo ocorrer dificuldade respiratória e tosse improdutiva em pessoas hipersensíveis. O tratamento em caso de intoxicação leve é feito com administração de anti-histéricos. 
</p>

<p class="mb-3">
    <strong>Intoxicação por Raticidas:</strong> aplicar Vitamina K 1 injetável. Obs.: os raticidas granulados possuem uma substância chamada BITREX que faz com que qualquer criança ou animal ao tentar ingerir a isca, rejeite-a pelo amargor que causa.
</p>

<p class="mb-3">
    <strong>Primeiros Socorros:</strong> Em caso de contato acidental com a pele e olhos, lavar com água limpa e abundante, em caso de aparecimento de dois ou mais sintomas de intoxicação, levar a pessoa imediatamente para local arejado e procurar auxílio médico o mais rápido possível. O Centro de Controle de Intoxicação da UNICAMP é o local do encaminhamento. O número do telefone é: (19) 3521-7555.
</p>

<section class="text-center">
    <h4 style="margin-bottom: .5em;">Araras, {{ $documentData['dataextenso'] }}</h4>

    @include('docs.qrcode')
</section>