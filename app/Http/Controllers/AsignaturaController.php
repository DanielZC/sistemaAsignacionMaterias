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

class AsignaturaController extends Controller
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
        $url = $id == null ? 'asignatura.crear' : 'asignatura.editar';
        $asignatura = $id != null ? AsignaturaModel::findOrFail($id) : null ;
        $asignaturas = AsignaturaModel::select(
            'asignaturas.id', 'asignaturas.nombre', 'profesores.nombre AS nombreProfesor',
            'areaConocimiento', 'descripcion', 'creditos', 'tipo',
            'estudiantes', 'profesores.id as profesor_id')
        ->join('profesores', 'profesores.id', '=', 'asignaturas.profesor_id')->get();
        $profesores = ProfesorModel::all();

        return view('asignaturas.index', [
            'url' => $url,
            'asignatura' => $asignatura,
            'asignaturas' => $asignaturas, 
            'profesores' => $profesores
        ]);
    }

    public function Detalles($id)
    {
        $asignatura = AsignaturaModel::select('asignaturas.nombre', 'profesores.nombre AS nombreProfesor', 'areaConocimiento', 'descripcion', 'creditos', 'areaConocimiento', 'tipo', 'estudiantes')
        ->join('profesores', 'profesores.id', '=', 'asignaturas.profesor_id')->where(['asignaturas.id' => $id])->first();
        $estudiantesIds = json_decode($asignatura->estudiantes); 
        $estudiantes = empty($estudiantesIds) ? null : EstudianteModel::select('nombre', 'documento', 'semestre')
        ->whereIn('id', $estudiantesIds)->get();

        return view('asignaturas.detalles', ['asignatura' => $asignatura, 'estudiantes' => $estudiantes]);
    }

    public function Crear(Request $request)
    {
        Validator::make($request->all(), [
            'nombre' => ['required', 'min:4', 'max:50', Rule::unique('asignaturas', 'nombre')],
            'profesor_id' => ['required', 'integer', 'exists:profesores,id'],
            'areaConocimiento' => ['required', 'min:4', 'max:50'],
            'tipo' => ['required', Rule::in(['Obligatoria', 'Electiva'])],
            'creditos' => ['required', 'integer'],
            'descripcion' => ['required', 'min:4']
        ])->validate();

        $asignatura = new AsignaturaModel();

        $asignatura->nombre = $request->nombre;
        $asignatura->profesor_id = $request->profesor_id;
        $asignatura->areaConocimiento = $request->areaConocimiento;
        $asignatura->tipo = $request->tipo;
        $asignatura->creditos = $request->creditos;
        $asignatura->descripcion = $request->descripcion;
        $asignatura->creado = $this->fecha->toDateTimeLocalString();
        $asignatura->save();

        return redirect()->route('asignatura.index')->with('creado', true);
    }

    public function Editar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['integer', 'exists:asignaturas,id'],
            'nombre' => ['required', 'min:4', 'max:50', Rule::unique('asignaturas', 'nombre')->ignore($request->id)],
            'profesor_id' => ['required', 'integer', 'exists:profesores,id'],
            'areaConocimiento' => ['required', 'min:4', 'max:50'],
            'tipo' => ['required', Rule::in(['Obligatoria', 'Electiva'])],
            'creditos' => ['required', 'integer'],
            'descripcion' => ['required', 'min:4']
        ])->validate();

        $asignatura = AsignaturaModel::findOrFail($request->id);

        $asignatura->nombre = $request->nombre;
        $asignatura->profesor_id = $request->profesor_id;
        $asignatura->areaConocimiento = $request->areaConocimiento;
        $asignatura->tipo = $request->tipo;
        $asignatura->creditos = $request->creditos;
        $asignatura->descripcion = $request->descripcion;
        $asignatura->save();

        return redirect()->route('asignatura.index')->with('actualizado', true);
    }

    public function Eliminar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:asignaturas,id', 'integer']
        ])->validate();
        
        $asignatura = AsignaturaModel::findOrFail($request->id);
        $estudiantes = json_decode($asignatura->estudiantes);
        $this->desvincular($request->id, $estudiantes);
        $asignatura->delete();

        return redirect()->route('asignatura.index')->with('eliminado', true);
    }

    public function desvincular($idAsignatura, $estudiantes)
    {
        if(count($estudiantes) > 0)
        {
            foreach ($estudiantes as $key => $estudiante) 
            {
                $asignaturasEstudiante = EstudianteModel::findOrFail($estudiante);
                $asignaturas = json_decode($asignaturasEstudiante->asignaturas);
                $index = array_search($idAsignatura, $asignaturas);
                array_splice($asignaturas, $index);
                $asignaturasEstudiante->asignaturas = json_encode($asignaturas);
                $asignaturasEstudiante->save();
            }
        }
    }
}
