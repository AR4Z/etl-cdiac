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
        //$this->executeTestJob();
        $differentNetName = $this->netRepository->getNetName();
        $differentNetName[0] = '---------- TODAS LAS REDES ------------ ';
        return view('etl.indexEtl',compact('differentNetName'));
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
        $jobs = false; # TODO : Debe entrar por parametro
        $data = $request->all();
        $data['sequence'] = true; # TODO: Dede entrar por parametro
        $data['trustProcess'] = false; # TODO: Debe entrar por parametro

        $extract = ['method' => 'Database','optionExtract' => ['trustProcess'=> $data['trustProcess'], 'initialDate' => $data['start'],'initialTime' => '00:00:00','finalDate' =>  $data['end'],'finalTime' => '23:59:59']];
        $transform = [];
        $load = [];
        if ($data['net_name'] == 0){
            if ($data['station_id'] == 0){
                $response = $this->executeAllStations($data['method'],$data['sequence'],$extract,$transform,$load,$jobs);
            }else{
                $response = $this->executeOneStation($data['method'],null,$data['station_id'],$data['sequence'],$extract,$transform,$load,$jobs);
            }
        }else{
            if ($data['station_id'] == 0){
                $response = $this->executeOneNetAllStations($data['method'],$data['net_name'],$data['sequence'],$extract,$transform,$load,$jobs);
            }else{
                $response = $this->executeOneStation($data['method'],null,$data['station_id'], $data['sequence'],$extract,$transform,$load,$jobs);
            }
         }

        dd('stop final',$response);
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
