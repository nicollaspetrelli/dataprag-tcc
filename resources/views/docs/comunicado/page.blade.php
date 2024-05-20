<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>teste</title>
    <link href="http://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        html,
        * {
            font-family: 'Poppins', sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        p {
            margin: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4.5em 4.5em 10em 4.5em
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            width: 140px;
        }

        .content .title {
            display: -webkit-box;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-flex-direction: column;
            -webkit-box-orient: vertical;
        }

        .title p {
            font-size: 2.5rem;
            font-weight: 600;
            color: #3D3D3D;
        }

        .sub-title p {
            display: -webkit-box;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            font-size: 1.5rem;
            font-weight: 400;
            color: #666666;
            margin: auto;
            padding: 10px 0 30px 20px;
            text-align: center;
        }

        .sub-title p span {
            font-size: 1.6rem;
            font-weight: 600;
            color: #3D3D3D;
        }

        .recommendations-title,
        .content-recommendations,
        .item-list,
        .date-time-fieldset,
        .recommendations-image,
        .date-time {
            display: -webkit-box;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
        }

        .recommendations {
            display: -webkit-box;
            -webkit-flex-direction: column;
            -webkit-box-orient: vertical;
            -webkit-box-pack: start;
            justify-content: start;
            -webkit-box-align: start;
        }

        .icon-watch {
            width: 40px
        }

        .date-time-fieldset {         
            background-color: #B6CF94;
            border-radius: 16px;
            width: 80%;
            padding: 30px 40px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
            white-space: nowrap;
        }

        .recommendations-title p {
            font-size: 1.8rem;
            font-weight: 500;
            color: #3D3D3D;
            padding: 30px 0 10px 0;
        }

        .recommendations-body {
            display: -webkit-box;
            -webkit-box-pack: start;
            justify-content: start;
            -webkit-box-align: start;
            border: 2px solid #bbd29e;
            border-radius: 24px;
            width: 700px;
            padding: 24px 0 24px 40px;
        }

        .item-list {
            padding: 16px 0;
        }

        .icon-list {
            width: 40px;
            border: 1px solid #3D3D3D;
            padding: 10px;
            margin-right: 15px;
            border-radius: 40px;
        }

        .icon-clock {
            width: 30px;
            padding: 10px;
            margin-right: 15px;
            border-radius: 40px;
        }

        .recommendations-text div p {
            display: -webkit-box;
            -webkit-box-pack: start;
            -webkit-box-direction: start;
            justify-content: start;
            -webkit-box-align: start;
            text-align: start;
            white-space: nowrap;
        }

        .recommendations-text div p.title {
            font-weight: 600;
            color: #bdcf2b;
            font-size: 1.3rem;
        }

        .recommendations-text div p.text {
            padding-top: 5px; 
            font-weight: 500;
            color: #525252;
            font-size: 1.2rem;
        }

        .header-wave {
            position: absolute;
            left: 0;
            top: 0;
            width: 400px;
            z-index: -1;
            opacity: 0.8;
        }

        .footer-wave {
            position: fixed;
            left: 0;
            bottom: -170px;
            width: 1000px;
            z-index: -1;
            opacity: 1;
        }

        .wrap {
            overflow: hidden;
            position: relative;
        }

        .wrap-bg {
            opacity: 0.09;
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            top: 70px;
            right: 0;
            text-align: center;
            height: auto;
            width: 50%;
        }

        .wrap-content {
            position: relative;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: -8px;
            width: 100%;
            text-align: center;
        }

        footer div {
            font-size: 1.4rem;
            color: #fff;
            font-weight: 500;
            position: fixed;
            left: 0;
            right: 0;
            bottom: -130px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">

            @include('docs.comunicado.header-wave')
            {{-- title --}}
            <div class="title">
                <div>
                    @include('docs.comunicado.logo')
                </div>
                <div>
                    <p>COMUNICADO</p>
                </div>
            </div>
            <div class="sub-title">
                <p>
                    Informamos que será realizado a
                    <span>Desinsetização do Local</span> <br/>
                    nas áreas comuns do <span>Condomínio Portal do Parque.</span> <br/>
                </p>
            </div>

        </div>

        {{-- date and time --}}
        <div class="date-time">
            <div class="date-time-fieldset">
                <div class="recommendations-image">
                    {{-- @include('docs.comunicado.icon-watch') --}}
                </div>
                <div>
                    <p>Dia: 19/07/2022 ás 9:30hrs </p>
                </div>
            </div>
        </div>

        {{-- recommendations --}}
        <div class="content-recommendations">
            <div class="recommendations-list">
                <div class="recommendations-body wrap">
                    @include('docs.wrapimg')
                    <div class="recommendations wrap-content">
                        <div class="item-list">
                            <div class="recommendations-image">
                                @include('docs.comunicado.icon-hours')
                            </div>
                            <div class="recommendations-text">
                                <div>
                                    <p class="title">
                                        Não utilizar as áreas:
                                    </p>
                                </div>
                                <div>
                                    <p class="text">
                                        Evitar circular nas áreas comuns do condomínio.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="item-list">
                            <div class="recommendations-image">
                                @include('docs.comunicado.icon-dog')
                            </div>
                            <div class="recommendations-text">
                                <div>
                                    <p class="title">
                                        Animais de estimação:
                                    </p>
                                </div>
                                <div>
                                    <p class="text">
                                        Não deixar animais de estimação fora dos apartamentos.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="item-list">
                            <div class="recommendations-image">
                                @include('docs.comunicado.icon-lock')
                            </div>
                            <div class="recommendations-text">
                                <div>
                                    <p class="title">
                                        No dia da execução do serviço:
                                    </p>
                                </div>
                                <div>
                                    <p class="text">
                                        Colocar pano umido nos ralos.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="item-list emergency">
                            <div class="recommendations-image">
                                @include('docs.comunicado.icon-warn')
                            </div>
                            <div class="recommendations-text">
                                <div>
                                    <p class="title">
                                        Em casos de emergência:
                                    </p>
                                </div>
                                <div>
                                    <p class="text">
                                        Informações, dúvidas e ficha emergencial dos produtos,
                                    </p>
                                    <p class="text">
                                        entre em contato com o técnico responsável pelo
                                    </p>
                                    <p class="text">
                                        WhatsApp (19) 3352-5152.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <footer>
            @include('docs.comunicado.footer')
            <div>
                <p>(19) 3352-5152 - Dedetizadora Ambientalis &copy; 2022</p>
                <p>contato@dedetizadoraambientalis.com | www.dedetizadoraambientalis.com</p>
            </div>
        </footer>
</body>

</html>
