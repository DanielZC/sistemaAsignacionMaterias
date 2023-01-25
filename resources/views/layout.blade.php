<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de asignacion de materias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="py-5">
        <div class="container px-0">
            <ul class="nav nav-pills justify-content-center bg-light py-2 mb-3 border rounded shadow">
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(url()->current(), 'profesores') ? 'active' : '' }} me-3" href="{{ route('profesor.index') }}">Pofesores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(url()->current(), 'estudiantes') ? 'active' : '' }} me-3" href="{{ route('estudiante.index') }}">Estudiantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(url()->current(), 'asignaturas') ? 'active' : '' }} " href="{{ route('asignatura.index') }}">Asignaturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        Cerrar sesion
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <div class="container shadow pt-3 pb-3 h-100">
            @yield('contenido')
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/15e5f755f7.js" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@yield('js')
</html>