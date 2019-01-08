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
use App\Repositories\Administrator\NetRepository;
use App\Repositories\RepositoryFactoryTrait;
use App\Repositories\TemporaryWork\TemporalAirRepository;
use App\Repositories\TemporaryWork\TemporalWeatherRepository;
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
     * ExternalConnectionController constructor.
     * @param ConnectionRepository $connectionRepository
     * @param StationRepository $stationRepository
     * @param NetRepository $netRepository
     * @param TemporalAirRepository $temporalAirRepository
     * @param TemporalWeatherRepository $temporalWeatherRepository
     */
    function __construct(
        ConnectionRepository $connectionRepository,
        StationRepository $stationRepository,
        NetRepository $netRepository,
        TemporalAirRepository $temporalAirRepository,
        TemporalWeatherRepository $temporalWeatherRepository
    )
    {
        $this->connectionRepository = $connectionRepository;
        $this->stationRepository = $stationRepository;
        $this->netRepository = $netRepository;
        $this->temporalAirRepository = $temporalAirRepository;
        $this->temporalWeatherRepository = $temporalWeatherRepository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @internal param DatabaseConfig $databaseConfig
     * @throws \ReflectionException
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function index()
    {
        $execute = new EtlExecute(
            $method = new FilterExecute(
                $option = new FilterWeatherOption(1,'2018-10-21','2018-10-22')
            )
        );


        $execute->setTrustProcess(true);
        #$execute->setSequence(true);
        $option->setRunType('Synchronous');

        $execute->execute();

        //$method->setRunMethod('Syncrone');
        //$method->addExtractConfigVariable('fileName', 'ruta del elemento');

        dd($execute,$method,$option);



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
