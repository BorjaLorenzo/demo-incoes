<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_workers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Workers extends Controller
{
    //
    protected $workers;

    public function __construct()
    {
        $this->workers = new M_workers();
    }

    public function mainView()
    {
        Auth::user()->rol = 'new';
        if (Auth::user()->rol == 'root') {
            return view('personalMainView', ['test' => $this->workers->getWorkersAll(), 'rol' => Auth::user()->rol]);
        } else {
            return view('personalMainView', ['test' => $this->workers->getWorkersAllByClient(Auth::user()->company), 'rol' => Auth::user()->rol]);
        }
    }

    public function getWorker(Request $request)
    {
        $request->validate([
            'dni' => 'required'
        ]);

        return response()->json($this->workers->getWorkerSimple($request->dni)[0]);
    }

    public function deleteWorker(Request $request)
    {
        $request->validate([
            'dni' => 'required'
        ]);

        return response()->json($this->workers->deleteWorker($request->dni));
    }

    public function RefrescarDatatableWorkers()
    {

        $rol = Auth::user()->rol;

        if ($rol == "root") {
            $workers = $this->workers->getWorkersAll();
        } else {
            $workers = $this->workers->getWorkersAllByClient(Auth::user()->company);
        }
        return response()->json($workers);
    }

    public function editarTrabajador(Request $request)
    {
        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'sex' => 'required',
            'phone' => 'required',
            'dni_type' => 'required',
            'dni' => 'required',
            'dni_old' => 'required',
            'country' => 'required',
            'email' => 'required|email',
            'rol' => 'required',
        ]);

        // Comprobar si la validación ha fallado
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        $consulta = $this->workers->updateWorker($request->all());

        return response()->json($consulta);
    }
}
