<?php

namespace App\Http\Controllers\Etl;

use App\Etl\Execution\EtlExecute;
use App\Repositories\Administrator\NetRepository;
use App\Repositories\Administrator\StationRepository;
use App\Repositories\DataWareHouse\StationDimRepository;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExecuteEtlController extends Controller
{
    /**
     * @var StationRepository
     */
    private $stationRepository;
    /**
     * @var StationDimRepository
     */
    private $stationDimRepository;
    /**
     * @var NetRepository
     */
    private $netRepository;

    /**
     * PlaneEtlController constructor.
     * @param StationRepository $stationRepository
     * @param StationDimRepository $stationDimRepository
     * @param NetRepository $netRepository
     */
    public function __construct(
        StationRepository $stationRepository,
        StationDimRepository $stationDimRepository,
        NetRepository $netRepository)
    {
        $this->stationRepository = $stationRepository;
        $this->stationDimRepository = $stationDimRepository;
        $this->netRepository = $netRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $nets = $this->netRepository->getNetsForServerAcquisition();
        return view('etl.indexEtl',compact('nets'));
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

        $object = $this->optionalStationInAllNets(1);

        dd($object);


        $jobs = false; # TODO : Debe entrar por parametro
        $data = $request->all();
        $data['sequence'] = true; # TODO: Dede entrar por parametro
        $data['trustProcess'] = false; # TODO: Debe entrar por parametro
        $data['serialization'] = false; # TODO: Debe entrar por parametro

        $extract = ['method' => 'Database','optionExtract' => ['trustProcess'=> $data['trustProcess'], 'initialDate' => $data['start'],'initialTime' => '00:00:00','finalDate' =>  $data['end'],'finalTime' => '23:59:59']];
        $transform = [];
        $load = [];
        if ($data['net_name'] == 0){
            if ($data['station_id'] == 0){
                $response = $this->executeAllStations($data['method'],$data['sequence'],$data['serialization'],$extract,$transform,$load,$jobs);
            }else{
                $response = $this->executeOneStation($data['method'],null,$data['station_id'],$data['sequence'],$data['serialization'],$extract,$transform,$load,$jobs);
            }
        }else{
            if ($data['station_id'] == 0){
                $response = $this->executeOneNetAllStations($data['method'],$data['net_name'],$data['sequence'],$data['serialization'],$extract,$transform,$load,$jobs);
            }else{
                $response = $this->executeOneStation($data['method'],null,$data['station_id'], $data['sequence'],$data['serialization'],$extract,$transform,$load,$jobs);
            }
         }

        dd('stop final',$response);
    }

    /**
     *  init
     * @param int $net
     * @return array
     */

    public function optionalStationInAllNets(int $net) :array
    {
        $stationsWeather = $this->stationRepository->getStationsId($net,'weather');
        $stationsAir = $this->stationRepository->getStationsId($net,'air');
        $stationsGroundwater = $this->stationRepository->getStationsId($net,'groundwater');

        dd($stationsWeather,$stationsAir,$stationsGroundwater);
    }

    /**
     * end
     */


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
