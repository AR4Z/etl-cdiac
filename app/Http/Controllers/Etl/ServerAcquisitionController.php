<?php

namespace App\Http\Controllers\Etl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facades\App\Repositories\Administrator\StationRepository;
use App\Etl\Database\DatabaseConfig;
use Illuminate\Support\Facades\DB;

class ServerAcquisitionController extends Controller
{
    use DatabaseConfig;

    private $connectionDefault = 'server_external_consult';

    public function index()
    {
        $stations = StationRepository::getStationInServerAcquisition();
        $listStation = [];
        foreach ($stations as $station){$listStation[$station->id]= $station->name;}
        return view('serverAcquisition.index',compact('stations','listStation'));
    }

    public function searchData(Request $request)
    {
        $data = $request->all();
        $station = StationRepository::find($data['station_id']);
        if (!$this->connectionServerAcquisition($station->net->connection,$station->table_db_name)){
            #Retornar Error (No se pudo establecer coneccion para esta estacion)
            dd('No fue posible establecer la coneccion');
        }
        $keys = ['fecha','hora'];
        foreach ($station->variables as $variable){array_push($keys,$variable->database_field_name );}

        $externalData= $this->queryBuilderDefault($station->table_db_name)
                            ->select($keys)
                            ->whereBetween('fecha',[$data['start'],$data['end']])
                            ->get();
        return view('serverAcquisition.result')->with(['externalData' => $externalData, 'search' => $data , 'station' => $station, 'keys'=> $keys]);
    }

    private function connectionServerAcquisition($connection,$table)
    {
        # Realizar la conexion usando el trait DatabaseConnection
        return $this->searchExternalConnection($connection,$table,$this->connectionDefault);
    }

    private function queryBuilderDefault($table)
    {
        return DB::connection($this->connectionDefault)->table($table);
    }
}
