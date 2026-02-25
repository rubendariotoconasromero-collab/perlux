@php
$id_usuario=Auth::user()->id??'';
@endphp
@extends('admin.login.layout')

@section('content')

<div id="app">
    <div class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <a href="/">
                                    <img src="{{ asset('images/site/resources/logo_perlux.svg') }}" alt="EntreXpertos Logo"
                                        class="logo-img logo-white"
                                        style="max-width: 200px; height: auto; margin-left: auto; margin-right: auto;" />
                                </a>
                            </div>
                            <h2 class="text-center fw-bold mb-4 text-white">ADMINISTRADORES</h2>
                            <form method="POST" action="{{ route('admin') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                        autofocus>
                                    @error('email')
                                    <span class="invalid-feedback text-white" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-white">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback text-white" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-outline-light w-100 py-3">Iniciar Sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-section py-5 mb-0">
        {{-- <div class="container text-center">
            <a href="#" class="d-flex justify-content-center mb-3">
                <img src="{{ asset('images/logo_extrexpertos.svg') }}" alt="EntreXpertos Hacks de Liderazgo"
                    class="footer-logo" />
            </a>
            <div class="d-flex justify-content-center align-item-center mt-5 mb-3">
                <a href="#"><img src="{{ asset('images/Youtube.svg') }}" alt="Youtube" class="mx-3"
                        style="width: auto; height: 1.5rem;" /></a>
                <a href="#"><img src="{{ asset('images/TikTok.svg') }}" alt="TikTok" class="mx-3"
                        style="width: auto; height: 1.5rem;" /></a>
                <a href="#"><img src="{{ asset('images/Instagram.svg') }}" alt="Instagram" class="mx-3"
                        style="width: auto; height: 1.5rem;" /></a>
                <a href="#"><img src="{{ asset('images/Linkedin.svg') }}" alt="Linkedin" class="mx-3"
                        style="width: auto; height: 1.5rem;" /></a>
            </div>
            <p class="text-white mb-0">© {{ date('Y') }} EntreXpertos. Todos los derechos reservados.</p>
        </div> --}}
    </footer>
</div>



<style>
    .logo-white {
        filter: brightness(0) invert(1);
    }

    .footer-section {
        background: url('/images/footer.jpg');
        z-index: 1001;

    }
    .footer-logo {
        height: 50px;
        /* Ajusta según el tamaño de tu logo */

    }

    .social-icons a {
        font-size: 1.5rem;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #ccc;
        /* Color al pasar el mouse */
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .footer-logo {
            height: 30px;
            /* Tamaño más pequeño para pantallas pequeñas */
        }

        .social-icons a {
            font-size: 1.25rem;
        }

        .footer-section p {
            font-size: 0.9rem;
        }
    }

</style>

<style>
    .login-section {
      
        /* background-image: url('images/bg3_nosotros.jpg'); */
        background-size: cover;
        background-position: center;
        padding-top: 6rem;
        padding-bottom: 5rem;
    }

    .login-section .card {
        background-image: url('images/bg_all.jpg');
        background-size: cover;
        background-position: center;
        border-radius: 1rem;
        padding: 2rem;
        color: #fff;
    }

    .login-section .form-label {
        font-weight: 600;
    }

    .login-section .btn-outline-light {
        border-color: #f8f9fa;
        color: #f8f9fa;
    }

    .login-section .btn-outline-light:hover {
        background-color: #f8f9fa;
        color: #343a40;
    }

    .login-section .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .login-section .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

</style>

@endsection
