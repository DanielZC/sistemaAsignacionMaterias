<?php

namespace App\Http\Controllers;

use App\Class\Formato;
use App\Models\AsignaturaModel;
use App\Models\EstudianteModel;
use App\Models\ProfesorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EstudianteController extends Controller
{
    public $fecha;
    public $formato;

    public function __construct() 
    {
        $this->formato = new Formato();
        $this->fecha = Carbon::now('America/Bogota');
    }

    public function Index($id = null)
    {
        $url = $id == null ? 'estudiante.crear' : 'estudiante.editar';
        $estudiante = $id != null ? EstudianteModel::findOrFail($id) : null;
        $estudiantes = EstudianteModel::all();
        $asignaturas = AsignaturaModel::all(['id', 'nombre', 'creditos', 'tipo']);

        return view('estudiante.index', [
            'estudiantes' => $estudiantes, 
            'estudiante' => $estudiante,
            'asignaturas' => $asignaturas,
            'url' => $url
        ]);
    }

    public function Ver($id)
    {
        $parametro = array('id' => $id);
        $validador = Validator::make($parametro, [
            'id' => ['required', 'exists:estudiantes,id', 'integer']
        ]);

        if($validador->fails())
        {
            $respuesta = array(
                'tipo' => 'error',
                'msj' => $validador
            );
        }
        else
        {
            $estudiante = EstudianteModel::findOrFail($id);
            $respuesta = array(
                'tipo' => 'ok',
                'estudiante' => $estudiante
            );
        }

        return response()->json($respuesta, 200);
    }

    public function Crear(Request $request)
    {
        Validator::make($request->all(), [
            'nombre' => ['required', 'min:4', 'max:50'],
            'documento' => ['required', 'min_digits:7', 'integer', Rule::unique('estudiantes', 'documento')],
            'telefono' => ['required', 'min_digits:10', 'max_digits:10', 'integer'],
            'email' => ['required', 'email', Rule::unique('estudiantes', 'email')],
            'semestre' => ['required', 'integer', 'between:1,17'],
            'asignaturas' => ['required'],
            'direccion' => ['required', 'min:4', 'max:200'],
            'ciudad' => ['required', 'min:4', 'max:30']
        ])->validate();

        $asignaturas = explode(',', $request->asignaturas[0]);
        $estudiante = new EstudianteModel();

        $estudiante->nombre = $this->formato->inicialesMayuscula($request->nombre);
        $estudiante->documento = trim($request->documento);
        $estudiante->telefono = trim($request->telefono);
        $estudiante->email = $this->formato->minusculas($request->email);
        $estudiante->semestre = trim($request->semestre);
        $estudiante->direccion = $this->formato->inicialesMayuscula($request->direccion);
        $estudiante->ciudad = $this->formato->pirmeraMayuscula($request->ciudad);
        $estudiante->asignaturas = json_encode($asignaturas);
        $estudiante->creado = $this->fecha->toDateTimeLocalString();
        $estudiante->save();
        
        $this->asosiarMaterias($estudiante->id, $asignaturas);

        return redirect()->route('estudiante.index')->with('creado', true);
    }

    public function Editar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:estudiantes,id', 'integer'],
            'nombre' => ['required', 'min:4', 'max:50'],
            'documento' => ['required', 'min_digits:7', 'integer', Rule::unique('estudiantes', 'documento')->ignore($request->id)],
            'telefono' => ['required', 'min_digits:10', 'max_digits:10', 'integer'],
            'email' => ['required', 'email', Rule::unique('estudiantes', 'email')->ignore($request->id)],
            'semestre' => ['required', 'integer', 'between:1,17'],
            'asignaturas' => ['required'],
            'direccion' => ['required', 'min:4', 'max:200'],
            'ciudad' => ['required', 'min:4', 'max:30']
        ])->validate();

        $asignaturas = explode(',', $request->asignaturas[0]);
        $estudiante = EstudianteModel::findOrFail($request->id);
        $materiasV = $estudiante->asignaturas;

        $estudiante->nombre = $this->formato->inicialesMayuscula($request->nombre);
        $estudiante->documento = trim($request->documento);
        $estudiante->telefono = trim($request->telefono);
        $estudiante->email = $this->formato->minusculas($request->email);
        $estudiante->semestre = trim($request->semestre);
        $estudiante->direccion = $this->formato->inicialesMayuscula($request->direccion);
        $estudiante->ciudad = $this->formato->pirmeraMayuscula($request->ciudad);
        $estudiante->asignaturas = json_encode($asignaturas);
        $estudiante->actualizado = $this->fecha->toDateTimeLocalString();
        $estudiante->save();

        $this->asosiarMaterias($estudiante->id, $asignaturas);
        $this->desasosiar($estudiante->id, $asignaturas, $materiasV);

        return redirect()->route('estudiante.index')->with('actualizado', true);
    }

    public function Eliminar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:estudiantes,id', 'integer']
        ])->validate();

        $estudiante = EstudianteModel::findOrFail($request->id);
        $estudiante->delete();

        return redirect()->route('estudiante.index')->with('eliminado', true);
    }

    public function asosiarMaterias($idEstudiante, $materiasN)
    {
        $materiasN = $materiasN;

        foreach ($materiasN as $key => $id) 
        {
            $materia = AsignaturaModel::findOrFail($id);

            $estudiantes = $materia->estudiantes != '' ? json_decode($materia->estudiantes) : array();

            if(!in_array($idEstudiante, $estudiantes))
            {
                array_push($estudiantes, $idEstudiante);
                $materia->estudiantes = json_encode($estudiantes);
                $materia->actualizado = $this->fecha->toDateTimeLocalString();                        
                $materia->save();
            }
        }
    }

    public function desasosiar($idEstudiante, $materiasN, $materiasV)
    {
        $materiasN = $materiasN;
        $materiasV = json_decode($materiasV);

        foreach ($materiasV as $key => $id) 
        {
            if(!in_array($id, $materiasN))
            {
                $materia = AsignaturaModel::findOrFail($id);

                $estudiantes = json_decode($materia->estudiantes);
                $index = array_search($idEstudiante, $estudiantes);
                array_splice($estudiantes, $index);
                $materia->estudiantes = json_encode($estudiantes);
                $materia->actualizado = $this->fecha->toDateTimeLocalString();                    
                $materia->save();
            }
        }
    }
}
