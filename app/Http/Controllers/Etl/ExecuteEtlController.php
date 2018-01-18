<?php

namespace App\Http\Controllers\Etl;

use App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Etl\Etl;
use App\Jobs\EtlStationJob;
use App\Repositories\Administrator\StationRepository;

class ExecuteEtlController extends Controller
{
    /**
     * valor que controla los espacios entre las fechas a filtrar (esto puede ser un parametro en el futuro)
     * @var int
     */
    private $spaceDaysForFilter = 15;
    /**
     * @var StationRepository
     */
    private $stationRepository;
    /**
     * @var \App\Http\Controllers\Etl\StationDimRepository
     */
    private $stationDimRepository;


    public function __construct(StationRepository $stationRepository,StationDimRepository $stationDimRepository)
    {
        $this->stationRepository = $stationRepository;
        $this->stationDimRepository = $stationDimRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $differentNetName = $this->stationDimRepository->getDifferentNetName();
        $differentNetName['ALL'] = '---------- TODAS LAS REDES ------------ ';
        return view('etl.indexEtl',compact('differentNetName'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStationsForNet(Request $request)
    {
        $data = $request['net_name'];
        $stations = ($data == 'ALL') ? $this->stationDimRepository->getIdAndNameStations() : $this->stationDimRepository->getStationsForNet($data);
        $flag = count($stations)+1;
        $stations[$flag] = clone $stations[0];
        $stations[$flag]->id = 0;
        $stations[$flag]->name = '---------- TODAS LAS ESTACIONES ------------ ';

        return $stations;
    }

    public function redirectionEtlFilter(Request $request)
    {
        $data = $request->all();

        $data['sequence'] = true; // (ESTO DEBE CAMBIAR) actualmente todas las estaciones tienen secuencia

        if ($data['net_name'] == "ALL"){
            if ($data['station_id'] == 0){
                dd('escoji todas las estaciones todas las redes');
                $this->executeAllStations($data['method'],$data['start'],$data['end'],$data['sequence']);
            }else{
                dd('escogi una estacion de todas las estaciones');
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
    public function executeOneNetAllStations(string $method, string $net, string $station, string $initialDate, string $finalDate, bool $sequence)
    {
        #obtener una estacion basado en un nombre de red
        $oneStationForNet = $this->stationDimRepository->getIdStationForName($net)->id;

        #obtener un id de estacion basado en un id de estacion
        $netId = $this->stationRepository->getIdNetForIdStation($oneStationForNet)->id;

        #obtener todas las estaciones de $netId
        $stationForNet = $this->stationRepository->getStationForNetEtlActive($netId);

        foreach ($stationForNet as $station){
            $this->executeOneStation($method,  $station->owner_net_id,  $station->id,  $initialDate,  $finalDate,  $sequence);
        }
    }

    /**
     * @param string $method
     * @param string|null $net
     * @param string $station
     * @param string $initialDate
     * @param string $finalDate
     * @param bool $sequence
     */
    public function executeOneStation(string $method, string $net = null, string $station, string $initialDate, string $finalDate, bool $sequence)
    {
        $spaceDays = $this->spaceDaysForFilter;
        $dateOne = date_create($initialDate);
        $dateTwo = date_create($finalDate);
        $countDays = date_diff($dateOne, $dateTwo)->days;
        $last = $countDays % $spaceDays;
        $control = intval($countDays / $spaceDays);
        $i = 0;
        while ($i <= $control)
        {
            if ($i == $control){$spaceDays = $last +1 ;}

            $dateInit = (clone ($dateOne))->format('Y-m-d');
            $dateFin = date_add(clone ($dateOne), date_interval_create_from_date_string('+'.$spaceDays -1 .' days'));
            $dateOne =  date_add(clone ($dateFin), date_interval_create_from_date_string('+1 days'));
            $dateFin = $dateFin->format('Y-m-d');

            $this->dispatchJob($method, $net, $station,  $dateInit,  $dateFin,  $sequence);
            $i++;
        }
    }

    public function dispatchJob(string $method, string $net = null, string $station, string $initialDate, string $finalDate, bool $sequence)
    {
        $work = null;
        $work2 = null;

        switch ($method) {
            case "Filter":
                $work = $this->filterJob($net,null,intval($station),$initialDate, $finalDate,$sequence);
                break;
            case "Original":
                $work = $this->OriginalJob($net,null,intval($station),$initialDate, $finalDate,$sequence);
                break;
            case "All":
                $work = $this->OriginalJob($net,null,intval($station),$initialDate, $finalDate,$sequence);
                $work2 = $this->filterJob($net,null,intval($station),$initialDate, $finalDate,$sequence);
                break;
        }

        if (!is_null($work)){
            EtlStationJob::dispatch($work);
            //$work->run();
        }

        if (!is_null($work2)){
            EtlStationJob::dispatch($work2);
            //$work2->run();
        }
    }

    public function executeAllStations(string $method, string $initialDate,string $finalDate,bool $sequence)
    {
        $stationEtlTrue = $this->stationRepository->getStationsForEtl();
        foreach ($stationEtlTrue as $station){
            $this->executeOneStation($method, $station->owner_net_id,  $station->id,  $initialDate,  $finalDate,  $sequence);
        }
    }

    /**
     * @param null $net
     * @param null $connection
     * @param $station
     * @param string $initialDate
     * @param string $finalDate
     * @param bool $sequence
     * @return Etl
     */
    public function filterJob($net = null, $connection = null, $station, string $initialDate, string $finalDate, bool $sequence)//array $extractOptions,bool $serialization,bool $detection,bool $correction
    {
        $etl = new Etl();

        return $etl->start('Filter', $net, $connection,$station,$sequence)
                ->extract('Database',['trustProcess'=> true,'extractType' => 'Local', 'initialDate' => $initialDate,'initialTime' => '00:00:00','finalDate' =>  $finalDate,'finalTime' => '23:59:59'])
                ->transform('Serialization')
                ->transform('FilterDetection')
                ->transform('FilterCorrection')
                ->load();
    }

    /**
     * @param null $net
     * @param null $connection
     * @param $station
     * @param string $initialDate
     * @param string $finalDate
     * @param bool $sequence
     * @return Etl
     */
    public function OriginalJob($net = null, $connection = null, $station, string $initialDate, string $finalDate, bool $sequence)//array $extractOptions,bool $serialization,bool $detection,bool $correction
    {
        $etl = new Etl();

        return $etl->start('Original', $net, $connection,$station,$sequence)
                ->extract('Database',['trustProcess'=> false,'extractType' => 'External', 'initialDate' => $initialDate,'initialTime' => '00:00:00','finalDate' =>  $finalDate,'finalTime' => '23:59:59'])
                ->transform('Original')
                ->load();
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
