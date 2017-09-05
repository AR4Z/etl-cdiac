<?php

namespace App\Http\Controllers\Etl;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtlPlaneRequest;
use Facades\App\Repositories\Administrator\StationRepository;
use Facades\App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Etl\Etl;

class PlaneEtlController extends Controller
{

    protected $keys  = ['estacion','fecha','tiempo'];

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

    public function loadFileErrors(Request $request)
    {
        dd($request->all());
    }

    public function loadFile(EtlPlaneRequest $request)
    {
        $variablesStation = $this->getVariablesStation($request['station_id']);

        $file = $request->file('file');
        $name = time().'.'.$file->getClientOriginalExtension();

        if ($file->getClientOriginalExtension() == 'csv'){
            Storage::disk('public')->put($name,  \File::get($file));
            $variablesLoad = ((((Excel::load(storage_path().'/app/public/'.$name)->get())->first())->keys())->toArray());

            $validate = $this->validateVariablesLoad($variablesLoad,$variablesStation);
            //dd($validate);
            if (!$validate['response']){
                $station = StationRepository::find($request['station_id']);
                return view('etl.displayPlaneErrors')
                        ->with('validate',$validate)
                        ->with('station',$station)
                        ->with('name',$name)
                        ->withErrors(['file'=> ['','']]);
            }
            //Ejecutar El factori de la etl
            // parametros( nombre del archivo, orden de las variables, typo de estacion, estacion)
            $enter = $request->all();
            $this->executePlaneEtl($enter['method'],$enter['sequence'],$enter['station_id'],$name);
        }else{
            return redirect()->back()->withErrors(['file'=>"Acualmente solo se pueden subir archivos CSV con codificacion UTF-8    por favor revise que el archivo tenga estas caracteristicas "]);
        }


    }

    private function getVariablesStation($stationId)
    {
        $arr = [];
        $var = StationRepository::findVarForFilter($stationId);
        foreach ($var as $index => $value){array_push($arr,$value->excel_name);}
        return $arr;
    }
    private function validateVariablesLoad($variablesLoad,$variablesStation)
    {
        $flag = true;
        $notExist = [];
        $notFind = [];
        foreach ($this->keys as $key => $value){
            $val = array_search($value,$variablesLoad);
            if ( $val !== false){unset($variablesLoad[$val]);}
        }
        foreach ($variablesStation as $item =>$value) {
            $val = array_search($value,$variablesLoad);
            if ($val === false){$flag = false;array_push($notExist,$value);}
        }
        foreach ($variablesLoad as $item => $value) {
            $val = array_search($value,$variablesStation);
            if ($val === false){$flag = false;array_push($notFind,$value);}
        }

        return ['response' => $flag,'notExist'=>$notExist,'notFind'=> $notFind];
    }

    private function executePlaneEtl($method,$sequence,$stationId,$fileName)
    {
        $station = StationRepository::select('*')->where('id',$stationId)->first();
        if (is_null($station)){return false;}
        $sequence=  ($sequence == 'false') ? false : true;

        if ( $method == 'Filter' || $method == 'Original')
        {
            $migrate = Etl::start($method, null, null,$stationId,$sequence)
                            ->extract('Csv',['fileName' => $fileName])
                            ->run();
        }else{

        }

        dd($migrate);

    }
}
