<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Perlux Administración</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    
    <script src="assetsadmin/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Montserrat:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assetsadmin/css/fonts.min.css"],
            },
            active: function () { sessionStorage.fonts = true; },
        });
    </script>

    <link rel="stylesheet" href="assetsadmin/css/bootstrap10.min.css" />
    <link rel="stylesheet" href="assetsadmin/css/plugins.min.css" />
    <link rel="stylesheet" href="assetsadmin/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="assetsadmin/css/demo.css" />

    @vite(['resources/js/app.js'])

    <style>
        :root {
            --skinly-blue: #007EAB;
            --skinly-dark: #4A4A4A;
            --skinly-black: #1a1a1a;
            --skinly-white: #ffffff;
        }

        /* Aplicar la fuente solicitada a todo el cuerpo */
        body, html {
            font-family: 'Copperplate', 'Copperplate Gothic Light', 'Montserrat', sans-serif !important;
        }

        /* Desactivar negritas en todo el proyecto */
        *, b, strong, .fw-bold {
            font-weight: normal !important;
        }

        /* 1. Header del Logo (Esquina superior izquierda) */
        .logo-header {
            background-color: var(--skinly-blue) !important;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        /* 2. Sidebar (Menú lateral) */
        .sidebar {
            /* Usamos un gris muy oscuro para contraste, o el gris solicitado si prefieres */
            background-color: var(--skinly-dark) !important; 
        }

        /* Elementos del menú al pasar el mouse o activos */
        .sidebar .nav-item.active > a,
        .sidebar .nav-item > a:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }
        
        .sidebar .nav-item.active > a:before {
            background-color: var(--skinly-blue) !important; /* Indicador activo */
        }

        /* 3. Barra Superior (Navbar principal) */
        .main-header .navbar-header {
            background: var(--skinly-white) !important;
            border-bottom: 1px solid #e1e1e1;
        }

        /* Color de los iconos del toggle (hamburguesa) en el Logo Header */
        .btn-toggle .gg-menu-right, 
        .btn-toggle .gg-menu-left,
        .topbar-toggler .gg-more-vertical-alt {
            color: #fff !important; /* Blancos sobre el fondo Azul */
        }

        /* Color de los iconos del toggle en el Navbar Principal (si aparecen ahí) */
        .main-header .btn-toggle .gg-menu-right,
        .main-header .gg-more-vertical-alt {
            color: var(--skinly-dark) !important;
        }

        /* Texto de usuario y perfil */
        .profile-username, .op-7 {
            color: var(--skinly-dark) !important;
        }

        /* Arreglos generales de iconos CSS (gg-icons) */
        .gg-menu-right::before, .gg-menu-left::before,
        .gg-menu-right::after, .gg-menu-left::after {
            background-color: currentColor !important;
        }
        
        /* Scrollbar personalizada */
        .sidebar-wrapper.scrollbar-inner::-webkit-scrollbar-thumb {
            background: var(--skinly-blue);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar"> 
            <div class="sidebar-logo">
                <div class="logo-header">
                    <a href="/bienvenida" class="logo">
                        <img src="images/site/resources/logo_perlux.svg" alt="navbar brand" class="navbar-brand ms-4" 
                             height="20" style="filter: brightness(0) invert(1);" /> 
                             </a>
                    <div class="nav-toggle text-white">
                        <button class="btn btn-toggle toggle-sidebar text-white">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt text-white"></i>
                    </button>
                </div>
                </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    @include('admin.layout.menu')
                </div>
            </div>
        </div>
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header">
                        <a href="/bienvenida" class="logo">
                            <img src="images/site/svg/skinly_logo.svg" alt="navbar brand" class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    </div>
                
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="assetsadmin/img/profile.jpg" alt="..."
                                            class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hola,</span>
                                        <span class="fw-bold" style="color: var(--skinly-blue)">{{auth()->user()->name ?? 'Usuario'}}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <form action="/admin-logout" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Salir</button>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            
