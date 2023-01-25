@extends('layout')
@section('contenido')
    <div class="d-flex justify-content-center mb-5">
        <div class="card w-100">
            <div class="card-body">
                <h3>{{ $asignatura->nombre }}</h3>
                <hr>
                <h3>Descripcion</h3>
                <p>{{ $asignatura->descripcion }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <span class="fw-bold">Profesor:</span> {{ $asignatura->nombreProfesor }}
                        </p>                                      
                    </div>
                    <div class="col-md-6">
                        <p>
                            <span class="fw-bold">Area de conocimineto:</span> {{ $asignatura->areaConocimiento }}
                        </p>                                            
                    </div>
                    <div class="col-md-6">
                        <p>
                            <span class="fw-bold">Tipo de asignatura:</span> {{ $asignatura->tipo }}
                        </p>                                        
                    </div>
                    <div class="col-md-6">
                        <p>
                            <span class="fw-bold">Creditos:</span> {{ $asignatura->creditos }}
                        </p> 
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Semestre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($estudiantes == null )
                            <tr>
                                <td colspan="3" class="text-center">No se han encontrado registros</td>
                            </tr>
                        @else
                            @foreach ($estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->nombre }}</td>
                                    <td>{{ $estudiante->documento }}</td>
                                    <td>{{ $estudiante->semestre }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection