<?php

namespace App\Http\Controllers\Config;

use App\Entities\TemporaryWork\TemporalWeather;
use App\Etl\Execution\EtlExecute;
use App\Etl\Execution\FilterExecute;
use App\Etl\Execution\Options\FilterOptions\FilterWeatherOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalAirOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalWeatherDatabaseOption;
use App\Etl\Execution\OriginalExecute;
use App\Etl\Execution\OriginalOptions\OriginalGeneralOption;
use App\Http\Controllers\Controller;
use App\Jobs\testJob;
use App\Mail\OrderShippedTest;
use App\Repositories\Administrator\NetRepository;
use App\Repositories\Administrator\VariableRepository;
use App\Repositories\Bodega\StationDimOldRepository;
use App\Repositories\DataWareHouse\StationDimRepository;
use App\Repositories\RepositoryFactoryTrait;
use App\Repositories\TemporaryWork\TemporalAirRepository;
use App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\test\test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Config\ConnectionRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
//use Facades\App\Etl\Database\DatabaseConfig;
use App\Etl\Etl;
//use Facades\App\Repositories\Config\StationRepository;
//use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\Repositories\Config\ConnectionRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Jobs\EtlStationJob;
use App\Etl\Traits\BaseExecuteEtl;
use App\Repositories\Administrator\StationRepository;

class ExternalConnectionController extends Controller
{
    use BaseExecuteEtl,RepositoryFactoryTrait;

    /**
     * @var ConnectionRepository
     */
    private $connectionRepository;
    /**
     * @var StationRepository
     */
    private $stationRepository;
    /**
     * @var NetRepository
     */
    private $netRepository;
    /**
     * @var TemporalAirRepository
     */
    private $temporalAirRepository;

    /**
     * @var TemporalWeatherRepository
     */
    private $temporalWeatherRepository;
    /**
     * @var VariableRepository
     */
    private $variableRepository;
    /**
     * @var StationDimRepository
     */
    private $stationDimRepository;
    /**
     * @var StationDimOldRepository
     */
    private $stationDimOldRepository;

    /**
     * ExternalConnectionController constructor.
     * @param ConnectionRepository $connectionRepository
     * @param StationRepository $stationRepository
     * @param NetRepository $netRepository
     * @param TemporalAirRepository $temporalAirRepository
     * @param TemporalWeatherRepository $temporalWeatherRepository
     * @param VariableRepository $variableRepository
     * @param StationDimRepository $stationDimRepository
     * @param StationDimOldRepository $stationDimOldRepository
     */
    function __construct(
        ConnectionRepository $connectionRepository,
        StationRepository $stationRepository,
        NetRepository $netRepository,
        TemporalAirRepository $temporalAirRepository,
        TemporalWeatherRepository $temporalWeatherRepository,
        VariableRepository $variableRepository,
        StationDimRepository $stationDimRepository,
        StationDimOldRepository $stationDimOldRepository
    )
    {
        $this->connectionRepository = $connectionRepository;
        $this->stationRepository = $stationRepository;
        $this->netRepository = $netRepository;
        $this->temporalAirRepository = $temporalAirRepository;
        $this->temporalWeatherRepository = $temporalWeatherRepository;
        $this->variableRepository = $variableRepository;
        $this->stationDimRepository = $stationDimRepository;
        $this->stationDimOldRepository = $stationDimOldRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        var_dump(url('/'));
        //$test = new test();
        //$test->waitTime(30);

        //testJob::dispatch($test);

        //dd('termine');

        //\Mail::to('daespinosag@unal.edu.co')->send(new OrderShippedTest());

        testJob::dispatch('daespinosag@unal.edu.co');

        /**
        dd(round(16.06+(15.89-16.06)/(700-385)*(601-385),2));
        $date = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string('-1 days'))->format('Y-m-d');

        $stations = Arr::pluck($this->stationRepository->getStationToOriginalMethod('weather'),'id');

        $execute = new EtlExecute(
            $method = new FilterExecute(
                $option = new FilterWeatherOption($stations,$date,$date)
            )
        );

        dd($execute,$method,$option);

        #$execute->setSequence(true);
        $option->setRunType('Synchronous');

        $execute->execute();
         *

        //$method->setRunMethod('Syncrone');
        //$method->addExtractConfigVariable('fileName', 'ruta del elemento');

        dd($execute,$method,$option);

         **/

        //$container = $this->stationRepository->getContainer();
        //dd($container);

        //$this->executeAllOriginalYesterday();
       // dd($this->stationRepository);
        //dd($this->connectionRepository->getCacheLifetime());
        //dd($this->connectionRepository->where('id', 1)->first());
/*
        $jobEtl = Etl::start('Original', null, null,19,['trustProcess'=> false, 'sequence' => false, 'debug'=> true]) // sequense true
                        ->extract('Database',['extractType' => 'External', 'initialDate' => '2017-06-10','initialTime' => '00:00:00','finalDate' => '2017-06-20','finalTime' => '23:59:59']) //'initialTime' => '05:00:00','finalTime' => '10:59:59'
                        ->transform('FilterDetection')  #['paramSearch'=> ['r','j']] parametro opcional de valores de busqueda
                        //->transform('FilterCorrection')
                        ->transform('Homogenization')
                        //->transform('FilterCorrection')
                        //->load()
                        ->run()
        ;// este punto y coma termina el proceso de configuracion

        //EtlStationJob::dispatch($jobEtl);

        dd($jobEtl,'Hola');
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
