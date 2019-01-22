<?php

namespace App\Http\Controllers\Etl;

use App\Etl\Execution\Traits\EtlExecutionFacilitatorTrait;
use App\Repositories\Administrator\NetRepository;
use App\Repositories\Administrator\StationRepository;
use App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExecuteEtlController extends Controller
{
    use EtlExecutionFacilitatorTrait;

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

    /**
     * PlaneEtlController constructor.
     * @param StationRepository $stationRepository
     * @param StationDimRepository $stationDimRepository
     * @param NetRepository $netRepository
     */
    public function __construct(
        StationRepository $stationRepository,
        StationDimRepository $stationDimRepository,
        NetRepository $netRepository)
    {
        $this->stationRepository = $stationRepository;
        $this->stationDimRepository = $stationDimRepository;
        $this->netRepository = $netRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $nets = $this->netRepository->getNetsForServerAcquisition();
        return view('etl.indexEtl',compact('nets'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStationsForNet(Request $request)
    {
        $data = $request['id'];

        #no retornar nada cuando el parametro enviado es null
        if (is_null($data)){return;}

        #obtener las estaciones dependiando de la red
        $stations =  ($data == 0) ? $this->stationRepository->getStationEtlActive() : $this->stationRepository->getStationForNetEtlActive($data);

        #insertar la opcion de incluir las estaciones
        $flag = count($stations)+1;
        $stations[$flag] = clone $stations[0];
        $stations[$flag]->id = 0;
        $stations[$flag]->name = '---------- TODAS LAS ESTACIONES ------------ ';

        return $stations;
    }

    /**
     * @param Request $request
     */
    public function redirectionEtlFilter(Request $request)
    {
        $station = (int)$request->get('station_id');
        $net = (int)$request->get('net_name');

        $elements = $this->executeConfiguration(
            ($station == 0) ?  $this->optionalStationsInNet($this->stationRepository,$net) : $this->optionalStationInNet($this->stationRepository,$station),
            $request->get('method'),
            $request->get('start'),
            $request->get('end'),
            !is_null($request->get('sequence')),
            !is_null($request->get('jobs'))
        );

        dd('stop final',$elements);
    }

    /**
     * @param array $options
     * @param string $method
     * @param string $initialDate
     * @param string $finalDate
     * @param bool $sequence
     * @param string $typeExecution
     * @return array
     */
    private function executeConfiguration(array $options, string $method, string $initialDate, string $finalDate, bool $sequence, string $typeExecution) : array
    {
        $elements = [];

        foreach ($options as $key => $row) {
            switch ($key) {
                case 'weather':
                    if ($method == 'Filter'){ $elements[] = $this->FilterWeather($initialDate,$finalDate,$row,$sequence,$typeExecution); }
                    if ($method == 'Original'){ $elements[] = $this->OriginalWeatherDatabase($initialDate,$finalDate,$row,$sequence,$typeExecution); }
                    if ($method == 'All'){ $elements[] = $this->OriginalWeatherDatabase($initialDate,$finalDate,$row,$sequence,$typeExecution); $elements[] = $this->FilterWeather($initialDate,$finalDate,$row,$sequence,$typeExecution); }
                    break;
                case 'air':
                    if ($method == 'Filter'){ $elements[] = $this->FilterAir($initialDate,$finalDate,$row,$sequence,$typeExecution); }
                    if ($method == 'Original'){ dd('opcion no disponible (red no permite real time)');/** TODO opcion no disponible (red no permite real time) */ }
                    if ($method == 'All'){ dd('opcion no disponible (red no permite real time)'); /** TODO Opcion no desponible (red no permite real time) */}
                    break;
                case 'groundwater':
                    if ($method == 'Filter'){ dd('opcion no disponible (red no necesita ser filtrada )');/** TODO opcion no disponible (red no necesita ser filtrada ) */ }
                    if ($method == 'Original'){  dd('opcion no disponible (red no permite real time)');/** TODO opcion no disponible (red no permite real time) */ }
                    if ($method == 'All'){ dd('opcion no disponible (red no necesita ser filtrada )');/** TODO opcion no disponible (red no necesita ser filtrada ) */  }
                    break;
            }
        }

        return $elements;
    }

    public function executeResetStation(){ /** TODO */}

    public function executeResetAllStations(){ /** TODO */}

    public function executeRollbackStation(){/** TODO */}

    public function executeRollbackAllStations(){/** TODO */}

    public function executeRefreshStation(){/** TODO */}

    public function executeRefreshAllStations(){/** TODO */}
}
