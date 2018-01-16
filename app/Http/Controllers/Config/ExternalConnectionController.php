<?php

namespace App\Http\Controllers\Config;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Config\ConnectionRequest;
use Illuminate\Support\Facades\DB;
//use Facades\App\Etl\Database\DatabaseConfig;
use App\Etl\Etl;
//use Facades\App\Repositories\Config\StationRepository;
//use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
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
        //dd($this->connectionRepository->getCacheLifetime());
        //dd($this->connectionRepository->where('id', 1)->first());

        $jobEtl = Etl::start('Original', null, null,1,false) // sequense true
                        ->extract('Database',['trustProcess'=> false,'extractType' => 'External', 'initialDate' => '2015-11-05','initialTime' => '00:00:00','finalDate' => '2015-11-06','finalTime' => '23:59:59']) //'initialTime' => '05:00:00','finalTime' => '10:59:59'
                        ->transform('Serialization')
                        //->transform('FilterDetection')  #['paramSearch'=> ['r','j']] parametro opcional de valores de busqueda
                        //->transform('FilterCorrection')
                        //->load()
                        //->run()
        ;// este punto y coma termina el proceso de configuracion

        EtlStationJob::dispatch($jobEtl);

        dd($jobEtl,'Hola');

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
