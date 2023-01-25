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
        $estudiantes = EstudianteModel::paginate(5);
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
            'direccion' => ['required', 'min:4', 'max:200'],
            'ciudad' => ['required', 'min:4', 'max:30']
        ])->validate();

        $estudiante = new EstudianteModel();

        $estudiante->nombre = $this->formato->inicialesMayuscula($request->nombre);
        $estudiante->documento = trim($request->documento);
        $estudiante->telefono = trim($request->telefono);
        $estudiante->email = $this->formato->minusculas($request->email);
        $estudiante->semestre = trim($request->semestre);
        $estudiante->direccion = $this->formato->inicialesMayuscula($request->direccion);
        $estudiante->ciudad = $this->formato->pirmeraMayuscula($request->ciudad);
        $estudiante->asignaturas = json_encode(array(1,2,3));
        $estudiante->creado = $this->fecha->toDateTimeLocalString();
        $estudiante->save();

        return redirect()->route('estudiante.index')->with('creado', true);
    }

    public function Editar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:estudiantes,id', 'integer'],
            'nombre' => ['required', 'min:4', 'max:50'],
            'documento' => ['required', 'min_digits:7', 'integer', Rule::unique('estudiantes', 'documento')],
            'telefono' => ['required', 'min_digits:10', 'max_digits:10', 'integer'],
            'email' => ['required', 'email', Rule::unique('estudiantes', 'email')],
            'telefono' => ['required', 'min_digits:10', 'max_digits:10', 'integer'],
            'direccion' => ['required', 'min:4', 'max:200'],
            'ciudad' => ['required', 'min:4', 'max:30']
        ])->validate();

        $estudiante = EstudianteModel::findOrFail($request->id);

        $estudiante->nombre = $this->formato->inicialesMayuscula($request->nombre);
        $estudiante->documento = trim($request->documento);
        $estudiante->telefono = trim($request->telefono);
        $estudiante->email = $this->formato->minusculas($request->email);
        $estudiante->semestre = trim($request->semestre);
        $estudiante->direccion = $this->formato->inicialesMayuscula($request->direccion);
        $estudiante->ciudad = $this->formato->pirmeraMayuscula($request->ciudad);
        $estudiante->asignaturas = json_encode(array(1,2,3));
        $estudiante->actualizado = $this->fecha->toDateTimeLocalString();
        $estudiante->save();

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
}
