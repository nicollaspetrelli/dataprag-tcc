<section class="text-center mb-5 mt-4">
    <h4 class="h4-custom mb-45">PROCEDIMENTO:</h4>

    <table class="table-striped" style="font-size: 19px">
        <tbody>
            <tr>
                <td class="font-weight-bold px-3">1</td>
                <td>Fechamento do registro da entrada de água do reservatório.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">2</td>
                <td>Escoamento do reservatório, deixando em torno de 20 cm de água para ser utilizado na limpeza, tampando a saída para evitar a obstrução do cano.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">3</td>
                <td>Laterais e o fundo limpo com pano úmido e escova de fibra vegetal.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">4</td>
                <td>Retirada a água da lavagem e a sujeira com pá de plástico, balde e pano.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">5</td>
                <td>Fundo seco com pano limpo.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">6</td>
                <td>Abertura do registro deixando aproximadamente 20 cm de água.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">7</td>
                <td>Colocamos a dosagem de hipoclorito de sódio de 200 ml para cada 1.000 l, deixando agir.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">8</td>
                <td>Descartamos a água pelas torneiras, e abrimos à entrada de água, deixando o reservatório encher.</td>
            </tr>
            <tr>
                <td class="font-weight-bold px-3">9</td>
                <td>Segue as técnicas desenvolvidas pela SABESP e CETESB.</td>
            </tr>
        </tbody>
    </table>
</section>

<section class="text-center wrap" style="margin: 2em 0; padding: 3em 0;">
    @include('docs.wrapimg')
    <div class="wrap-content" style="font-size: 24px;">
        <div class="mb-4">
            <h4 class="h4-custom">VALIDADE DO CERTIFICADO:</h4>
            <p style="font-size: 22px;">{{ $documentData['valmesdigito'] }} ({{ $documentData['valmesextenso'] }})
                meses.</p>
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
    <h3 style="margin-bottom: 1em;">Araras, {{ $documentData['dataextenso'] }}</h3>
    @include('docs.qrcode')
</section>
