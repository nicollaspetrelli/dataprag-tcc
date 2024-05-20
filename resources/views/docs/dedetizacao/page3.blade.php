<section class="text-center wrap" style="margin: 5em 0; padding: 4em 0;">
    @include('docs.wrapimg')
    <div class="wrap-content">
        <div class="mb-4">
            <h4 class="h4-custom">VALIDADE DO CERTIFICADO:</h4>
            <p style="font-size: 22px;">{{ $documentData['valmesdigito'] }} ({{ $documentData['valmesextenso'] }}) meses.</p>
        </div>

        <div class="mb-4">
            <h4 class="h4-custom">EXECUÇÃO DO SERVIÇO:</h4>
            <p style="font-size: 22px;">Data: {{ $documentData['dataexecucao'] }}</p>
        </div>

        <div class="mb-4">
            <h4 class="h4-custom">DATA PARA PRÓXIMA EXECUÇÃO:</h4>
            <p style="font-size: 22px;">Data: {{ $documentData['datavalidade'] }}</p>
        </div>
    </div>
</section>

<section class="text-center">
    <h3 style="margin-bottom: 3em;">Araras, {{ $documentData['dataextenso'] }}</h3>

    @include('docs.qrcode')
</section>
