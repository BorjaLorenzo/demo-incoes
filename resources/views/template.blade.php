<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <!-- Sweet Alert 2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <title>Dashboard</title>
    <style>
        .dash-icon-hover>div>svg:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        .dash-icon-hover>div>svg {
            width: 100px;
            height: 100px;
        }

        .dash-icon-hover>div.small>svg {
            width: 50px;
            height: 50px;
        }

        .swiper-slide.swiper-slide-active {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* .dash-icon-hover{
        border: solid 1px black;
        border-radius: 25px;
      } */
        .gap-menu {
            gap: 10rem !important;
        }

        /* #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner-border {
            margin-top: -2em;
        } */
        .fila-roja {
            background-color: lightcoral !important
        }

        .is-invalid {
            border-color: red;
            color: red
        }

        select>option {
            color: black
        }

        .start-date {
            background-color: #0dcaf0;
            color: black;
        }

        .end-date {
            background-color: #0dcaf0;
            color: black;
        }

        .fc-flagged {
            background-color: blue;
            color: white;
        }

        .selected-date {
            background-color: blue;
            color: white;
        }

        .eliminardias>.col-4 {
            background-color: lightcoral;

            text-align: center;
            cursor: pointer;
        }

        .eliminardias>.col-4.ho {
            background-color: aquamarine;

            text-align: center;

        }

        .eliminardias>.col-4:hover {
            background-color: rgba(128, 128, 128, 0.514);
            transition: 0.3s;
        }

        .eliminardias>.col-4.ho:hover {
            background-color: grey;
            transition: 0.3s;
        }

        .eliminardias>.col-4:active {
            background-color: aquamarine;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error {
            border-color: #843534;
            box-shadow: none;
        }


        input.parsley-error:focus,
        select.parsley-error:focus,
        textarea.parsley-error:focus {
            border-color: #843534;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483
        }

        .navbar.navbar-expand-lg.sticky-top.bg-body-tertiary.bg-dark {
            width: 112%;
            margin-left: -6%;
        }

        .carousel-indicators li {
            width: 15px;
            /* Tamaño reducido para pantallas pequeñas */
            height: 15px;
            /* Tamaño reducido para pantallas pequeñas */
        }

        .carousel-inner .carousel-item {
            text-align: center;
        }

        .carousel-inner i {
            font-size: 30px;
            /* Tamaño de fuente reducido para pantallas pequeñas */
        }

        .dropdown svg {
            width: 10%;
        }
    </style>
    @bukStyles(true)
</head>

<body>


    <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary bg-dark " data-bs-theme="dark">
            <div class="container-fluid ">
                <a class="navbar-brand" href="dashboard">Laravel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Perfil
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a class="dropdown-item" href="logout">Desconectar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown d-block d-md-none" id="opcionesPersonalNavbar">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Opciones
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="dropdown-item" id="dashboard">{{ svg('ri-logout-box-line') }}<label
                                            for="">Menú Principal</label></div>
                                </li>
                                <li>
                                    <div class="dropdown-item" id="dashboard">{{ svg('ri-user-add-line') }}<label
                                            for="">Añadir usuario</label></div>
                                </li>
                                <li>
                                    <div class="dropdown-item" id="excelTrabajadores">
                                        {{ svg('ri-file-excel-2-line') }}<label for="">Descargar
                                            Trabajadores</label></div>
                                </li>
                                <li>
                                    <div class="dropdown-item" id="recibirEmailTrabajador">
                                        {{ svg('ri-mail-download-line') }}<label for="">Enviarme listado</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item" id="enviarEmailTrabajador">
                                        {{ svg('ri-send-plane-fill') }}<label for="">Enviar listado</label>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>

        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.9.19/libphonenumber-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.6.0/validator.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @bukScripts(true)
</body>

</html>
