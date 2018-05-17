<?php

namespace App\Http\Controllers\Etl;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtlPlaneRequest;
use Facades\App\Repositories\Administrator\StationRepository;
use Facades\App\Repositories\DataWareHouse\StationDimRepository;
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

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStationsForNet(Request $request)
    {
        return StationDimRepository::getStationsForNet($request['net_name']);
    }

    /**
     * @param Request $request
     */
    public function loadFileErrors(Request $request)
    {
        $config = json_decode($request["config"]);
        $fileName = $request["name"];
        /*
         *  Execute Factory ETL
         *  @param  Method, Sequence, Starion Id, File Name
       */
        $this->executePlaneEtl($config->method,$config->sequence,$config->station_id,$fileName);

        # Retornar a la vista de genracion de reportes
        # TODO
        dd('termine');
    }

    public function loadFile(EtlPlaneRequest $request)
    {
        $variablesStation = $this->getVariablesStation($request['station_id']);
        $etlType = StationRepository::getStation($request['station_id'])->typeStation->etl_method;
        $file = $request->file('file');
        $enter = $request->all();

        # Asignar un nombre unico para el archivo entrante
        $name = time().'.'.$file->getClientOriginalExtension();

        if ($file->getClientOriginalExtension() != 'csv'){ return redirect()->back()->withErrors(['file'=>"Acualmente solo se pueden subir archivos CSV con codificacion UTF-8    por favor revise que el archivo tenga estas caracteristicas "]); }

        # Guardar el archivo en el servidor
        Storage::disk('public')->put($name,  \File::get($file));

        # Obtener la primera fila que corresponde a los encabezados del archivo csv
        $variablesLoad = ((((Excel::load(storage_path().'/app/public/'.$name)->get())->first())->keys())->toArray());

        # Validar columnas de entrada con las columnas registradas para la estacion
        $validate = $this->validateVariablesLoad($variablesLoad,$variablesStation,$etlType);

        if (!$validate['response']){
            return view('etl.displayPlaneErrors')
                        ->with('validate',$validate)
                        ->with('config',json_encode($enter))
                        ->with('name',$name)
                        ->withErrors(['file'=> ['','']]);
        }

        /*
         *  Execute Factory ETL
         *  @param  Method, Sequence, Starion Id, File Name
         */
        $this->executePlaneEtl($enter['method'],$enter['sequence'],$enter['station_id'],$name);

        # Retornar a la vista de genracion de reportes
        # TODO
    }

    /**
     * @param $stationId
     * @return array
     */
    private function getVariablesStation($stationId)
    {
        $arr = [];
        $var = StationRepository::findVarForFilter($stationId);
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
     * @param $method
     * @param $sequence
     * @param $stationId
     * @param $fileName
     * @return bool
     */
    private function executePlaneEtl($method, $sequence, $stationId, $fileName)
    {
        $trustProcess = false; # TODO : Debe entrar por parametro
        $jobs = false; # TODO : Debe entrar por parametro
        $station = StationRepository::select('*')->where('id',$stationId)->first();
        $sequence =  ($sequence == 'false') ? false : true;

        if (is_null($station)){return false;}

        $extract = ['method' => 'Csv','optionExtract' =>['fileName'=> $fileName]];
        $transform = [];
        $load = [];

        # La Opcion originales no puede ojecutarse por medio de jobs pues se necesitan datos para poder ejecutar el proceso de filtrado.
        $response = $this->executeOneStation('Original',$station->owner_net_id,$stationId,$sequence,$extract,$transform,$load,false);

        $etlConfig = $response['work1']->etlConfig;
        $extract2 =  ['method' => 'Database','optionExtract' =>['trustProcess'=> $trustProcess,'extractType' => 'Local', 'initialDate' => $etlConfig->getInitialDate(), 'initialTime' => $etlConfig->getInitialTime(), 'finalDate' =>  $etlConfig->getFinalDate(), 'finalTime' => $etlConfig->getFinalTime()]];

        $response2 =    $this->executeOneStation('Filter',$station->owner_net_id,$station->id,false,$extract2,[],[], $jobs);

        dd($response,$response2);

    }
}
