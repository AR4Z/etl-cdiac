<?php

namespace App\Http\Controllers\Etl;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtlPlaneRequest;
use App\Repositories\Administrator\NetRepository;
use App\Repositories\Administrator\StationRepository;
use App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Etl\Etl;
use App\Etl\Traits\BaseExecuteEtl;


class PlaneEtlController extends Controller
{
    use BaseExecuteEtl;


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
     *
     */
    public function index()
    {
        $differentNetName = $this->stationDimRepository->getDifferentNetName();
        return view('etl.index',compact('differentNetName'));
    }

    /**
     * @return mixed
     */
    public function getDifferentNetName()
    {
        return $this->stationDimRepository->getDifferentNetName();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStationsForNet(Request $request)
    {
        return $this->stationDimRepository->getStationsForNet($request->get('net_name'));
    }

    /**
     * @param Request $request
     */
    public function loadFileErrors(Request $request)
    {
        $result = $this->executePlaneEtl(json_decode($request->get('options')));

        # Retornar a la vista de genracion de reportes
        # TODO
        dd('termine',$result);
    }

    /**
     * @param EtlPlaneRequest $request
     * @return $this
     */
    public function loadFile(EtlPlaneRequest $request)
    {
        $options = $this->getOptions($request);

        # El proceso solo acepta archivos csv
        if (($options->file)->getClientOriginalExtension() != 'csv'){ return redirect()->back()->withErrors(['file'=>"Acualmente solo se pueden subir archivos CSV con codificacion UTF-8    por favor revise que el archivo tenga estas caracteristicas "]); }

        $options->variables_station = $this->getVariablesStation($options->station_id);
        $options->etl_type = $this->stationRepository->getStation($options->station_id)->typeStation->etl_method;

        if (is_null($options->etl_type)){ return redirect()->back()->withErrors(['file'=> 'No exisite Metodo Etl para el tipo de estación seleccionado']);}

        $options->file_name = time().'.'.($options->file)->getClientOriginalExtension();

        # Guardar el archivo en el servidor
        Storage::disk('public')->put( $options->file_name,  \File::get($options->file));

        # Obtener la primera fila que corresponde a los encabezados del archivo csv
        $options->variables_load = ((((Excel::load(storage_path().'/app/public/'. $options->file_name)->get())->first())->keys())->toArray());

        # Validar columnas de entrada con las columnas registradas para la estacion
        $validate = $this->validateVariablesLoad($options->variables_load,$options->variables_station, $options->etl_type);

        if (!$validate['response']){
            return view('etl.displayPlaneErrors')
                        ->with('validate',$validate)
                        ->with('options',json_encode($options))
                        ->withErrors(['file'=> ['','']]);
        }

        /*
         *  Execute Factory ETL
         *  @param  Method, Sequence, Starion Id, File Name
         */
        $result = $this->executePlaneEtl($options);

        # Retornar a la vista de genracion de reportes
        # TODO
        dd('termine',$result);
    }

    /**
     * @param Request $request
     * @return object
     */
    private function getOptions(Request $request)
    {
        $options = [];

        $options['sequence'] = $request->exists('sequence');
        $options['jobs'] = $request->exists('jobs');
        $options['serialization'] = $request->exists('serialization');
        $options['trust_process'] = $request->exists('trust_process');
        $options['method'] = $request->get('method');
        $options['station_id'] = (integer)$request->get('station_id');
        $options['net_name'] = $request->get('net_name');
        $options['file'] = $request->file('file');;

        return (object)$options;
    }

    /**
     * @param $stationId
     * @return array
     */
    private function getVariablesStation($stationId)
    {
        $arr = [];
        $var = $this->stationRepository->findVarForFilter($stationId);
        foreach ($var as $index => $value){array_push($arr,['excel_name' =>$value->excel_name,'description'=>$value->description]);}
        return $arr;
    }

    /**
     * @param $variablesLoad
     * @param $variablesStation
     * @param $etlType
     * @return array
     */
    private function validateVariablesLoad($variablesLoad, $variablesStation, $etlType)
    {
        $flag = true;
        $notExist = [];
        $notFind = [];

        $configCsv = (object)Config::get('etl')['csv_keys'][$etlType];

        foreach ($configCsv as $key => $value){

            $val = array_search($key,$variablesLoad);
            if ( $val !== false){
                unset($variablesLoad[$val]);
            }else{
                if ($value['required']){
                    array_push($notExist,$key.' : '.$value['description']);
                }
            }
        }
        # se buscan las varia
        foreach ($variablesStation as $item => $value) {
            $val = array_search($value['excel_name'],$variablesLoad);
            if ($val === false){$flag = false;array_push($notExist,$value['excel_name'].' : '.$value['description']);}
        }

        $excelName = array_column($variablesStation, 'excel_name');

        foreach ($variablesLoad as $item => $value) {
            $val = array_search($value,$excelName);
            if ($val === false){$flag = false;array_push($notFind,$value);}
        }
        return ['response' => $flag,'notExist'=>$notExist,'notFind'=> $notFind];
    }

    /**
     * @param $options
     * @return object
     */
    private function executePlaneEtl($options)
    {
        $station = $this->stationRepository->getStation($options->station_id);
        $response = null;

        if (is_null($station)){return (object)['original'=> false,'filter' => false, 'error' => 'no se encontró la estación'];}

        $typeStation = ($this->stationRepository->getTypeStation($options->station_id))->etl_method;

        if (is_null($typeStation)){return (object)['original'=> false,'filter' => false, 'error' => 'No se encuentra un metodo ETL para la estación seleccionada'];}

        $extract = ['method' => 'Csv','optionExtract' =>['fileName'=> $options->file_name]];

        switch ($typeStation) {
            case "weather":
                $response = $this->executeWeather($station,$extract,$options);
                break;
            case "air":
                $response = $this->executeAir($station,$extract,$options);
                break;
            case "groundwater":
                $response = $this->executeGroundwater($station,$extract,$options);
                break;
            default:
                $response = ['original'=> false,'filter' => false, 'error' => 'se ejecutó ningun proceso de migrado - posiblemente sea un typo de estacion nuevo y no exista función de ejecusión'];
        }

        dd($response);

        return (object)$response;

    }

    /**
     * @param $station
     * @param $extract
     * @param $options
     * @return array
     */
    private function executeWeather($station, $extract, $options)
    {
        # La Opcion originales no puede ojecutarse por medio de jobs pues se necesitan datos para poder ejecutar el proceso de filtrado.
        $response = $this->executeOneStation('Original',$station->owner_net_id,$options->station_id,$options->sequence,$extract,[],[],false);
        $response2 = false;

        if ($options->method == 'Filter'){
            $etlConfig = $response['work1']->etlConfig;
            $extract2 =  [
                'method' => 'Database',
                'optionExtract' =>[
                    'trustProcess'=> $options->trust_process,
                    'extractType' => 'Local',
                    'initialDate' => $etlConfig->getInitialDate(),
                    'initialTime' => $etlConfig->getInitialTime(),
                    'finalDate' =>  $etlConfig->getFinalDate(),
                    'finalTime' => $etlConfig->getFinalTime()
                ]
            ];
            $response2 =    $this->executeOneStation('Filter',$station->owner_net_id,$station->id,$options->sequence,$extract2,[],[], $options->jobs);
        }
        return ['Original'=> $response,'Filter' => $response2];
    }


    private function executeAir($station, $extract, $options)
    {
        # La Opcion originales no puede ojecutarse por medio de jobs pues se necesitan datos para poder ejecutar el proceso de filtrado.
        $response = $this->executeOneStation('Original',$station->owner_net_id,$options->station_id,$options->sequence,$extract,[],[],false);
/*
        $etlConfig = $response['work1']->etlConfig;

        $extract2 =  [
            'method' => 'Database',
            'optionExtract' =>[
                'trustProcess'=> $options->trust_process,
                'extractType' => 'Local',
                'initialDate' => $etlConfig->getInitialDate(),
                'initialTime' => $etlConfig->getInitialTime(),
                'finalDate' =>  $etlConfig->getFinalDate(),
                'finalTime' => $etlConfig->getFinalTime()
            ]
        ];

        $response2 =    $this->executeOneStation('Filter',$station->owner_net_id,$station->id,$options->sequence,$extract2,[],[], $options->jobs);
*/
        return ['Original'=> $response]; # ,'Filter' => $response2

    }
    private function executeGroundwater($station, $extract, $options)
    {

    }
}
