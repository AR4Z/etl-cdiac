<?php

namespace App\Http\Controllers\Etl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Etl\Traits\BaseExecuteEtl;

class ExecuteEtlController extends Controller
{
    use BaseExecuteEtl;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->executeTestJob();
        //$differentNetName = $this->netRepository->getNetName();
        //$differentNetName[0] = '---------- TODAS LAS REDES ------------ ';
        //return view('etl.indexEtl',compact('differentNetName'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStationsForNet(Request $request)
    {
        $data = $request['id'];
        #no retornar nada cuando el parametro enviado es null
        if (is_null($data)){return;}
        #obtener las estaciones dependiando de la red
        $stations =  ($data == 0) ? $this->stationRepository->getStationEtlActive() : $this->stationRepository->getStationForNetEtlActive($data);

        #insertar la opcion de incluir las estaciones
        $flag = count($stations)+1;
        $stations[$flag] = clone $stations[0];
        $stations[$flag]->id = 0;
        $stations[$flag]->name = '---------- TODAS LAS ESTACIONES ------------ ';

        return $stations;
    }

    /**
     * @param Request $request
     */
    public function redirectionEtlFilter(Request $request)
    {
        $data = $request->all();

        $data['sequence'] = true; #(ESTO DEBE CAMBIAR) actualmente todas las estaciones tienen secuencia

        if ($data['net_name'] == 0){
            if ($data['station_id'] == 0){
                $this->executeAllStations($data['method'],$data['start'],$data['end'],$data['sequence']);
            }else{
                $this->executeOneStation($data['method'],null,$data['station_id'],$data['start'],$data['end'],$data['sequence']);
            }
        }else{
            if ($data['station_id'] == 0){
                $this->executeOneNetAllStations($data['method'],$data['net_name'],$data['station_id'],$data['start'],$data['end'],$data['sequence']);
            }else{
                $this->executeOneStation($data['method'],null,$data['station_id'],$data['start'],$data['end'],$data['sequence']);
            }
         }

        dd('stop final');
    }


    public function executeResetStation()
    {

    }

    public function executeResetAllStations()
    {

    }

    public function executeRollbackStation()
    {

    }

    public function executeRollbackAllStations()
    {

    }

    public function executeRefreshStation()
    {

    }

    public function executeRefreshAllStations()
    {

    }


}
