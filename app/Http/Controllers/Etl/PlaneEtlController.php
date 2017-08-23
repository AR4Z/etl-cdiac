<?php

namespace App\Http\Controllers\Etl;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtlPlaneRequest;
use Facades\App\Repositories\Administrator\StationRepository;
use Facades\App\Repositories\DataWareHouse\StationDimRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    public function loadFile(EtlPlaneRequest $request)
    {
        $variablesStation = $this->getVariablesStation($request['station_id']);

        $file = $request->file('file');
        $name = time().'.csv';

        if ($file->getClientOriginalExtension() == 'csv'){
            Storage::disk('public')->put($name,  \File::get($file));
            $variablesLoad = ((((Excel::load(storage_path().'/app/public/'.$name)->get())->first())->keys())->toArray());

            $validate = $this->validateVariablesLoad($variablesLoad,$variablesStation);
            if (!$validate['response']){
                //Error hacen falta las columnas $validate['notExist']
            }
            //Ejecutar El factori de la etl parametros( nombre del archivo, orden de las variables)
        }else{
            //Erro hasta este moneto solo funciona con archivos csv
        }
        dd($name);
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
        foreach ($this->keys as $key => $value){
            if (array_search($value,$variablesLoad)){array_push($variablesLoad,$value);}
        }
        foreach ($variablesStation as $item =>$value) {
            if (!array_search($value,$variablesLoad)){
                $flag = false;
                array_push($value,$notExist);
            }
        }

        return ['response' => $flag,'notExist'=>$notExist];
    }
}
