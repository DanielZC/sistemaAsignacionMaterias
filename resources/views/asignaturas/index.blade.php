@php
    if($asignatura == null)
    {
        $profesor_id = old('profesor');
        $vNombre = old('nombre');
        $vDescripcion = old('descripcion');
        $vCreditos = old('creditos');
        $vAreaConocimiento = old('areaConocimiento');
        $vTipo = old('tipo');
    }
    else 
    {
        $profesor_id = old('profesor') != '' ? old('profesor') : $asignatura->profesor_id;
        $vNombre = old('nombre') != '' ? old('nombre') : $asignatura->nombre;
        $vDescripcion = old('descripcion') != '' ? old('descripcion') : $asignatura->descripcion;
        $vCreditos = old('creditos') != '' ? old('creditos') : $asignatura->creditos;
        $vAreaConocimiento = old('areaConocimiento') != '' ? old('areaConocimiento') : $asignatura->areaConocimiento;
        $vTipo = old('tipo') != '' ? old('tipo') : $asignatura->tipo;
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
                    @if ($asignatura != null)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $asignatura->id }}">
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
                                    <i class="fa-solid fa-tag"></i>
                                </span>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ $vNombre }}" placeholder="Nombre completo">
                            </div>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <select name="profesor_id" class="form-control @error('profesor_id') is-invalid @enderror">
                                @if($profesor_id == '')
                                    <option value="">Seleccione un profesor</option>
                                @endif
                                @foreach ($profesores as $profesor)
                                    <option @if($profesor_id == $profesor->id) selected="true" @endif value="{{ $profesor->id }}">{{ $profesor->nombre }}</option>
                                @endforeach
                            </select>
                            @error('profesor_id')
                                <small class="text-danger">este campo es obligatorio </small>
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-book"></i>
                                </span>
                                <input type="text" name="areaConocimiento" class="form-control @error('areaConocimineto') is-invalid @enderror" value="{{ $vAreaConocimiento }}" placeholder="Area de conocimiento">
                            </div>
                            @error('areaConocimiento')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <select name="tipo" class="form-control @error('tipo') is-invalid @enderror">
                                @if($vTipo == '')
                                    <option value="">Seleccione un tipo de asignatura</option>
                                @endif
                                <option @if($vTipo == 'Obligatoria') selected @endif value="Obligatoria">Obligatoria</option>
                                <option @if($vTipo == 'Electiva') selected @endif value="Electiva">Electiva</option>
                            </select>
                            @error('tipo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="fa-solid fa-hashtag"></i>
                                </span>
                                <input type="text" name="creditos" class="form-control @error('creditos') is-invalid @enderror" value="{{ $vCreditos }}" placeholder="Creditos">
                            </div>
                            @error('creditos')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="input-group flex-nowrap">
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripcion">{{ $vDescripcion }}</textarea>
                            </div>
                            @error('documento')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-grid gap-2">
                                <button type="sudmit" class="btn btn-primary">Guardar</button>
                                @if ($asignatura != null)
                                    <a href="{{ route('asignatura.index') }}" class="btn btn-secondary">Cancelar edicion de registro</a>                                    
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
            <h5>Listado asignaturas</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Profesor</th>
                        <th>Area de conocimiento</th>
                        <th>Creditos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($asignaturas) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No se han encontrado resultados</td>
                        </tr>
                    @else
                        @foreach ($asignaturas as $asignatura)
                            <tr>
                                <td>{{ $asignatura->nombre }}</td>
                                <td>{{ $asignatura->nombreProfesor }}</td>
                                <td>{{ $asignatura->areaConocimiento }}</td>
                                <td>{{ $asignatura->creditos }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('asignatura.detalles', ['id' => $asignatura->id]) }}" class="btn text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver informacion">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('asignatura.index', ['id' => $asignatura->id]) }}" class="btn text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('asignatura.eliminar') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $asignatura->id }}">
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
                        <th>Profesor</th>
                        <th>Area de conocimiento</th>
                        <th>Creditos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/eventos/asignaturas.js') }}"></script>
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