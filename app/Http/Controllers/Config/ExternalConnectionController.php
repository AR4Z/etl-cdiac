<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Config\ConnectionRequest;
use Illuminate\Support\Facades\DB;


use App\Etl\Database\DatabaseConfig;
use App\Etl\Etl;

use Facades\App\Repositories\Config\StationRepository;
use Facades\App\Repositories\Config\ConnectionRepository;


class ExternalConnectionController extends Controller
{
  public $stationRepository;
  public $connectionRepository;

  public function __construct()
  {

  }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @internal param DatabaseConfig $databaseConfig
     */
    public function index()
    {
      $jobEtl = Etl::start('Filter', 1, 1)->extract('Database')->transform()->load();
      $jobEtl2 = Etl::start('Original', 2, 81)->extract('Csv')->transform()->load();

      dd($jobEtl, $jobEtl2);

      /*
        $response = $databaseConfig->configExternalConnection('froac_raim');

        if ($response) {
          $users = DB::connection('external_connection')->select('select * from users');
          dd($users);
        }else {
          dd('detenido');
        }
      */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConnectionRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConnectionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConnectionRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConnectionRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
