<?php

namespace app\Etl\Traits;

use App\Etl\Etl;
use App\Jobs\{EtlStationJob,EtlYesterdayJob};
use Facades\App\Repositories\DataWareHouse\StationDimRepository;
use Facades\App\Repositories\Administrator\{StationRepository,NetRepository};

trait BaseExecuteEtl
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
     * @var StationDimRepository
     */
    private $stationDimRepository;
    /**
     * @var NetRepository
     */
    private $netRepository;

    private $jobsActive = false;

    /**
     * BaseExecuteEtl constructor.
     * @param StationRepository $stationRepository
     * @param StationDimRepository $stationDimRepository
     * @param NetRepository $netRepository
     */
    function __construct(
        StationRepository $stationRepository,
        StationDimRepository $stationDimRepository,
        NetRepository $netRepository
    )
    {
        $this->stationRepository = $stationRepository;
        $this->stationDimRepository = $stationDimRepository;
        $this->netRepository = $netRepository;
    }

    /**
     * @param string $method
     * @param string $net
     * @param bool $sequence
     * @param bool $serialization
     * @param array $extract
     * @param array $transform
     * @param array $load
     * @param bool $jobs
     * @return array
     */
    public function executeOneNetAllStations(string $method, string $net, bool $sequence,bool $serialization,array $extract = [], array $transform = [], array $load = [],bool $jobs = false)
    {
        #obtener una estacion basado en un nombre de red
        $oneStationForNet = $this->stationDimRepository->getIdStationForName($net)->id;

        #obtener un id de estacion basado en un id de estacion
        $netId = $this->stationRepository->getIdNetForIdStation($oneStationForNet)->id;

        #obtener todas las estaciones de $netId
        $stationForNet = $this->stationRepository->getStationForNetEtlActive($netId);

        $response = [];

        foreach ($stationForNet as $station){
            $res = $this->executeOneStation($method, $station->net_id,  $station->id,$sequence,$serialization,$extract,$transform,$load,$jobs);
            $response[] = $res;
        }
        return $response;
    }

    /**
     * @param string $method
     * @param string|null $net
     * @param string $station
     * @param bool $sequence
     * @param bool $serialization
     * @param array $extract
     * @param array $transform
     * @param array $load
     * @param bool $jobs
     * @return array
     * @throws \ReflectionException
     */
    public function executeOneStation(
        string $method,
        string $net = null,
        string $station,
        bool $sequence = false,
        bool $serialization = false,
        array $extract = [],
        array $transform = [],
        array $load = [],
        bool $jobs = false
    )
    {
        $response = null;
        $this->jobsActive = $jobs;

        if($extract['method'] == 'Plane'){
            $response =  $this->dispatchJob($method, $net, $station,$sequence,$serialization,$extract,$transform,$load);
        }else{
            $spaceDays = $this->spaceDaysForFilter;
            $dateOne = date_create($extract['optionExtract']['initialDate']);
            $dateTwo = date_create($extract['optionExtract']['finalDate']);
            $countDays = date_diff($dateOne, $dateTwo)->days;
            $last = $countDays % $spaceDays;
            $control = intval($countDays / $spaceDays);
            $i = 0;
            $arr = [];
            while ($i <= $control)
            {
                if ($i == $control){$spaceDays = $last +1 ;}

                $extract['optionExtract']['initialDate'] = (clone ($dateOne))->format('Y-m-d');
                $dateFin = date_add(clone ($dateOne), date_interval_create_from_date_string('+'.$spaceDays -1 .' days'));
                $dateOne =  date_add(clone ($dateFin), date_interval_create_from_date_string('+1 days'));
                $extract['optionExtract']['finalDate'] = $dateFin->format('Y-m-d');

                $res = $this->dispatchJob($method, $net, $station,$sequence,$serialization,$extract,$transform,$load);
                $arr[] = $res;
                $i++;
            }
            $response = $arr;
        }

        return $response;
    }

    /**
     * @param string $method
     * @param string|null $net
     * @param string $station
     * @param bool $sequence
     * @param bool $serialization
     * @param array $extract
     * @param array $transform
     * @param array $load
     * @return array
     * @throws \ReflectionException
     */
    public function dispatchJob(string $method, string $net = null, string $station, bool $sequence, bool $serialization,array $extract = [], array $transform = [], array $load = [])
    {
        $work = null;
        $work2 = null;
        $arr =  ['execution' => 'asynchronous','work1' => null, 'work2' => null];
        switch ($method) {
            case "Filter":
                $work = $this->filterJob($net,null,intval($station),$sequence,$serialization,$extract,$transform,$load);
                break;
            case "Original":
                $work = $this->OriginalJob($net,null,intval($station),$sequence,$extract,$transform,$load);
                break;
            case "All":
                $work = $this->OriginalJob($net,null,intval($station),$sequence,$extract,$transform,$load);
                $work2 = $this->filterJob($net,null,intval($station),$sequence,$serialization,$extract,$transform,$load);
                break;
        }

        if ($this->jobsActive){
            if (!is_null($work)){ EtlStationJob::dispatch($work); $arr['work1'] = 'Se envio un trabajo a las pilas'; }
            if (!is_null($work2)){ EtlStationJob::dispatch($work2); $arr['work2'] = 'Se envio un trabajo a las pilas'; }
        }else{
            if (!is_null($work)){
                $work->run();
                $arr['execution'] = 'Synchronous'; $arr['work1'] = $work;
            }
            if (!is_null($work2)){
                $work2->run();
                $arr['execution'] = 'Synchronous'; $arr['work2'] = $work2;
            }
        }

        return $arr;
    }

    /**
     * @param string $method --- el metodo de quiera a ejecutar puede ser Firter, Original o ALL
     * @param bool $sequence --- Si es necesario que se actualise la tabla de control del ETL originalState o filterSate
     * @param bool $serialization
     * @param array $extract
     * @param array $transform
     * @param array $load
     * @param bool $jobs --- true determina que se ejecuta en una pila asincrona, false para ejecusion en  formato sincrono
     * @return array
     * @throws \ReflectionException
     */

    public function executeAllStations(string $method, bool $sequence, bool $serialization,array $extract = [], array $transform = [], array $load = [],bool $jobs)
    {
        $stationEtlTrue = $this->stationRepository->getStationsForEtl();
        $arr= []; $response = null;
        foreach ($stationEtlTrue as $station){
            $response = $this->executeOneStation($method, $station->net_id,  $station->id, $sequence,$serialization,$extract,$transform,$load,$jobs);
            $arr[] = $response;
        }

        return $arr;
    }

    /**
     * @param null $net
     * @param null $connection
     * @param $station
     * @param bool $sequence
     * @param bool $serialization
     * @param array $extract
     * @param array $transform
     * @param array $load
     * @return Etl
     * @throws \ReflectionException
     */
    public function filterJob(
        $net = null,
        $connection = null,
        $station,
        bool $sequence = false,
        bool $serialization = false,
        array $extract = [],
        array $transform = [],
        array $load = []
    )# array $extractOptions,bool $serialization,bool $detection,bool $correction
    {
        $etl = Etl::start('Filter', $net, $connection,$station,['sequence'=> $sequence]);

         if (!array_key_exists('extractType', $extract['optionExtract']) and $extract['method'] != 'Plane'){
             $extract['optionExtract']['extractType'] = 'Local';
         }

         $etl->extract($extract['method'],$extract['optionExtract']);

         if (count($transform) == 0){

            $etl->transform('FilterDetection');

            if ($serialization){ $etl->transform('Serialization'); }

            $etl->transform('FilterCorrection');

         }else{
             foreach ($transform as $trans){
                 $etl->transform($trans['method'],$trans['optionTransform']);
             }

             if ($serialization){ $etl->transform('Serialization'); }

         }

         if (count($load) == 0){ $etl->load(); } else { $etl->load($load['method'],$load['optionLoad']);}

        return $etl;
    }

    /**
     * @param null $net
     * @param null $connection
     * @param $station
     * @param bool $sequence
     * @param array $extract
     * @param array $transform
     * @param array $load
     * @return Etl
     * @throws \ReflectionException
     */
    public function OriginalJob(
        $net = null,
        $connection = null,
        $station,
        bool $sequence,
        array $extract = [],
        array $transform = [],
        array $load = []
    )//array $extractOptions,bool $serialization,bool $detection,bool $correction
    {
        $etl = Etl::start('Original', $net, $connection,$station,['sequence'=> $sequence]);

        if (!array_key_exists('extractType', $extract['optionExtract']) and $extract['method'] != 'Plane'){
            $extract['optionExtract']['extractType'] = 'External';
        }

        $etl->extract($extract['method'],$extract['optionExtract']);

        if (empty($transform)){
            $etl->transform('Original');
        }else{
            foreach ($transform as $trans){
                $etl->transform($trans['method'],$trans['optionTransform']);
            }
        }

        if (empty($load)){ $etl->load(); } else { $etl->load($load['method'],$load['optionLoad']);}

        return $etl;
    }

    /**
     *
     */
    public function executeAllOriginalYesterday()
    {
        $jobs = true;
        $trustProcess = false; # TODO : Esto debe ser true
        $sequence = false; # TODO : Esto debe ser true
        $serialization = false; # TODO
        $date = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string('-1 days'))->format('Y-m-d');
        $stations = $this->stationRepository->getStationsForOriginalETL();

        foreach ($stations as $station)
        {
            $this->executeOneStation(
                'Original',
                $station->net_id,
                $station->id,
                $sequence,
                $serialization,
                ['method' => 'Database', 'optionExtract' => ['trustProcess'=> $trustProcess,'extractType' => 'External', 'initialDate' => $date,'initialTime' => '00:00:00','finalDate' =>  $date,'finalTime' => '23:59:59']],
                [],
                [],
                $jobs
            );
        }
    }

    /**
     *
     */
    public function executeAllFilterYesterday()
    {
        $jobs = true;
        $trustProcess = true; # TODO : Esto debe ser true
        $sequence = false; # TODO : Esto debe ser true
        $serialization = true; #TODO
        $date = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string('-1 days'))->format('Y-m-d');
        $stations = $this->stationRepository->getStationsForFilterETL();

        foreach ($stations as $station)
        {
            $this->executeOneStation(
                'Filter',
                $station->net_id,
                $station->id,
                $sequence,
                $serialization,
                ['method' => 'Database','optionExtract' =>['trustProcess'=> $trustProcess,'extractType' => 'Local', 'initialDate' => $date,'initialTime' => '00:00:00','finalDate' =>  $date,'finalTime' => '23:59:59']],
                [],
                [],
                $jobs
            );
        }
    }

    public function executeTestJob()
    {
        EtlYesterdayJob::dispatch();
    }

}