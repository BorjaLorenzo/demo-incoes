<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_workers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Validation\Rules;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\PDFEmail;
use Exception;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Workers extends Controller
{
    //
    protected $workers;

    public function __construct()
    {
        $this->workers = new M_workers();
    }

    public function dashboard()
    {
        //Auth::user()->rol = 'new';
        return view("dashboard", ['rol' => Auth::user()->rol]);
    }
    public function mainView()
    {
        Auth::user()->rol = 'new';
        if (Auth::user()->rol == 'root') {
            return view('personalMainView', ['test' => $this->workers->getWorkersAll(), 'rol' => Auth::user()->rol]);
        } else {
            return view('personalMainView', ['test' => $this->workers->getWorkersAllByClient(Auth::user()->company, Auth::user()->dni), 'rol' => Auth::user()->rol]);
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
        //Auth::user()->rol = 'new';

        if (Auth::user()->rol == "root") {
            $workers = $this->workers->getWorkersAll();
        } else {
            $workers = $this->workers->getWorkersAllByClient(Auth::user()->company, Auth::user()->dni);
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
    public function getVacaciones(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dni = $request->input('dni');

        $vacaciones = $this->workers->getHolidays($dni);
        return response()->json($vacaciones);
    }
    public function setVacaciones(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inicio' => 'required',
            'fin' => 'required',
            'dni' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dni = $request->input('dni');
        $vacaciones = $this->workers->getHolidays($dni);
        $interruptor = false;

        $coinciden = false;

        $fechasCoincidentes = [];

        $fechaInicio1 = $request->input('inicio');
        $fechaFin1 = $request->input('fin');

        $A = new DateTime($fechaInicio1);
        $B = new DateTime($fechaFin1);

        foreach ($vacaciones as $key => $v) {
            $fechaInicio2 = $v->fecha_inicio;
            $fechaFin2 = $v->fecha_fin;

            $C = new DateTime($fechaInicio2);
            $D = new DateTime($fechaFin2);

            // Se solapan?
            $C_entre = $C >= $A && $C <= $B;
            $D_entre = $D >= $A && $D <= $B;
            $CD_contiene = $C <= $A && $D >= $B;

            if ($C_entre || $D_entre || $CD_contiene) {
                $coinciden = true;
                break;
            }
        }


        if ($coinciden) {
            return -1;
        } else {
            $resultado = $this->workers->setHolidays($request->input('inicio'), $request->input('fin'), $request->input('dni'));

            if ($resultado) {
                return response()->json(['message' => 'Registro insertado correctamente'], 200);
            } else {
                return response()->json(['error' => 'Error al insertar el registro'], 500);
            }
        }
    }

    public function removeVacaciones(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required',
            'dias' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            $dias = $request->input('dias');
            $dni = $request->input('dni');

            foreach ($dias as $id) {
                //echo $id;
                $this->workers->deleteHolidays($dni, $id);
            }
            return response()->json(['success' => 0]);
        }
    }

    public function addTrabajador(Request $request)
    {

        $validator = Validator::make($request->all(), [ //aqui poner la validacion de lo que devuelve el formulario para saber si los campos estan bien con respecto a si son int, string, email, etc

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'surname' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'rol' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'surname' => $request->input('surname'),
            'identification' => $request->input('identification'),
            'dni' => $request->input('dni'),
            'country' => $request->input('country'),
            'phone' => $request->input('phone'),
            'rol' => $request->input('rol'),
            'activo' => '0',
            'company' => Auth::user()->company,
            'sex' => $request->input('sex'),
        ];


        $retorno = $this->workers->addTrabajador($userData);
        if (!$retorno) {
            echo "false";
        } else {
            echo "true";
        }
    }
    public function checkDNI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $retorno = $this->workers->checkDNI($request->input('dni'), $request->input('identificacion'));
        echo $retorno ? 'true' : 'false';
    }
    public function getExcelTrabajadores()
    {
        // Crea un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();

        // Obtiene la hoja activa del Spreadsheet
        $hoja = $spreadsheet->getActiveSheet();

        // Define los encabezados
        $hoja->setCellValue('A1', 'Nombre');
        $hoja->setCellValue('B1', 'Apellidos');
        $hoja->setCellValue('C1', 'Teléfono');
        $hoja->setCellValue('D1', 'DNI');
        $hoja->setCellValue('E1', 'Identificacion');
        $hoja->setCellValue('F1', 'Email');
        $hoja->setCellValue('G1', 'Cargo');
        $hoja->setCellValue('H1', 'Alta');
        $hoja->setCellValue('I1', 'Pais');
        $hoja->setCellValue('J1', 'Baja');

        $retorno = $this->workers->getWorkersAllByClientForExcel(Auth::user()->company, Auth::user()->rol);

        // Obtiene los datos que deseas exportar (suponiendo que tienes un array llamado $datos)
        $datos = [
            ['Juan', 'Pérez', '123456789', '12345678A'],
            ['María', 'López', '987654321', '87654321B'],
            // Agrega aquí los datos que desees exportar
        ];
        // Agrega los datos a la hoja de cálculo
        $row = 2;
        foreach ($retorno as $dato) {
            $hoja->setCellValue('A' . $row, $dato->name);
            $hoja->setCellValue('B' . $row, $dato->surname);
            $hoja->setCellValue('C' . $row, $dato->phone);
            $hoja->setCellValue('D' . $row, $dato->dni);
            $hoja->setCellValue('E' . $row, $dato->identification);
            $hoja->setCellValue('F' . $row, $dato->email);
            $hoja->setCellValue('G' . $row, $dato->rol);
            $hoja->setCellValue('H' . $row, $dato->created_at);
            $hoja->setCellValue('I' . $row, $dato->country);
            $hoja->setCellValue('J' . $row, $dato->activo);
            $row++;
        }

        // Crea un objeto Writer para guardar el archivo en formato xlsx
        $writer = new Xlsx($spreadsheet);

        // Nombre del archivo que deseas darle
        $nombreArchivo = 'archivo_personalizado.xlsx';

        // Configura las cabeceras para descargar el archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');

        // Guarda el archivo en la respuesta del controlador
        $writer->save('php://output');
    }

    public function generarPDFListaPersonal(Request $request)
    {

        try {
            //set_time_limit(120);
            $personas = $this->workers->getWorkersAllByClientForExcel(Auth::user()->company, Auth::user()->rol)->toArray();
            $data = ['personas' => $personas];

            $pdf = PDF::loadView('pdf.tabla_pdf', $data);
            $pdf->set_option('dpi', 256);
            // Guardar el PDF en el directorio de almacenamiento temporal
            $tempPdfPath = sys_get_temp_dir() . '/lista_personas.pdf';
            $pdf->save($tempPdfPath);

            $validator = new EmailValidator();

            
            if ($validator->isValid($request->input('email'), new RFCValidation())) {
                //echo "El correo electrónico es válido.";
            } else {
                //echo "El correo electrónico no es válido.";
            }

            // Enviar el correo con el PDF adjunto
            if ($request->input('email') == null) {
                Mail::to(Auth::user()->email)->send(new PDFEmail($tempPdfPath));
            } else {
                Mail::to($request->input('email'))->send(new PDFEmail($tempPdfPath));
            }


            // Eliminar el archivo temporal
            unlink($tempPdfPath);

            return response()->json(['message' => 'Correo con PDF adjunto enviado correctamente.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'error','statusText'=>$e->getMessage(),500]);
        }
    }
}
