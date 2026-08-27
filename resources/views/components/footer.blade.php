<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        .footer {
            background-color: #222;
            color: #fff;
            position: relative;
            width: 100%;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer .form-control {
            background-color: #333;
            border: 1px solid #444;
            color: #fff;
        }

        .footer .btn-outline-white {
            border-color: #fff;
            color: #fff;
        }

        .footer .btn-outline-white:hover {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Your body content goes here -->
    </div>

    <div class="footer">
        <footer class="text-center text-lg-start border border-dark pt-1">
            <!-- Grid container -->
            <div class="container-fluid p-4">
                <!--Grid row-->
                <div class="row justify-content-between">
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">Fumettisti Indipendenti</h5>
                        <ul class="list-unstyled mb-4">
                            <li><a href="#!" class="text-white">Su di noi</a></li>
                            <li><a href="#!" class="text-white">Collezioni</a></li>
                            <li><a href="#!" class="text-white">Filosofia Ambiente</a></li>
                            <li><a href="{{ route('article.index', 'article') }}" class="text-white">Collaborazioni Con Artisti</a></li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">Assistenza</h5>
                        <ul class="list-unstyled">
                            <li><a href="#!" class="text-white">Contattaci</a></li>
                            <li><a href="#!" class="text-white">Guida Alle Letture</a></li>
                            <li><a href="{{ route('careers') }}" class="text-white">Lavora Con Noi</a></li>
                            <li><a href="#!" class="text-white">Pubblicazioni</a></li>
                            <li><a href="#!" class="text-white">Partnerships</a></li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">Lavora con noi</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('careers') }}" class="text-white">Offerte</a></li>
                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3 border-top border-light">
                © 2024 Copyright:
                <a class="text-white" href="#">Federico x AuLab</a>
            </div>
            <!-- Copyright -->
        </footer>
    </div>
</body>
</html>
