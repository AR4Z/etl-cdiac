<?php

namespace App\Http\Controllers\Etl;

use App\Http\Controllers\Controller;
use Facades\App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;

class PlaneEtlController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $differentNetName = StationDimRepository::getDifferentNetName();
        return view('etl.index',compact('differentNetName'));
    }

    /**
     * @return mixed
     */
    public function getDifferentNetName()
    {
        return StationDimRepository::getDifferentNetName();
    }

    public function getStationsForNet(Request $request)
    {
        return StationDimRepository::getStationsForNet($request['net_name']);
    }

    public function loadFile(Request $request)
    {

        dd($request->all());
    }
}
