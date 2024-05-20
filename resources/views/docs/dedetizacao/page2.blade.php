<div class="header-title">
    <h3 class="font-weight-bold">LAUDO DESINSETIZAÇÃO</h3>
</div>

<section class="text-center fs-18">
    <div class="mb-45">
        <h4 class="h4-custom">OBJETIVO:</h4>
        <p>Prestação de Serviços de Controle Integrado de Pragas (CIP), na empresa: {{ $documentData['socialname'] }}</p>
    </div>

    <div class="mb-45">
        <h4 class="h4-custom">IDENTIFICAÇÃO DO LOCAL TRATADO:</h4>
        <p><strong>Empresa:</strong> {{ $documentData['socialname'] }}</p>
        <p><strong>Endereço:</strong> {{ $documentData['logradouro'] }}, {{ $documentData['numero'] }}</p>
        <p><strong>Bairro:</strong> {{ $documentData['bairro'] }}</p>
        <p><strong>{{ $documentData['labeldn'] }}:</strong> {{ $documentData['dn'] }}</p>
    </div>

    <div class="mb-45">
        <h4 class="h4-custom">IDENTIFICAÇÃO DA EMPRESA PRESTADORA DE SERVIÇO:</h4>
        <p><strong>Empresa:</strong> C.F.P. DOS SANTOS - ME</p>
        <p><strong>Endereço:</strong> Rua Santo Siviero, 855</p>
        <p><strong>Bairro:</strong> Jd. São Pedro</p>
        <p><strong>Cidade:</strong> Araras/SP</p>
        <p><strong>CNPJ:</strong> 11.675.647/0001-30</p>
    </div>

    <div class="mb-45">
        <h4 class="h4-custom">LICENÇA DE FUNCIONAMENTO NA VIGILÂNCIA SANITÁRIA:</h4>
        <p>Nº. CEVS 350330701-812-000003-1-0</p>
    </div>
    
    <div class="mb-45">
        <h4 class="h4-custom">RESPONSÁVEL TÉCNICO:</h4>
        <p>Cíntia F. Petrelli dos Santos</p>
        <p>Bióloga - CRBio: 61204/01D</p>
    </div>

    <div class="mb-45">
        <h4 class="h4-custom">PRODUTOS UTILIZADOS:</h4>
        @foreach ( $documentData['products'] as $product)
            <p>{{ $product['defensive'] }} - Nº. de Registro no Ministério da Saúde: {{ $product['registry'] }}</p>  
        @endforeach
    </div>

    <div class="mb-45">
        <h4 class="h4-custom">TÉCNICAS UTILIZADAS:</h4>
        <p>Pulverizador costal, elétrica</p>
    </div>
</section>