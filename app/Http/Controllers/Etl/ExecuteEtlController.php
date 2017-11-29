<?php

namespace App\Http\Controllers\Etl;

use Facades\App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $station = new StationDimRepository();
        $station->id = 0;
        $station->name = '---------- TODAS LAS ESTACIONES ------------ ';

        dd($station);

        return $stations;
    }

    public function executeOneStation()
    {

    }

    public function executeAllStations()
    {

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
