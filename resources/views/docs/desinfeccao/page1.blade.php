
<div class="text-center my-5">
    <h4 class="h4-custom mb-5" style="font-size: 30px;">CERTIFICADO DE EXECUÇÃO<br/>DESINFECÇÃO DE CAIXA D ÁGUA</h4>
</div>

<section class="text-center wrap" style="padding: 4em 0; margin-bottom: 6em;">
    @include('docs.wrapimg-50')
    <div class="wrap-content">
        <div class="mb-4" style="line-height: 42px;">
            <p style="font-size: 24px;"><strong>REQUERENTE:</strong> {{ $documentData['socialname'] }}</p>
            <p style="font-size: 24px;"><strong>ENDEREÇO:</strong> {{ $documentData['logradouro'] }}, {{ $documentData['numero'] }}</p>
            <p style="font-size: 24px;"><strong>BAIRRO:</strong> {{ $documentData['logradouro'] }} <strong>CEP:</strong> {{ $documentData['cep'] }}</p>
            <p style="font-size: 24px;"><strong>MUNICIPIO:</strong> {{ $documentData['municipio'] }}</p>
            <p style="font-size: 24px;"><strong>{{ $documentData['labeldn'] }}:</strong> {{ $documentData['dn'] }}</p>
        </div>

        <div class="mb-2">
            <p style="font-size: 24px;">Data da execução:</p>
            <p style="font-size: 28px;" class="font-weight-bold">{{ $documentData['dataexecucao'] }}</p>
        </div>

        <div class="mb-3">
            <p style="font-size: 24px;">Data de validade:</p>
            <p style="font-size: 28px;" class="font-weight-bold">{{ $documentData['datavalidade'] }}</p>
        </div>
    </div>
</section>


<section class="text-center">
    <h3 style="margin-bottom: 1em;">Araras, {{ $documentData['dataextenso'] }}</h3>
    @include('docs.qrcode')
</section>