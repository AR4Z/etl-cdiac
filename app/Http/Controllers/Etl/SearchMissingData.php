<?php

namespace App\Http\Controllers\Etl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Administrator\StationRepository;
use App\Etl\Traits\DateSkTrait;
use DB;

class SearchMissingData extends Controller
{
    use DateSkTrait;
    /**
     * @var StationRepository
     */
    private $stationRepository;

    /**
     * Datos esperados para las estaciones
     */
    private $expectedData = 288;

    /**
     * SearchMissingData constructor.
     * @param StationRepository $stationRepository
     */
    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        #return view('etl.index',compact('differentNetName'));
        return view('searchMissing.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchData(Request $request)
    {
        $incoming = $request->all();
        $data = [];
        if ($incoming['station_id'] == 0){
            $stations = $this->stationRepository->getIdStationsForTypology($incoming['type_station']);
            foreach ($stations as $station_id){
                $temp = $this->getMissingDataForStation($incoming['fact_table'],$station_id);
                $data = array_merge($data,$temp);
            }
        }else{
            $data = $this->getMissingDataForStation($incoming['fact_table'],$incoming['station_id']);
        }

        $data = $this->completeStatisticalInformation($data);

        return view('searchMissing.result',['fact_table' => $request['fact_table'], 'missingArray'=> $data]);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function stationsForFactTable(Request $request)
    {
        $type_station = $request->get('type_station');
        $data = $this->stationRepository->getStationsForTypology($type_station);

        if (!is_null($data) and $type_station == "groundwater"){
            $data[count($data)] = ['id' => 0, 'name' => '------ TODAS LAS ESTACIONES ---- '];
        }

        return $data;
    }

    /**
     * @param $fact_table
     * @param $station_id
     * @return mixed
     */
    private function getMissingDataForStation($fact_table, $station_id)
    {
        $data = $this->stationRepository->countMissingDataForStation($fact_table,$station_id);

        if (count($data) == 0){ dd('Error no hay datos para la estacion '.$station_id.' en la '.$fact_table);}

        $initial = $data[0]->date_sk;
        $final = (end($data))->date_sk;

        if ( ($final - $initial + 1 )  == count($data)){ return $data;}

        $element = 0;
        for ($i = $initial; $i <= $final; $i++) {
            if ($data[$element]->date_sk != $i){
                $data = $this->InsertObjectInArrayPosition($data,['station_sk' => $station_id, 'name' => $data[0]->name, 'date_sk' => $i, 'date'=>null, 'count' => 0],$element);
            }
            $element++;
        }

        return $data;
    }

    /**
     * @param array $array
     * @param array $value
     * @param int $position
     * @return array|bool
     */
    private function InsertObjectInArrayPosition(array $array, array $value, int $position)
    {
        $value = (object)$value;
        if($position > count($array) || $position < 0) {return false;}
        if($position == count($array)) {$array[] = $value; return $array;}
        $newArray = array();
        for($i=0;$i<count($array);$i++) {
            if($i == $position){ $newArray[] = $value;}
            $newArray[] = $array[$i];
        }
        return $newArray;
    }

    /**
     * @param $dates
     * @return mixed
     */
    private function completeStatisticalInformation($dates)
    {
        foreach ($dates as $data){
            if ($data->count == 0){ $data->date = $this->calculateDateFromDateSk($data->date_sk); }
            $data->recoveredPercentage = round ($data->count / $this->expectedData * 100,2);
            $data->missingPercentage = round (100 - $data->recoveredPercentage,2);
        }
        return $dates;
    }
}
