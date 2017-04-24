<?php

namespace App\Http\Controllers\Config;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Config\ConnectionRequest;
use Illuminate\Support\Facades\DB;


use Facades\App\Etl\Database\DatabaseConfig;
use App\Etl\Etl;

use Facades\App\Repositories\Config\StationRepository;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\Repositories\Config\ConnectionRepository;
use Illuminate\Support\Facades\Storage;

use App\Jobs\EtlStationJob;



class ExternalConnectionController extends Controller
{

    private $connectionRepository;

    /**
     * ExternalConnectionController constructor.
     * @param ConnectionRepository $connectionRepository
     */
    function __construct(ConnectionRepository $connectionRepository)
    {
        $this->connectionRepository = $connectionRepository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @internal param DatabaseConfig $databaseConfig
     */
    public function index()
    {
        //dispatch(new EtlStationJob('Original',1,1,true));


        //dd($this->connectionRepository->getCacheLifetime());
        //dd($this->connectionRepository->where('id', 1)->first());


        $jobEtl = Etl::start('Original', 1, 1,true)
                        ->extract('Database')//,['initialDate' => '2017-04-10', 'initialTime' => '23:40:35']
                        ->transform()
                        ->load();
        dd($jobEtl);

        //$jobEtl2 = Etl::start('Original', 2, 81,false)->extract('Csv')->transform()->load();

        //$jobEtl = Etl::start('Filter', 1, 77,false)->extract('Database')->transform()->load();

        //dd(' se deben estar ejecutando los jobs');
        //dd($jobEtl);

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
