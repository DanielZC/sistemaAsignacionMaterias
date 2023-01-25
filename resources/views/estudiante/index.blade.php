@php
    if($estudiante == null)
    {
        $vNombre = old('nombre');
        $vDocumento = old('documento');
        $vEmail = old('email');
        $vTelefono = old('telefono');
        $vCiudad = old('ciudad');
        $vSemestre = old('semestre');
        $vAsignaturas = old('asignaturas') == '' ? old('asignaturas') : old('asignaturas')[0];
        $vDireccion = old('direccion');
    }
    else 
    {
        $vNombre = old('nombre') != '' ? old('nombre') : $estudiante->nombre;
        $vDocumento = old('documento') != '' ? old('documento') : $estudiante->documento;
        $vEmail = old('email') != '' ? old('email') : $estudiante->email;
        $vTelefono = old('telefono') != '' ? old('telefono') : $estudiante->telefono;
        $vCiudad = old('ciudad') != '' ? old('ciudad') : $estudiante->ciudad;
        $vSemestre = old('semestre') != '' ? old('semestre') : $estudiante->semestre;
        $vAsignaturas = old('asignaturas') != '' ? old('asignaturas')[0] : $estudiante->asignaturas;
        $vDireccion = old('direccion') != '' ? old('direccion') : $estudiante->direccion;
    }
@endphp
@extends('layout')
@section('contenido')
    <div class="d-flex justify-content-center mb-5">
        <div class="card w-100">
            <div class="card-header bg-secondary text-white">
                <h5>Crear nuevo estudiante</h5>
            </div>
            <div class="card-body">
                <form action="{{ route($url) }}" id="formAsignarMateria" method="post">
                    @csrf
                    @if ($estudiante != null)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $estudiante->id }}">
                        @error('id')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                <i class="fa-solid fa-triangle-exclamation"></i> Advertencia!
                            </strong> Parametro requerido no encontrado.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    @endif
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ $vNombre }}" placeholder="Nombre completo">
                            </div>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-address-card"></i>
                                </span>
                                <input type="text" name="documento" class="form-control @error('documento') is-invalid @enderror" value="{{ $vDocumento }}" placeholder="Numero de documento">
                            </div>
                            @error('documento')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $vEmail }}" placeholder="Correo">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-mobile"></i>
                                </span>
                                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ $vTelefono }}" placeholder="Telefono">
                            </div>
                            @error('telefono')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </span>
                                <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" value="{{ $vCiudad }}" placeholder="Ciudad">
                            </div>
                            @error('ciudad')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-hashtag"></i>
                                </span>
                                <input type="text" name="semestre" class="form-control @error('semestre') is-invalid @enderror" value="{{ $vSemestre }}" placeholder="Semestre actual">
                            </div>
                            @error('semestre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-7">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-sharp fa-solid fa-location-dot"></i>
                                </span>
                                <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ $vDireccion }}" placeholder="Direccion">
                            </div>
                            @error('direccion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="card mb-3">
                            <div class="card-header bg-light text-black">
                                <h4>Asignaturas</h4>
                            </div>
                            <div class="card-body">
                                <table id="tabla_asignaciones" class="table table-sm table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Creditos</th>
                                            <th>Tipo de clase</th>
                                            <th class="text-center">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($asignaturas) > 0)
                                        @foreach ($asignaturas as $asignatura)
                                            <tr>
                                                <td>{{ $asignatura->nombre }}</td>
                                                <td>{{ $asignatura->creditos }}</td>
                                                <td>{{ $asignatura->tipo }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" class="btn btn-sm text-primary" id="btnAsignar_{{ $asignatura->id }}" name="asignar" data="{{ $asignatura->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Asignar">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm text-danger" id="btnDesasignar_{{ $asignatura->id }}" name="desasignar" data="{{ $asignatura->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Desasignar">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Creditos</th>
                                            <th>Tipo de clase</th>
                                            <th class="text-center">Accion</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Asignaturas seleccionadas</h5>
                                    <hr class="my-0">
                                    <input type="hidden" name="asignaturas[]" id="asignaturas" value="{{ $vAsignaturas }}" data="">
                                    <small class="text-danger" id="errorAsignacion"></small>
                                    @error('asignaturas')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="row mt-1 g-2" id="listaMaterias" style="height: 100px; overflow: auto">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-grid gap-2">
                                <button type="sudmit" class="btn btn-primary" id="btnEnviar">Guardar</button>
                                @if ($estudiante != null)
                                    <a href="{{ route('estudiante.index') }}" class="btn btn-secondary">Cancelar edicion de registro</a>                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5>Listado estudiantes</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Telefeno</th>
                        <th>Ciudad</th>
                        <th>Direccion</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($estudiantes) == 0)
                        <tr>
                            <td colspan="7" class="text-center">No se han encontrado resultados</td>
                        </tr>
                    @else
                        @foreach ($estudiantes as $estudiante)
                            <tr>
                                <td>{{ $estudiante->nombre }}</td>
                                <td>{{ $estudiante->documento }}</td>
                                <td>{{ $estudiante->email }}</td>
                                <td>{{ $estudiante->telefono }}</td>
                                <td>{{ $estudiante->ciudad }}</td>
                                <td>{{ $estudiante->direccion }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn text-info" data="{{ $estudiante->id }}" name="btnInfo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver informacion">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="{{ route('estudiante.index', ['id' => $estudiante->id]) }}" class="btn text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('estudiante.eliminar') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $estudiante->id }}">
                                            <button type="button" class="btn text-danger" name="btnEliminar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Telefeno</th>
                        <th>Ciudad</th>
                        <th>Direccion</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Informacion personal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="nombre"></h5>
                    <div class="mb-2">
                        <p>
                            Documento de identidad <i class="fa-solid fa-address-card"></i> : <span id="documento"></span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <p>
                            Correo <i class="fa-solid fa-envelope"></i> : <span id="email"></span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <p>
                            Telefono <i class="fa-solid fa-mobile"></i> : <span id="telefono"></span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <p>
                            Ciudad <i class="fa-solid fa-map-location-dot"></i> : <span id="ciudad"></span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <p>
                            Semestre <i class="fa-solid fa-hashtag"></i> : <span id="semestre"></span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <p>
                            Direccion <i class="fa-sharp fa-solid fa-location-dot"></i> : <span id="direccion"></span>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
      
@endsection
@section('js')
    <script src="{{ asset('js/utilities/tooltip.js') }}"></script>
    <script src="{{ asset('js/eventos/estudiantes.js') }}"></script>
    @if(session('creado'))
        <script src="{{ asset('js/alertas/creado.js') }}"></script>
    @endif

    @if(session('actualizado'))
        <script src="{{ asset('js/alertas/actualizado.js') }}"></script>
    @endif

    @if(session('eliminado'))
        <script src="{{ asset('js/alertas/eliminado.js') }}"></script>
    @endif
@endsection