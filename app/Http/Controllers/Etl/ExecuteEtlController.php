<?php

namespace App\Http\Controllers\Etl;

use Facades\App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Etl\Etl;
use App\Jobs\EtlStationJob;
use PhpParser\Node\Expr\Array_;

class ExecuteEtlController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $differentNetName = StationDimRepository::getDifferentNetName();
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
        $stations = ($data == 'ALL') ? StationDimRepository::getIdAndNameStations() : StationDimRepository::getStationsForNet($data);
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
                $this->executeAllStations($data['method'],$data['start'],$data['end'],$data['sequence']);
            }else{
                $this->executeOneStation($data['method'],null,$data['station_id'],$data['start'],$data['end'],$data['sequence']);
            }
        }else{
           $this->executeOneStation($data['method'],null,$data['station_id'],$data['start'],$data['end'],$data['sequence']);
        }

    }

    public function executeOneStation(string $method,string $net = null,string $station,string $initialDate,string $finalDate,bool $sequence)
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
            //EtlStationJob::dispatch($work);
            $work->run();
        }

        if (!is_null($work2)){
            //EtlStationJob::dispatch($work);
            $work2->run();
        }

        dd($work,$work2);
    }

    public function executeAllStations(string $method, string $initialDate,string $finalDate,bool $sequence)
    {
        dd('entre all stations');

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
        return Etl::start('Filter', $net, $connection,$station,$sequence)
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
        return Etl::start('Original', $net, $connection,$station,$sequence)
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
