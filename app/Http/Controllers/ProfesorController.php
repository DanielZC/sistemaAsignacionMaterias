<?php

namespace App\Http\Controllers;

use App\Models\ProfesorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Class\Formato;

class ProfesorController extends Controller
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
        $url = $id == null ? 'profesor.crear' : 'profesor.editar';
        $profesor = $id != null ? ProfesorModel::findOrFail($id) : null;
        $profesores = ProfesorModel::all();

        return view('profesor.index', ['profesores' => $profesores, 'profesor' => $profesor, 'url' => $url]);
    }

    public function Ver($id)
    {
        $parametro = array('id' => $id);
        $validador = Validator::make($parametro, [
            'id' => ['required', 'exists:profesores,id', 'integer']
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
            $profesor = ProfesorModel::findOrFail($id);
            $respuesta = array(
                'tipo' => 'ok',
                'profesor' => $profesor
            );
        }

        return response()->json($respuesta, 200);
    }

    public function Crear(Request $request)
    {
        Validator::make($request->all(), [
            'nombre' => ['required', 'min:4', 'max:50'],
            'documento' => ['required', 'min_digits:7', 'integer', Rule::unique('profesores', 'documento')],
            'telefono' => ['required', 'min_digits:10', 'max_digits:10', 'integer'],
            'email' => ['required', 'email', Rule::unique('profesores', 'email')],
            'direccion' => ['required', 'min:4', 'max:200'],
            'ciudad' => ['required', 'min:4', 'max:30']
        ])->validate();

        $profesor = new ProfesorModel();

        $profesor->nombre = $this->formato->inicialesMayuscula($request->nombre);
        $profesor->documento = trim($request->documento);
        $profesor->telefono = trim($request->telefono);
        $profesor->email = $this->formato->minusculas($request->email);
        $profesor->direccion = $this->formato->inicialesMayuscula($request->direccion);
        $profesor->ciudad = $this->formato->pirmeraMayuscula($request->ciudad);
        $profesor->creado = $this->fecha->toDateTimeLocalString();
        $profesor->save();

        return redirect()->route('profesor.index')->with('creado', true);
    }

    public function Editar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:profesores,id', 'integer'],
            'nombre' => ['required', 'min:4', 'max:50'],
            'documento' => ['required', 'min_digits:7', 'integer', Rule::unique('profesores', 'documento')->ignore($request->id)],
            'telefono' => ['required', 'min_digits:10', 'max_digits:10', 'integer'],
            'email' => ['required', 'email', Rule::unique('profesores', 'email')->ignore($request->id)],
            'direccion' => ['required', 'min:4', 'max:200'],
            'ciudad' => ['required', 'min:4', 'max:30']
        ])->validate();

        $profesor = ProfesorModel::findOrFail($request->id);

        $profesor->nombre = $this->formato->inicialesMayuscula($request->nombre);
        $profesor->documento = trim($request->documento);
        $profesor->telefono = trim($request->telefono);
        $profesor->email = $this->formato->minusculas($request->email);
        $profesor->direccion = $this->formato->inicialesMayuscula($request->direccion);
        $profesor->ciudad = $this->formato->pirmeraMayuscula($request->ciudad);
        $profesor->actualizado = $this->fecha->toDateTimeLocalString();
        $profesor->save();

        return redirect()->route('profesor.index')->with('actualizado', true);
    }

    public function Eliminar(Request $request)
    {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:profesores,id', 'integer']
        ])->validate();

        $profesor = ProfesorModel::findOrFail($request->id);
        $profesor->delete();

        return redirect()->route('profesor.index')->with('eliminado', true);
    }
}
