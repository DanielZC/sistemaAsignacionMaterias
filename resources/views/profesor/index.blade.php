@php
    if($profesor == null)
    {
        $vNombre = old('nombre');
        $vDocumento = old('documento');
        $vEmail = old('email');
        $vTelefono = old('telefono');
        $vCiudad = old('ciudad');
        $vDireccion = old('direccion');
    }
    else 
    {
        $vNombre = old('nombre') != '' ? old('nombre') : $profesor->nombre;
        $vDocumento = old('documento') != '' ? old('documento') : $profesor->documento;
        $vEmail = old('email') != '' ? old('email') : $profesor->email;
        $vTelefono = old('telefono') != '' ? old('telefono') : $profesor->telefono;
        $vCiudad = old('ciudad') != '' ? old('ciudad') : $profesor->ciudad;
        $vDireccion = old('direccion') != '' ? old('direccion') : $profesor->direccion;
    }
@endphp
@extends('layout')
@section('contenido')
    <div class="d-flex justify-content-center mb-5">
        <div class="card w-100">
            <div class="card-header bg-secondary text-white">
                <h5>Crear nuevo profesor</h5>
            </div>
            <div class="card-body">
                <form action="{{ route($url) }}" method="post">
                    @csrf
                    @if ($profesor != null)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $profesor->id }}">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-grid gap-2">
                                <button type="sudmit" class="btn btn-primary">Guardar</button>
                                @if ($profesor != null)
                                    <a href="{{ route('profesor.index') }}" class="btn btn-secondary">Cancelar edicion de registro</a>                                    
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
            <h5>Listado profesores</h5>
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
                    @if (count($profesores) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No se han encontrado resultados</td>
                        </tr>
                    @else
                        @foreach ($profesores as $profesor)
                            <tr>
                                <td>{{ $profesor->nombre }}</td>
                                <td>{{ $profesor->documento }}</td>
                                <td>{{ $profesor->email }}</td>
                                <td>{{ $profesor->telefono }}</td>
                                <td>{{ $profesor->ciudad }}</td>
                                <td>{{ $profesor->direccion }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn text-info" data="{{ $profesor->id }}" name="btnInfo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver informacion">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="{{ route('profesor.index', ['id' => $profesor->id]) }}" class="btn text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('profesor.eliminar') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $profesor->id }}">
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
    <script src="{{ asset('js/eventos/profesores.js') }}"></script>
    <script src="{{ asset('js/utilities/tooltip.js') }}"></script>
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