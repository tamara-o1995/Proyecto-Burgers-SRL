<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Burgers SRL</title>

    <!-- Normalize V8.0.1 -->
    <link href="{{ asset('web/css/normalize.css') }}" rel="stylesheet" type="text/css">
    <!-- MDBootstrap V5 -->
    <link href="{{ asset('web/css/mdb.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Font Awesome V5.15.1 -->
    <link href="{{ asset('web/css/all.css') }}" rel="stylesheet" type="text/css">
    <!-- Sweet Alert V10.13.0 -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <!-- General Styles -->

    <!-- <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js') }}" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js') }}" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js') }}" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

    <link href="{{ asset('web/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('web/js/main.js') }}" rel="stylesheet" type="text/js">
    <script src="{{ asset('web/mdb.min.js') }}" rel="stylesheet" type="text/js"></script>
    <script src="{{ asset('web/js/sweetalert2.js') }}" rel="stylesheet" type="text/js"></script>
    <script src="{{ asset('web/./js/mdb.min.js') }}" rel="stylesheet" type="text/js"></script>



</head>

<body id="main-body">

    <!-- Header -->
    <header>
        <div class="header full-box">
            <div class="header-brand full-box col-sm-4">
                <a href="/">
                    <img src="web/assets/img/silueta-de-logotipo-de-logotipo-de-comida-de-hamburguesa.png" alt="Designlopers" class="logo-burger">
                </a>
            </div>

            <div class="header-options full-box col-sm-4">

                <nav class="header-navbar full-box poppins-regular font-weight-bold scroll  navbar-expand-md" onclick="show_menu_mobile()">
                    <div class="menu">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon mt-2" style="color: black;"><i class="fas fa-bars"></i></span>
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExampleDefault">

                            <ul class="navbar-nav me-auto mb-2 mb-md-0 ">
                                <li class="nav-item">
                                    <a class="nav-link" style="color: black;" href="/">INICIO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color: black;" href="takeaway">TAKE AWAY</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color: black;" href="nosotros">NOSOTROS</a>
                                </li>
                                <li class="nav-item">
                                    @if(Session::get('usuario_id') && Session::get('usuario_id') > 0)
                                    <a class="nav-link" style="color: black;" href="mi_cuenta">MI CUENTA</a>
                                    @else
                                    <a style="color: black;" href="registrate">REGISTRATE</a>
                                    @endif
                                </li>

                                <li class="nav-item">
                                    @if(Session::get('usuario_id') && Session::get('usuario_id') > 0)
                                    <a class="nav-link" style="color: black;" href="/logout" class="nav-link scrollto">CERRAR SESION</a>
                                    @else
                                    <a class="nav-link"  style="color: black;" href="login">LOGIN</a>
                                    @endif
                                </li>
                                <li class="nav-item">
                                @if(Session::get('usuario_id') && Session::get('usuario_id') > 0)
                                <a class="nav-link" style="color: black;" href="carrito" class="header-button full-box text-center" title="Carrito">
                                    <i class="fas fa-shopping-cart"></i></a>
                                @else
                                <a class="nav-link" style="color: black;" href="login" class="header-button full-box text-center" title="Login">
                                    <i class="fas fa-shopping-cart"></i></a>
                                @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>


    <!-- Content -->
    @yield('contenido')
    <!-- Footer -->

    <footer class="footer">
        <div class="container">
            <div class="row mt-3">

                <div class="col-sm-4 col-12 text-sm-left pb-sm-0 pb-3">
                    <ul class="circle-msg list-unstyled">
                        <li>
                            <a href="/"><img src="web/assets/img/silueta-de-logotipo-de-logotipo-de-comida-de-hamburguesa.png" alt="Designlopers" class="logo-burger2"></a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4 col-12 text-sm-left pb-sm-0 pb-3">
                    <ul class="escribinos list-unstyled">
                        <li>
                            <h5 class="font-weight-bold">Escribinos a:</h5>
                        </li>
                        <li>
                            <a href="mailto:info@burger_srl.com" class="footer-link"><i class="fas fa-envelope-open-text"></i> burger_srl@gmail.com</a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?phone=542494466495" class="footer-link " target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4 col-12">
                    <ul class="seguinos list-unstyled">
                        <li>
                            <h5 class="font-weight-bold">Seguinos en:</h5>
                        </li>
                        <li>
                            <a href="https://www.facebook.com" class="footer-link" target="_blank"><i class="fab fa-facebook-square"></i> Facebook</a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com" class="footer-link" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- MDBootstrap V5 -->
    <script src="./js/mdb.min.js"></script>
    <!-- General scripts -->
    <script src="./js/main.js"></script>

    <!-- CSS only -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>