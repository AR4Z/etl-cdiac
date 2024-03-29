<?php

namespace App\Http\Controllers\Etl;

use Config;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EtlPlaneRequest;
use App\Repositories\Administrator\NetRepository;
use App\Repositories\Administrator\StationRepository;
use App\Repositories\DataWareHouse\StationDimRepository;
use App\Etl\Execution\Traits\EtlExecutionFacilitatorTrait;
use App\Etl\Extractors\ExtensionLoad\Imports\PlaneImport;

class PlaneEtlController extends Controller
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
        NetRepository $netRepository
    ){
        $this->stationRepository = $stationRepository;
        $this->stationDimRepository = $stationDimRepository;
        $this->netRepository = $netRepository;
    }
    /**
     *
     */
    public function index()
    {
        return view('etl.index',compact('nets'))->with('nets',$this->netRepository->getNameAndIdAllNets());
    }

    /**
     * @return mixed
     */
    public function getDifferentNetName() // TODO quitar ??
    {
        return $this->stationDimRepository->getDifferentNetName();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStationsForNet(Request $request)
    {
        return $this->stationRepository->getAllStationForNet((int)$request->get('net_name'));
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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function loadFile(EtlPlaneRequest $request)
    {
        $options = $this->getOptions($request);

        # El proceso solo acepta archivos planos
        if (!($options->extension == 'csv' or $options->extension == 'txt')) {
            return redirect()->back()->withErrors(['file'=>"Acualmente solo se pueden subir archivos CSV con codificacion UTF-8    por favor revise que el archivo tenga estas caracteristicas "]);
        }

        $options->variables_station = $this->getVariablesStation($options->station_id);
        $options->etl_type = $this->stationRepository->getStation($options->station_id)->typeStation->etl_method;

        if (is_null($options->etl_type)){ return redirect()->back()->withErrors(['file'=> 'No exisite Metodo Etl para el tipo de estación seleccionado']);}

        $options->file_name = time().'.'.$options->file->getClientOriginalExtension();

        # Guardar el archivo en el servidor
        Storage::disk('public')->put( $options->file_name,  \File::get($options->file));

        # Obtener la primera fila que corresponde a los encabezados del archivo plano
        if ($options->extension == 'csv'){
            $planeImport = new PlaneImport();
            $planeImport->import(storage_path().'/app/public/'. $options->file_name,null,\Maatwebsite\Excel\Excel::CSV);
            $options->variables_load = $planeImport->headers;
        }

        if ($options->extension == 'txt') {
            $options->variables_load = explode(",",file(storage_path().'/app/public/'. $options->file_name,FILE_IGNORE_NEW_LINES)[0]);
        }

        # Validar columnas de entrada con las columnas registradas para la estacion
        $validate = $this->validateVariablesLoad($options->variables_load,$options->variables_station, $options->etl_type);

        if ($validate['response']){
            return view('etl.displayPlaneErrors')
                        ->with('validate',$validate)
                        ->with('options',json_encode($options))
                        ->withErrors(['file'=> ['','']]);
        }

        /*
         *  TypeExecute Factory ETL
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
        $options['method'] = $request->get('method');
        $options['station_id'] = (integer)$request->get('station_id');
        $options['net_id'] = $request->get('net_name');
        $options['file'] = $request->file('file');
        $options['extension'] = ($request->file('file'))->getClientOriginalExtension();
        $options['initialDate'] = $request->get('start');
        $options['finalDate'] = $request->get('end');

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
        foreach ($var as $index => $value){$arr[] = ['excel_name' =>$value->excel_name,'description'=>$value->description];}
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

        $configPlane = (object)Config::get('etl')['csv_keys'][$etlType];

        foreach ($configPlane as $key => $value){
            $val = array_search($value['incoming_name'],$variablesLoad);
            if ( $val !== false){
                unset($variablesLoad[$val]);
            }else{
                if ($value['required']){
                    $notExist[] = $value['incoming_name'].' : '.$value['description'];
                }
            }
        }

        # se buscan las varia
        foreach ($variablesStation as $item => $value) {
            $val = array_search($value['excel_name'],$variablesLoad);
            if ($val === false){
                $flag = false;
                $notExist[] = $value['excel_name'].' : '.$value['description'];
            }
        }

        $excelName = Arr::pluck($variablesStation,'excel_name');

        foreach ($variablesLoad as $item => $value) {
            $val = array_search($value,$excelName);

            if ($val === false){
                $flag = false;
                $notFind[] = $value;
            }
        }

        return ['response' => $flag,'notExist'=>$notExist,'notFind'=> $notFind];
    }

    /**
     * @param $options
     * @return array
     */
    private function executePlaneEtl($options) : array
    {
        $response = [];
        switch ($options->etl_type) {
            case "weather":
                $response[] = $this->OriginalWeatherPlane($options->station_id, $options->sequence, $options->jobs, $options->file_name);

                if ($options->method == 'ALL'){
                    $response[] = $this->FilterWeather($options->initialDate, $options->finalDate, $options->station_id, $options->sequence, $options->jobs);
                }
                break;
            case "air":
                $response[] = $this->OriginalAir($options->station_id, $options->sequence, $options->jobs, $options->extension , $options->file_name);

                if ($options->method == 'ALL'){
                    $response[] = $this->FilterAir($options->initialDate,$options->finalDate, $options->station_id, $options->sequence, $options->jobs);
                }
                break;
            case "groundwater":
                $response[] = $this->OriginalGroundwater($options->station_id, $options->sequence, $options->jobs, $options->file_name);
                break;
            default:
                $response[] = ['error' => 'se ejecutó ningun proceso de migrado - posiblemente sea un tipo de estacion nuevo y no exista función de ejecusión'];
        }

        return $response;
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
        $response = $this->executeOneStation('Original',$station->net_id,$options->station_id,$options->sequence,$options->serialization,$extract,[],[],false);
        $response2 = false;

        if ($options->method == 'Filter'){
            $etlConfig = $response['work1']->etlConfig;
            $extract2 =  [
                'method' => 'Database',
                'optionExtract' =>[
                    'trustProcess'=> $options->trust_process,
                    'extractType' => 'Local',
                    'initialDate' => $etlConfig->initialDate,
                    'initialTime' => '00:00:00',
                    'finalDate' =>  $etlConfig->finalDate,
                    'finalTime' => '23:59:59'
                ]
            ];
            $response2 =    $this->executeOneStation('Filter',$station->net_id,$station->id,$options->sequence,$options->serialization,$extract2,[],[], $options->jobs);
        }
        return ['Original'=> $response,'Filter' => $response2];
    }


    private function executeAir($station, $extract, $options)
    {
        # La Opcion originales no puede ojecutarse por medio de jobs pues se necesitan datos para poder ejecutar el proceso de filtrado.
        $response = $this->executeOneStation('Original',$station->net_id,$options->station_id,$options->sequence,$options->serialization,$extract,[],[],false);

        $etlConfig = $response['work1']->etlConfig;

        $extract2 =  [
            'method' => 'Database',
            'optionExtract' =>[
                'trustProcess'  => $options->trust_process,
                'extractType'   => 'Local',
                'initialDate'   => $etlConfig->initialDate,
                'initialTime'   => '00:00:00',
                'finalDate'     => $etlConfig->finalDate,
                'finalTime'     => '23:59:59'
            ]
        ];

        $transform = [
            [
                'method'            => 'FilterAir',
                'optionTransform'   => []
            ]
        ];

        $load = [];

        $response2 =    $this->executeOneStation('Filter',$station->net_id,$station->id,$options->sequence,$options->serialization,$extract2,$transform,$load, $options->jobs);

        return ['Original'=> $response,'Filter' => $response2];

    }
    private function executeGroundwater($station, $extract, $options)
    {
        return $this->executeOneStation('Original', $station->net_id, $options->station_id, $options->sequence, $options->serialization, $extract,[],[],false);
    }
}
