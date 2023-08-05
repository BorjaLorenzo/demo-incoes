<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class M_workers extends Model
{
    use HasFactory;

    public function getWorkersAll()
    {
        $workers = DB::table('users')
            ->select('dni', 'name', 'surname', 'phone', 'rol', 'company', 'activo')
            ->get();
        return $workers;
    }
    public function getWorkersAllByClient($clientCompanyID)
    {
        $workers = DB::table('users')
            ->select('dni', 'name', 'surname', 'phone', 'rol', 'activo')
            ->where('company', $clientCompanyID)
            ->get();
        return $workers;
    }
    public function getWorkerSimple($workerID)
    {
        $workers = DB::table('users')
            ->select('*')
            ->where('dni', $workerID)
            ->get();
        return $workers;
    }
    public function getWorkerSimpleByClient($clientID, $workerID)
    {
    }
    public function deleteWorker($dni)
    {
        $affected = DB::table('users')
            ->where('dni', $dni)
            ->update(['activo' => 1]);

        return $affected > 0;
    }
    public function updateWorker($data)
    {
        $affected = DB::table('users')
            ->where('dni', $data['dni_old'])
            ->update([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'sex' => $data['sex'],
                'phone' => $data['phone'],
                'identification' => $data['dni_type'],
                'dni' => $data['dni'],
                'country' => $data['country'],
                'email' => $data['email'],
                'rol' => $data['rol'],
            ]);
        return $affected > 0;
    }

    public function getHolidays($dni)
    {
        $vacaciones = DB::table('vacaciones')
            ->where('dni', $dni)
            ->where('activo', 0)
            ->get();

        return $vacaciones;
    }

    public function setHolidays($inicio, $fin, $dni)
    {
        $fechaActual = date("Y-m-d");
        $resultado = DB::table('vacaciones')->insert([
            'fecha_inicio' => $inicio,
            'fecha_fin' => $fin,
            'dni' => $dni,
            'created_at' => $fechaActual,
            'activo' => 0
        ]);
        return $resultado;
    }

    public function deleteHolidays($dni, $id_fila)
    {
        $affected = DB::table('vacaciones')
            ->where('dni', $dni)
            ->where('id', $id_fila)
            ->update(['activo' => 1]);

        // $queryLog = DB::getQueryLog();
        // $ultimaQuery = end($queryLog);
        // var_dump($ultimaQuery);
        return $affected > 0;
    }

    public function addTrabajador($data){
        return DB::table('users')->insert($data);
    }

    public function checkDNI($dni,$identificacion){

        $query = DB::table('users');
        $query->where('dni', $dni)->where('identification', $identificacion)->where('activo', 0);
        // $sql = $query->toSql();
        // var_dump($dni,$identificacion);
        $count = $query->count();
        return $count > 0;
    }
    public function getWorkersAllByClientForExcel($clientCompanyID)
    {
        if (Auth::user()->rol=="root") {
            $workers = DB::table('users')
            ->select('*')
            ->get();
        } else {
            $workers = DB::table('users')
            ->select('dni', 'name', 'surname','email', 'phone', 'rol', 'activo','created_at','identification','country')
            ->where('company', $clientCompanyID)
            ->get();
        }
        return $workers;
    }
}
