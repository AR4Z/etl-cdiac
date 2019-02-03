<?php

namespace App\Http\Controllers\Auditory;

use App\Http\Controllers\Controller;
use App\Repositories\Administrator\StationRepository;
use App\Repositories\Administrator\VariableRepository;
use App\Repositories\Bodega\FactTableRepository;
use App\Repositories\Bodega\DateDimOldRepository;
use App\Repositories\Bodega\VariableOldRepository;
use App\Repositories\Bodega\StationDimOldRepository;
use App\Repositories\Bodega\TablesOldWareHouseRepository;
use App\Repositories\Bodega\CorrectionHistoricalRepository;
use App\Repositories\Bodega\StationOldRepository;
use Illuminate\Http\Request;

use App\Repositories\Administrator\NetRepository;

use Carbon\Carbon;
//use App\Repositories\Auditory\RiskRepository;
use phpDocumentor\Reflection\Types\Null_;

//use App\Repositories\DataWareHouse\WeatherFactRepository;
//use App\Repositories\Auditory\DataQualityRepository;

class AuditoryController extends Controller
{
    /**
     * @var StationRepository
     */
    private $stationOldRepository;
    private $stationRepository;
    private $variableRepository;
    private $factTableRepository;
    private $variableOldRepository;
    private $dataQualityRepository;
    private $dateDimOldRepository;
    private $netRepository;
    private $correctionHistoricalRepository;
    private $stationDimOldRepository;
    private $tablesOldWareHouseRepository;
 //   private $riskRepository;

    /**
     * Create a new controller instance.
     * @param StationRepository $stationRepository
     * @param FactTableRepository $factTableRepository
     * @param VariableOldRepository $variableRepository
     * @param DataQualityRepository $dataQualityRepository
     */
    public function __construct(
        StationOldRepository $stationOldRepository,

        StationRepository $stationRepository,

        VariableRepository $variableRepository,

        VariableOldRepository $variableOldRepository,

        DateDimOldRepository $dateDimOldRepository,

        FactTableRepository $factTableRepository,

        NetRepository $netRepository,

        StationDimOldRepository $stationDimOldRepository,

        CorrectionHistoricalRepository $correctionHistoricalRepository,

        TablesOldWareHouseRepository $tablesOldWareHouseRepository

        //DataQualityRepository $dataQualityRepository

        //RiskRepository $riskRepository
    )
    {
        // $this->middleware('auth');
        $this->stationRepository = $stationRepository;

        $this->stationOldRepository= $stationOldRepository;

        $this->variableRepository = $variableRepository;

        $this->variableOldRepository = $variableOldRepository;

        $this->stationDimOldRepository = $stationDimOldRepository;

        //$this->dataQualityRepository = $dataQualityRepository;

        $this->factTableRepository = $factTableRepository;

        $this->dateDimOldRepository = $dateDimOldRepository;

        $this->netRepository = $netRepository;

        $this->correctionHistorialRepository = $correctionHistoricalRepository;

        $this->tablesOldWareHouseRepository = $tablesOldWareHouseRepository;
        // $this->riskRepository = $riskRepository;
    }
    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auditory.auditory');
    }

    public function makeAuditory(Request $request){

        $data = $request->all();
        $stations = $this->stationDimOldRepository->stations();
        $variable = $this->variableOldRepository->getVariable();
        //dd($variable);

        $net= $this->netRepository->getNet();

        switch ($data['auditoryType']) {

            case "1":

                $listStation = [];
                $listVariable = [];
                foreach ($variable as $variable){$listVariable[$variable->id_variable]= $variable->nombre;}
                foreach ($stations as $station){$listStation[$station->estacion_sk]= $station->estacion;}

                return view('auditory.auditoryStation')->with(['variable' => $listVariable, 'station'=>$listStation]);

                break;

            case "2":

                $listVariable = [];
                foreach ($variable as $variable){$listVariable[$variable->id_variable]= $variable->nombre;}

                return view('auditory.auditoryAllStation')->with(['variable' => $listVariable]);
            break;

            case "3":

                $listStation = [];
                foreach ($stations as $station){$listStation[$station->estacion_sk]= $station->estacion;}

                return view('auditory.auditoryAllVar')->with(['stations' => $listStation]);
            break;

            case "4":

                return view('auditory.auditoryComplete');

            case "5":

                $listNet=[];
                foreach ($net as $net){$listNet[$net->id]= $net->name;}
                $listVariable = [];
                foreach ($variable as $variable){$listVariable[$variable->id_variable]= $variable->nombre;}

                return view('auditory.auditoryNetAndVar')->with(['net' => $listNet,'variable'=>$listVariable]);

            break;

            case "6":

                $listNet=[];
                foreach ($net as $net){$listNet[$net->id]= $net->name;}

                return view('auditory.auditoryNet')->with(['net' => $listNet]);

                break;

            default:
                $listStation = [];
                $listVariable = [];
                foreach ($variable as $variable){$listVariable[$variable->id_variable]= $variable->nombre;}
                foreach ($stations as $station){$listStation[$station->estacion_sk]= $station->estacion;}

                return view('Auditory.auditoryStation')->with(['variable' => $listVariable, 'station'=>$listStation]);

                        }
        }

    public function graphics(Request $request)
    {
        $data=$request->all();

        return view('auditory.result');

    }




    public function applyAuditory(Request $request)
    {        $data = $request->all();
        $date_start = $this->dateDimOldRepository->getDate($data['start']);
        $date_end = $this->dateDimOldRepository->getDate($data['end']);


        if (array_key_exists("station_id",$data)){

            $station = $this->stationDimOldRepository->getStationNameById($data['station_id']);
            if (array_key_exists("variable_id",$data)){

                $variables = $this->variableOldRepository->getVariableNameById($data['variable_id']);

            }
            else{
                $variables = $this->variableOldRepository->getVariableByStation($data['station_id']);

            }
        }
        elseif (array_key_exists("net_id",$data)){
            $stationNet=$this->stationRepository->getStationForNetAuditoryActive($data['net_id']);
            $station=array();

            for ($i=0;$i<=sizeof($stationNet)-1;$i++){

                $stationData=$this->tablesOldWareHouseRepository->getStationIdByName(array_column($stationNet,'table_db_name')[$i]);
                array_push($station,(object)$stationData);

            }
          //dd($stationNet,$station);


            if (array_key_exists("variable_id",$data)){
                $variables = $this->variableOldRepository->getVariableNameById($data['variable_id']);
            }
            else{
                $variables=0;
            }
        }
        else{
            $station= $this->stationDimOldRepository->getAllStations();

            //dd($station);
            if (array_key_exists("variable_id",$data)){

                $variables = $this->variableOldRepository->getVariableNameById($data['variable_id']);
            }
            else{
                $variables=0;
            }
        }
        if (array_key_exists("start_data",$data)){
            $data_start=$data['start_data'];
            $data_end=$data['end_data'];
        }
        else{
            $data_start=0;
            $data_end=0;
        }

        switch ($data['dataQuality']) {

            case "Exactitud":
                $result_accurancy_array = $this->accuracy($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk,$data_start,$data_end);
              //  dd($result_accurancy_array,$data);

                if (sizeof($station)==1 && sizeof($variables)==1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_accurancy_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                elseif (array_key_exists("net_id",$data)) {
                    $net=$this->netRepository->getNetById($data['net_id']);
                    return view('auditory.result_Net')->with(['data_risk' => $result_accurancy_array,'net'=> array_column($net,'name')[0], 'search' => $data]);

                }
                elseif (sizeof($station)==1 && sizeof($variables)>1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_accurancy_array,'station'=>array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                else {
                //dd($result_accurancy_array[706]);
                return view('auditory.result_AllStations')->with(['data_risk' => $result_accurancy_array, 'search' => $data]);}
                break;

            case "Integridad":
            $result_integrity = $this->averageRisk($station, $variables, $date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
                if (sizeof($station)==1 && sizeof($variables)==1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_integrity, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                elseif (array_key_exists("net_id",$data)) {
                    $net=$this->netRepository->getNetById($data['net_id']);
                    return view('auditory.result_Net')->with(['data_risk' => $result_integrity,'net'=> array_column($net,'name')[0], 'search' => $data]);

                }
                elseif (sizeof($station)==1 && sizeof($variables)>1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_integrity, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                else {

            return view('auditory.result_AllStations')->with(['data_risk' => $result_integrity, 'search' => $data]);}
            break;

            case "Completitud":

                $result_completeness_array = $this->completeness($station,$variables,$data['start'],$data['end']);
                if (sizeof($station)==1 && sizeof($variables)==1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_completeness_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                elseif (array_key_exists("net_id",$data)) {
                    $net=$this->netRepository->getNetById($data['net_id']);
                    return view('auditory.result_Net')->with(['data_risk' => $result_completeness_array,'net'=> array_column($net,'name')[0], 'search' => $data]);

                }
                elseif (sizeof($station)==1 && sizeof($variables)>1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_completeness_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                else {
                    return view('auditory.result_AllStations')->with(['data_risk' => $result_completeness_array, 'search' => $data]);
                }
            break;


            case "Consistencia":


                $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
          
              (array_column($result_consistence_array,'outlier')[0]);

                if (sizeof($station)==1 && sizeof($variables)==1){

                   // dd(['outlier'=>(array_column($result_consistence_array,'outlier')[0]),'data_risk' => $result_consistence_array, 'station'=> array_column($station,'estacion'),'var'=>array_column($variables,'nombre'),'search' => $data]);
                    return view('auditory.result_Station_consistence')->with(['outlier'=>(array_column($result_consistence_array,'outlier')[0]),'data_risk' => $result_consistence_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                elseif (array_key_exists("net_id",$data)) {

                    $net=$this->netRepository->getNetById($data['net_id']);
                    return view('auditory.result_Net_consistence')->with(['data_risk' => $result_consistence_array,'net'=> array_column($net,'name')[0], 'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                elseif (sizeof($station)==1 && sizeof($variables)>1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_consistence_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                else {
                    return view('auditory.result_consistence')->with(['data_risk' => $result_consistence_array, 'search' => $data]);
                }
                break;



            case "Coherencia":

                $result_coherence_array = $this->coherence($station,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);

                if (array_key_exists("net_id",$data)) {

                    $net=$this->netRepository->getNetById($data['net_id']);
                    return view('auditory.result_Net')->with(['data_risk' => $result_coherence_array,'net'=> $net[0]->name, 'search' => $data]);

                }
                elseif (sizeof($station)==1 && sizeof($variables)>1){

                    return view('auditory.result_Station')->with(['data_risk' => $result_coherence_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

                }
                else {
                    return view('auditory.result_AllStations')->with(['data_risk' => $result_coherence_array, 'search' => $data]);
                }
                break;


            default:

            $result_exactitud_array = $this->accuracy($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk,$data_start,$data_end);
            $result_integrity = $this->averageRisk($station, $variables, $date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
            $result_completeness_array = $this->completeness($station,$variables,$data['start'],$data['end']);
            $result = array_merge($result_integrity, $result_completeness_array, $result_exactitud_array);

            if (sizeof($station)==1 && sizeof($variables)==1) {

                if ($data['variable_id']=='evapotranspiracion'){

                    $result_coherence_array=$this->coherence($station,$date_start[0]->fecha_sk,$date_end[0]->fecha_sk);

                    $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);

                    $result_array=array_merge($result,$result_consistence_array,$result_coherence_array);
                }
                else{

                $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);

                $result_array=array_merge($result,$result_consistence_array);}

                return view('auditory.result_Station')->with(['data_risk' => $result_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);
            }
            elseif (array_key_exists("net_id",$data)) {
                $net=$this->netRepository->getNetById($data['net_id']);
                if (array_key_exists('variable_id',$data)){
                    if ($data['variable_id']=='evapotranspiracion'){
                        $result_coherence_array=$this->coherence($station,$date_start[0]->fecha_sk,$date_end[0]->fecha_sk);

                        $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);

                        $result_array=array_merge($result,$result_consistence_array,$result_coherence_array);

                    }
                    else{

                        $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
                        $result_array=array_merge($result,$result_consistence_array);}
                }
                else{

                    $result_coherence_array=$this->coherence($station,$date_start[0]->fecha_sk,$date_end[0]->fecha_sk);

                    $result_array=array_merge($result,$result_coherence_array);
                }
                return view('auditory.result_Net')->with(['data_risk' => $result_array,'net'=> array_column($net,'name')[0], 'search' => $data]);

            }
            elseif (sizeof($station)==1 && sizeof($variables)>1){
                $result_coherence_array=$this->coherence($station,$date_start[0]->fecha_sk,$date_end[0]->fecha_sk);

                $result_array=array_merge($result,$result_coherence_array);
                return view('auditory.result_Station')->with(['data_risk' => $result_array, 'station'=> array_column($station,'estacion')[0],'var'=>array_column($variables,'nombre')[0],'search' => $data]);

            }
            else {
                if (array_key_exists('variable_id',$data)){

                    if ($data['variable_id']=='evapotranspiracion'){
                        $result_coherence_array=$this->coherence($station,$date_start[0]->fecha_sk,$date_end[0]->fecha_sk);

                        $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);

                        $result_array=array_merge($result,$result_consistence_array,$result_coherence_array);

                    }
                    else{

                    $result_consistence_array = $this->outliers($station,$variables,$date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
                    $result_array=array_merge($result,$result_consistence_array);}
                }
                else{
                    $result_coherence_array=$this->coherence($station,$date_start[0]->fecha_sk,$date_end[0]->fecha_sk);

                    $result_array=array_merge($result,$result_coherence_array);                }
                return view('auditory.result_AllStations')->with(['data_risk' => $result_array, 'search' => $data]);
            }
        }
    }


    public function accuracy($station,$variables,$date_start,$date_end,$data_start,$data_end){

        $result_exactitud_array = array();
        $result=array();
        $result_negative = $this->CountNegativeRiskForVar($station, $variables, $date_start, $date_end);
        $result_range_out = $this->countFactOutOfRangeForVar($station, $variables, $data_start, $data_end, $date_start, $date_end);

        if ($data_start ==0 && $data_end==0){

            $accuracy = array_merge($result_range_out, $result_negative);
        }

        else{

            $result_range_in = $this->countFactInOfRangeForVar($station, $variables, $data_start, $data_end, $date_start, $date_end);
            $accuracy = array_merge($result_range_out, $result_range_in,$result_negative);
        }

            if (sizeof($station)==1) {

                for ($i = 0; $i <= sizeof($accuracy) - 1; $i++) {
                    $exactitud = ((array_column($accuracy, 'vulnerabillity'))[$i]);
                    $risk_quantity = ((array_column($accuracy, 'riskQuantity')[$i]));
                    $total_data = ((array_column($accuracy, 'total_data')[$i]));
                    array_push($result_exactitud_array, ['risk' => array_column($accuracy, 'risk')[$i], 'station' => array_column($accuracy, 'station')[$i], 'criterio' => 'Exactitud', 'vulnerabillity' => round($exactitud, 2), 'riskQuantity' => round($risk_quantity), 'total_data' => round($total_data), 'variable' => array_column($accuracy, 'variable')[$i]]);
                }

            }
                else {

                for ($i=0;$i<=sizeof($result_negative)-1;$i++) {

                    if ((array_column($result_negative, 'vulnerabillity'))[$i] == 0 && (array_column($result_negative, 'riskQuantity'))[$i] == 0) {

                        array_push($result_exactitud_array, ['station' => array_column($result_range_out, 'station')[$i], 'criterio' => 'Exactitud', 'vulnerabillity' => round((array_column($result_range_out, 'vulnerabillity'))[$i], 2), 'riskQuantity' => (array_column($result_range_out, 'riskQuantity'))[$i], 'total_data' => (array_column($result_range_out, 'total_data'))[$i], 'variable' => array_column($result_range_out, 'variable')[$i]]);
                    }
                    elseif ((array_column($result_range_out, 'vulnerabillity'))[$i] == 0 && (array_column($result_range_out, 'riskQuantity'))[$i] == 0) {

                        array_push($result_exactitud_array, ['station' => array_column($result_negative, 'station')[$i], 'criterio' => 'Exactitud', 'vulnerabillity' => round((array_column($result_negative, 'vulnerabillity'))[$i], 2), 'riskQuantity' => (array_column($result_negative, 'riskQuantity'))[$i], 'total_data' => (array_column($result_negative, 'total_data'))[$i], 'variable' => array_column($result_negative, 'variable')[$i]]);

                    }
                    elseif ((array_column($result_range_out, 'vulnerabillity'))[$i] == 0 && (array_column($result_range_out, 'riskQuantity'))[$i] == 0 && (array_column($result_negative, 'vulnerabillity'))[$i] == 0 && (array_column($result_negative, 'riskQuantity'))[$i] == 0){

                        array_push($result_exactitud_array, ['station' => array_column($result_negative, 'station')[$i], 'criterio' => 'Exactitud', 'vulnerabillity' => 0, 'riskQuantity' => 0, 'total_data' => 0, 'variable' => array_column($result_negative, 'variable')[$i]]);

                    }
                    else {
                        $exactitud = ((array_column($result_negative, 'vulnerabillity'))[$i]) + ((array_column($result_range_out, 'vulnerabillity'))[$i]) / 2;
                        $risk_quantity = ((array_column($result_negative, 'riskQuantity')[$i]) + (array_column($result_range_out, 'riskQuantity')[$i]) / 2);
                        $total_data = ((array_column($result_negative, 'total_data')[$i]) + (array_column($result_range_out, 'total_data')[$i]) / 2);
                        //dd($accuracy);
                        array_push($result_exactitud_array, ['station' => array_column($result_negative, 'station')[$i], 'criterio' => 'Exactitud', 'vulnerabillity' => round($exactitud, 2), 'riskQuantity' => round($risk_quantity), 'total_data' => round($total_data), 'variable' => array_column($result_negative, 'variable')[$i]]);
                    }
                }
                }
        return  $result_exactitud_array;

    }


    public function completeness($station,$variables,$date1,$date2){
        $date_start = $this->dateDimOldRepository->getDate($date1);
        $date_end = $this->dateDimOldRepository->getDate($date2);
        $receiveVsExpectative = $this->dataExpectVsReceive($station, $variables, $date1, $date2);
        $nullRisk = $this->nullData($station, $variables, $date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
        $result=array_merge($nullRisk,$receiveVsExpectative);
       // dd($result);
        $result_completeness_array = array();
        //if (sizeof($station)==1) {
            for ($i = 0; $i <= sizeof($result) - 1; $i++) {
                $completeness = ((array_column($result, 'vulnerabillity'))[$i]);
                $risk_quantity = ((array_column($result, 'riskQuantity')[$i]));
                $total_data = ((array_column($result, 'total_data')[$i]));
                array_push($result_completeness_array, ['risk' => array_column($result, 'risk')[$i], 'station' => array_column($result, 'station')[$i], 'criterio' => 'Completitud', 'vulnerabillity' => round($completeness, 2), 'riskQuantity' => round($risk_quantity), 'total_data' => round($total_data), 'variable' => array_column($result, 'variable')[$i]]);
            }

            /*else {
               // dd(sizeof($nullRisk),sizeof($receiveVsExpectative),sizeof($result));
                for ($i = 0; $i <= sizeof($result) - 1; $i++) {
                if ((array_column($nullRisk, 'vulnerabillity'))[$i] == 0 && (array_column($nullRisk, 'riskQuantity'))[$i] == 0) {
                    array_push($result_completeness_array, ['station' => array_column($receiveVsExpectative, 'station')[$i], 'criterio' => 'Completitud', 'vulnerabillity' => round((array_column($receiveVsExpectative, 'vulnerabillity'))[$i], 2), 'riskQuantity' => (array_column($receiveVsExpectative, 'riskQuantity'))[$i], 'total_data' => (array_column($receiveVsExpectative, 'total_data'))[$i], 'variable' => array_column($receiveVsExpectative, 'variable')[$i]]);
                }
                elseif ((array_column($nullRisk, 'vulnerabillity'))[$i] == 0 && (array_column($nullRisk, 'riskQuantity'))[$i] == 0 && (array_column($receiveVsExpectative, 'vulnerabillity'))[$i] == 0 && (array_column($receiveVsExpectative, 'riskQuantity'))[$i] == 0) {
                    array_push($result_completeness_array, ['station' => array_column($nullRisk, 'station')[$i], 'criterio' => 'Completitud', 'vulnerabillity' => round((array_column($nullRisk, 'vulnerabillity'))[$i], 2), 'riskQuantity' => (array_column($nullRisk, 'riskQuantity'))[$i], 'total_data' => (array_column($nullRisk, 'total_data'))[$i], 'variable' => array_column($nullRisk, 'variable')[$i]]);
                }
                elseif ((array_column($receiveVsExpectative, 'vulnerabillity'))[$i] == 0 && (array_column($receiveVsExpectative, 'riskQuantity'))[$i] == 0) {
                    array_push($result_completeness_array, ['station' => array_column($nullRisk, 'station')[$i], 'criterio' => 'Completitud', 'vulnerabillity' => 0, 'riskQuantity' => 0, 'total_data' => 0, 'variable' => array_column($nullRisk, 'variable')[$i]]);
                }
                else {
                    $completeness = (array_column($receiveVsExpectative, 'vulnerabillity'))[$i] + (array_column($nullRisk, 'vulnerabillity')[$i])/2;
                    $risk_quantity = ((array_column($receiveVsExpectative, 'riskQuantity')[$i]))+(array_column($nullRisk, 'riskQuantity')[$i])/2;
                    $total_data = ((array_column($receiveVsExpectative, 'total_data')[$i]));

                    array_push($result_completeness_array, ['station' => array_column($nullRisk, 'station')[$i], 'criterio' => 'Completitud', 'vulnerabillity' => round($completeness, 2), 'riskQuantity' => round($risk_quantity), 'total_data' => round($total_data), 'variable' => array_column($nullRisk, 'variable')[$i]]);
                }
            }
        }*/
        return  $result_completeness_array;


    }



    public function coherence($station,$date1,$date2){


        $coherenceNullRisk=$this->calculateEvapotranspirationNullRisk($station,$date1,$date2);

        $evapotranspiratioCoherence = $this->calculateEvapotranspirationRisk($station,$date1,$date2);


        $result=array_merge($coherenceNullRisk,$evapotranspiratioCoherence);

        $result_coherence_array = array();
        if (sizeof($station)==1) {

            for ($i = 0; $i <= sizeof($result) - 1; $i++) {

                $completeness = ((array_column($result, 'vulnerabillity'))[$i]);
                $risk_quantity = ((array_column($result, 'riskQuantity')[$i]));
                $total_data = ((array_column($result, 'total_data')[$i]));
                array_push($result_coherence_array, ['risk' => array_column($result, 'risk')[$i], 'station' => array_column($result, 'station')[$i], 'criterio' => 'Coherencia', 'vulnerabillity' => round($completeness, 2), 'riskQuantity' => round($risk_quantity), 'total_data' => round($total_data), 'variable' => array_column($result, 'variable')[$i]]);
            }
        }
        else {
            for ($i = 0; $i <= sizeof($evapotranspiratioCoherence) - 1; $i++) {

                if ((array_column($evapotranspiratioCoherence, 'vulnerabillity'))[$i] == 0 && (array_column($evapotranspiratioCoherence, 'riskQuantity'))[$i] == 0) {
                    array_push($result_coherence_array, ['station' => array_column($coherenceNullRisk, 'station')[$i], 'criterio' => 'Coherencia', 'vulnerabillity' => round((array_column($coherenceNullRisk, 'vulnerabillity'))[$i], 2), 'riskQuantity' => (array_column($coherenceNullRisk, 'riskQuantity'))[$i], 'total_data' => (array_column($coherenceNullRisk, 'total_data'))[$i], 'variable' => array_column($coherenceNullRisk, 'variable')[$i]]);
                }
                elseif ((array_column($evapotranspiratioCoherence, 'vulnerabillity'))[$i] == 0 && (array_column($evapotranspiratioCoherence, 'riskQuantity'))[$i] == 0 && (array_column($coherenceNullRisk, 'vulnerabillity'))[$i] == 0 && (array_column($coherenceNullRisk, 'riskQuantity'))[$i] == 0) {
                    array_push($result_coherence_array, ['station' => array_column($evapotranspiratioCoherence, 'station')[$i], 'criterio' => 'Coherencia', 'vulnerabillity' => round((array_column($evapotranspiratioCoherence, 'vulnerabillity'))[$i], 2), 'riskQuantity' => (array_column($evapotranspiratioCoherence, 'riskQuantity'))[$i], 'total_data' => (array_column($evapotranspiratioCoherence, 'total_data'))[$i], 'variable' => array_column($evapotranspiratioCoherence, 'variable')[$i]]);
                }
                elseif ((array_column($coherenceNullRisk, 'vulnerabillity'))[$i] == 0 && (array_column($coherenceNullRisk, 'riskQuantity'))[$i] == 0) {
                    array_push($result_coherence_array, ['station' => array_column($evapotranspiratioCoherence, 'station')[$i], 'criterio' => 'Coherencia', 'vulnerabillity' => 0, 'riskQuantity' => 0, 'total_data' => 0, 'variable' => array_column($evapotranspiratioCoherence, 'variable')[$i]]);
                }
                else {
                    $completeness = (array_column($coherenceNullRisk, 'vulnerabillity'))[$i] + (array_column($evapotranspiratioCoherence, 'vulnerabillity')[$i])/2;
                    $risk_quantity = ((array_column($coherenceNullRisk, 'riskQuantity')[$i]))+(array_column($evapotranspiratioCoherence, 'riskQuantity')[$i])/2;
                    $total_data = ((array_column($coherenceNullRisk, 'total_data')[$i]));

                    array_push($result_coherence_array, ['station' => array_column($evapotranspiratioCoherence, 'station')[$i], 'criterio' => 'Coherencia', 'vulnerabillity' => round($completeness, 2), 'riskQuantity' => round($risk_quantity), 'total_data' => round($total_data), 'variable' => array_column($evapotranspiratioCoherence, 'variable')[$i]]);
                }
            }
        }
        return  $result_coherence_array;





    }


    public function averageRisk($station_id,$variable,$date_start,$date_end){
            $result_array= array();
            for ($j=0;$j<=sizeof($station_id)-1;$j++) {
                if ($variable==0){
                    $variable=$this->variableOldRepository->getVariableByStation(array_column($station_id,'estacion_sk')[$j]);
                }
                for ($i = 0; $i <= sizeof($variable) - 1; $i++) {
                    $correction = $this->correctionHistorialRepository->correctionAverageByStationAndVar(array_column($station_id,'estacion_sk')[$j], array_column($variable,'nombre')[$i], $date_start, $date_end);
                    $total_data = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], array_column($variable,'nombre')[$i], $date_start, $date_end);
                    $vulnerabillity = $this->calculateVulnerabillity(array_column($station_id,'estacion')[$j], array_column($total_data,'count')[0], array_column($correction,'count')[0]);
                    array_push($result_array,['risk'=>'Datos corregidos','station'=>array_column($station_id,'estacion')[$j],'criterio' => 'Integridad','vulnerabillity'=>round($vulnerabillity,2), 'riskQuantity'=>array_column($correction,'count')[0], 'total_data'=>array_column($total_data,'count')[0], 'variable'=>array_column($variable,'nombre')[$i]]);
                }
            }
            return $result_array;
        }


    public function CountNegativeRiskForVar($station_id,$var_array,$date1,$date2){
        $result_array = array();
        for ($j=0;$j<=sizeof($station_id)-1;$j++){
            if ($var_array==0){
                $var_array=$this->variableOldRepository->getVariableByStation(array_column($station_id,'estacion_sk')[$j]);}
            for ($i=0;$i<=sizeof($var_array)-1;$i++){
                $receive= $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j],array_column($var_array,'nombre')[$i],$date1,$date2);
                $negative_data= $this->factTableRepository->CountNegativeRisk(array_column($station_id,'estacion_sk')[$j],array_column($var_array,'nombre')[$i],$date1,$date2);
                $vulnerabillity= $this->calculateVulnerabillity(array_column($station_id,'estacion_sk')[$j],array_column($receive,'count')[0],array_column($negative_data,'count')[0]);
                array_push($result_array,['risk'=>'Datos negativos','station'=>array_column($station_id,'estacion')[$j],'vulnerabillity'=>$vulnerabillity, 'riskQuantity'=>array_column($negative_data,'count')[0], 'total_data'=>array_column($receive,'count')[0], 'variable'=>array_column($var_array,'nombre')[$i]]);
            }
        }
        return $result_array;
            }

        public function nullData($station,$variable,$date_start, $date_end){
            $result_array= array();
            for ($j=0;$j<=sizeof($station)-1;$j++) {
                if ($variable==0){
                    $variable=$this->variableOldRepository->getVariableByStation(array_column($station,'estacion_sk')[$j]);}
                for ($i = 0; $i <= sizeof($variable) - 1; $i++) {
                    $nulls = $this->factTableRepository->CountNullData(array_column($station,'estacion_sk')[$j], array_column($variable,'nombre')[$i], $date_start, $date_end);
                    $total_data = $this->factTableRepository->receiveDataWithNullData(array_column($station,'estacion_sk')[$j], array_column($variable,'nombre')[$i], $date_start, $date_end);
                    $vulnerabillity = $this->calculateVulnerabillity(array_column($station,'estacion')[$j], array_column($total_data,'count')[0],array_column($nulls,'count')[0]);
                    array_push($result_array,['risk'=>'Cantidad de datos nulos','station'=>array_column($station,'estacion')[$j],'vulnerabillity'=>$vulnerabillity, 'riskQuantity'=>array_column($nulls,'count')[0], 'total_data'=> array_column($total_data,'count')[0], 'variable'=>array_column($variable,'nombre')[$i]]);
                }
            }
            return $result_array;
        }


    public function outliers($station,$variable,$date_start, $date_end){
        $result_array= array();
        for ($j=0;$j<=sizeof($station)-1;$j++) {
            //dd($station);
            if ($variable==0){
                $variable=$this->factTableRepository->getVariableByStation(array_column($station,'estacion_sk')[$j]);}

                for ($i = 0; $i <= sizeof($variable)-1; $i++) {
                   // dd($variable,$i);
                    $average=$this->factTableRepository->getAverage(array_column($station,'estacion_sk')[$j],array_column($variable,'nombre')[$i],$date_start,$date_end);
                $deviation=$this->factTableRepository->getDeviation(array_column($station,'estacion_sk')[$j],array_column($variable,'nombre')[$i],$date_start,$date_end);
                $data1=array_column($average,'avg')[$i]-(array_column($deviation,'stddev')[$i] * 2);
                $data2=array_column($average,'avg')[$i]+(array_column($deviation,'stddev')[$i] * 2);

                $outlier= $this->factTableRepository->getOutlier(array_column($station,'estacion_sk')[$j],array_column($variable,'nombre')[$i],$data1,$data2,$date_start,$date_end);
                //dd($data1,$data2,sizeof($outlier),$date_start,$date_end,$variable[$i],$station[$j]);
                $total_data = $this->factTableRepository->receiveDataWithNullData(array_column($station,'estacion_sk')[$j], array_column($variable,'nombre')[$i], $date_start, $date_end);
                $vulnerabillity = $this->calculateVulnerabillity(array_column($station,'estacion_sk')[$j], array_column($total_data,'count')[0], sizeof($outlier));
                array_push($result_array,['outlier'=>$outlier,'deviation'=>round(array_column($deviation,'stddev')[$i],2),'average'=>round(array_column($average,'avg')[$i],2),'start_limit'=>round($data1,2),'end_limit'=>round($data2,2),'risk'=>'Cantidad Outliers','station'=>array_column($station,'estacion')[$j],'criterio' => 'Consistencia','vulnerabillity'=>round($vulnerabillity,2), 'riskQuantity'=>sizeof($outlier), 'total_data'=>array_column($total_data,'count')[0], 'variable'=>array_column($variable,'nombre')[$i]]);
            }
        }

       // dd($result_array);

        return $result_array;

        //dd($result_array);
    }


    public function dataExpectVsReceive($station_id,$var_array,$date1,$date2){
        $date_start = $this->dateDimOldRepository->getDate($date1);
        $date_end = $this->dateDimOldRepository->getDate($date2);
        $dateStart = Carbon::parse($date1);
        $dateEnd = Carbon::parse($date2);
        $diff = $dateStart->diffInDays($dateEnd);
        $result_array= array();
        for ($j=0;$j<=sizeof($station_id)-1;$j++) {
            $total_data= $this->stationOldRepository->getStationDate(array_column($station_id,'estacion_sk')[$j]);
           if (array_column($total_data,'total_medicion_dia') == null){
                $j++;
                $expectative=($diff+1) * 0;
           }else{
            $expectative=($diff+1) * (array_column($total_data, 'total_medicion_dia')[0]);}
            if ($var_array==0){
                $var_array=$this->variableOldRepository->getVariableByStation(array_column($station_id,'estacion_sk')[$j]);
            }
            for ($i = 0; $i <= sizeof($var_array) - 1; $i++) {
                $varExist = $this->variableOldRepository->getVarExistByStation(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i]);
                $receive = $this->factTableRepository->receiveDataWithNullData(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $date_start[0]->fecha_sk, $date_end[0]->fecha_sk);
                    if (array_column($receive,'count')[0] == 0) {
                        $result = 0;
                    } else {
                        $result = Abs($expectative - array_column($receive,'count')[0]) ;
                    }
                    if (sizeof($varExist) == 0) {
                        $result=0;
                    }
                    $vulnerabillity = $this->calculateVulnerabillity(array_column($station_id,'estacion')[$j], array_column($receive,'count')[0] , $result);
                    array_push($result_array, ['risk'=>'Datos recibidos vs datos esperados','station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity, 'riskQuantity' => $result, 'total_data' => array_column($receive,'count')[0], 'variable' =>  array_column($var_array,'nombre')[$i]]);
                }
             }
       return $result_array;
    }


   public function countFactOutOfRangeForVar($station_id,$var_array,$range1,$range2,$date1,$date2)
   {
     //  dd($var_array);
       $result_array= array();
       $result_array_out = array();
       for ($j = 0; $j <= sizeof($station_id)-1; $j++) {

           if ($var_array == 0) {
               $var_array = $this->variableOldRepository->getVariableByStation(array_column($station_id,'estacion_sk')[$j]);
           }
         //  dd($var_array);

           for ($i = 0; $i <= sizeof($var_array) - 1; $i++) {
               if ($range1 == 0 && $range2 == 0) {
                   $var = $this->variableRepository->getVariableNameByVarOldDataWarehouse(array_column($var_array,'nombre')[$i]);
                   $ranges = $this->variableRepository->getVariableInformation(array_column($station_id,'estacion_sk')[$j],$var[0]->id);
                   if ($ranges==null or array_column($ranges,'maximum')[0]==null or array_column($ranges,'minimum')[0]==null){
                       $range_out=0;
                       $receive=0;
                       $vulnerabillity_out=0;

                   }

                  else {
                       $range_uno = array_column($ranges,'maximum')[0];
                       $range_dos = array_column($ranges,'minimum')[0];
                       $receives = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $date1, $date2);
                       $receive = array_column($receives,'count')[0];
                       $range = $this->factTableRepository->countFactOutOfRange(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $range_uno, $range_dos, $date1, $date2);
                       $range_out = array_column($range,'count')[0];
                       $vulnerabillity_out = $this->calculateVulnerabillity(array_column($station_id,'estacion')[$j], $receive, $range_out);
                   }
                  // array_push($result_array,['prueba'=>$var[$i]->maximum,'pruebita'=>$var[$i]->minimum]);

                   //dd($result_array);
                   array_push($result_array_out, ['risk' => 'Datos fuera de los rangos', 'station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity_out, 'riskQuantity' => $range_out, 'total_data' => $receive, 'variable' =>  array_column($var_array,'nombre')[$i]]);
               }
               else{

                       $receive = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $date1, $date2);
                       $range_out = $this->factTableRepository->countFactOutOfRange(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $range1, $range2, $date1, $date2);
                       $vulnerabillity_out = $this->calculateVulnerabillity(array_column($station_id,'estacion')[$j], array_column($receive,'count')[0], array_column($range_out,'count')[0]);
                       array_push($result_array_out, ['risk' => 'Datos fuera de los rangos', 'station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity_out, 'riskQuantity' => array_column($range_out,'count')[0], 'total_data' => array_column($receive,'count')[0], 'variable' => array_column($var_array,'nombre')[$i]]);

                   }
               }


       }
       //dd($result_array_out);
           return $result_array_out;

   }
    public function countFactInOfRangeForVar($station_id,$var_array,$range1,$range2,$date1,$date2)
    {
        $result_array_in = array();
        for ($j = 0; $j <= sizeof($station_id)-1; $j++) {
            if ($var_array == 0) {
                $var_array = $this->variableOldRepository->getVariableByStation(array_column($station_id,'estacion_sk')[$j]);
            }

            for ($i = 0; $i <= sizeof($var_array) - 1; $i++) {
                if ($range1 == 0 && $range2 == 0) {
                    $var = $this->variableRepository->getVariableNameByVarOldDataWarehouse(array_column($var_array,'nombre')[$i]);
                    $ranges = $this->variableRepository->getVariableInformation(array_column($station_id,'estacion_sk')[$j], array_column($var,'id')[0]);
                    if ($ranges==null or $ranges[$i]->maximum==null or $ranges[$i]->minimum==null){
                        $range_in=0;
                        $receive=0;
                        $vulnerabillity_out=0;

                    }
                    else {
                        $range_uno = $ranges[$i]->minimum;
                        $range_dos = $ranges[$i]->maximum;
                        $receives = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $date1, $date2);
                        $receive = array_column($receives,'count')[0];
                        $range = $this->factTableRepository->countFactInOfRange(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $range_uno, $range_dos, $date1, $date2);
                        $range_in = array_column($range,'count')[0];
                        $vulnerabillity_in = $this->calculateVulnerabillity(array_column($station_id,'estacion')[$j], $receive, $range_in);
                    }
                    //array_push($result_array,['prueba'=>$ranges]);
                    array_push($result_array_in, ['risk' => 'Datos fuera de los rangos', 'station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity_in, 'riskQuantity' => $range_in, 'total_data' => $receive, 'variable' => array_column($var_array,'nombre')[$i]]);
                }
                else{

                    $receive = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $date1, $date2);
                    $range_in = $this->factTableRepository->countFactInOfRange(array_column($station_id,'estacion_sk')[$j], array_column($var_array,'nombre')[$i], $range1, $range2, $date1, $date2);
                    $vulnerabillity_in = $this->calculateVulnerabillity(array_column($station_id,'estacion')[$j], array_column($receive,'count')[0], array_column($range_in,'count')[0]);

                    array_push($result_array_in, ['risk' => 'Datos dentro de los rangos', 'station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity_in, 'riskQuantity' => array_column($range_in,'count')[0], 'total_data' => array_column($receive,'count')[0], 'variable' =>array_column($var_array,'nombre')[$i]]);

                }
            }


        }
        // dd($result_array_out);
        return $result_array_in;

    }

    public function calculateEvapotranspirationRisk($station_id,$date1,$date2)
    {
        $var='evapotranspiracion';

        $result_array_in = array();
        for ($j = 0; $j <= sizeof($station_id)-1; $j++) {

                    $risk=$this->factTableRepository->evapotranspirationRisk(array_column($station_id,'estacion_sk')[$j],$date1,$date2);
                    $receive = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], $var, $date1, $date2);
                    $vulnerabillity=$this->calculateVulnerabillity(array_column($station_id,'estacion')[$j],array_column($receive,'count')[0],array_column($risk,'count')[0]);


                    array_push($result_array_in, ['risk' => 'Evapotranspiración existe y las variables con las que se calcula no existen', 'station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity, 'riskQuantity' => array_column($risk,'count')[0], 'total_data' => array_column($receive,'count')[0], 'variable' => $var]);


            }

           // dd($result_array_in);


        return $result_array_in;

    }
    public function calculateEvapotranspirationNullRisk($station_id,$date1,$date2)
    {
        $var='evapotranspiracion';

        $result_array_in = array();
        for ($j = 0; $j <= sizeof($station_id)-1; $j++) {

            $risk=$this->factTableRepository->evapotranspirationNullRisk(array_column($station_id,'estacion_sk')[$j],$date1,$date2);
            $receive = $this->factTableRepository->receiveData(array_column($station_id,'estacion_sk')[$j], $var, $date1, $date2);
            $vulnerabillity=$this->calculateVulnerabillity(array_column($station_id,'estacion')[$j],array_column($receive,'count')[0],array_column($risk,'count')[0]);


            array_push($result_array_in, ['risk' => 'Evapotranspiración no existe y las variables con las que se calculan si existen', 'station' => array_column($station_id,'estacion')[$j], 'vulnerabillity' => $vulnerabillity, 'riskQuantity' => array_column($risk,'count')[0], 'total_data' => array_column($receive,'count')[0], 'variable' => $var]);


        }

        //dd($result_array_in);

        return $result_array_in;

    }


    public function notVarInStation($var_array)
    {
        $result_array = array();
        $aux_array = array();
        $auxvar_array = array();
        $allvar_array = $this->variableRepository->getVariableName();
        for ($i = 0; i<sizeof($allvar_array);$i++){
            array_push($aux_array,$allvar_array[$i]->name);
        }

        for ($i = 0; i<sizeof($allvar_array);$i++){
            array_push($auxvar_array,$var_array[$i]->name);
        }

        for ($i=0;i<sizeof($var_array);$i++){
            if(!in_array($aux_array[$i],$auxvar_array)){
                array_push($result_array,$aux_array[$i]);
            }
        }
        return $result_array;
    }


    public function notExistVarForStationForVar($id_station,$date1,$date2)
    {
        $var_array = $this->stationRepository->findVarForFilter($id_station);
        $notvar_array = $this->NotVarInStation($var_array);
        $result_array = array();
        for ($i=0;$i<sizeof($notvar_array);$i++){
            $result_array[$i]['name'] = $notvar_array[$i];
            $result_array[$i]['count']=  $this->factTableRepository->NotExistVarForStation($id_station,$notvar_array[$i],$date1,$date2);
        }
        return $result_array;
    }

    public function checkRangeFact($fact,$range1,$range2)
    {
        if($fact>$range1 and $fact<$range2){
            return true;
        }
        else{
            return false;
        }
    }

    public function consecutiveErrorsInArray($fact_array,$range1,$range2)
    {
        $count = 0;
        for ($i=0;$i<sizeof($fact_array)-1;$i++){
            if($fact_array[$i]<0 and $fact_array[$i+1]<0){
                $count++;
            }
            elseif (!$this->CheckRangeFact($fact_array[$i],$range1,$range2) and $this->CheckRangeFact($fact_array[$i+1],$range1,$range2)){
                $count++;
            }
        }

        return $count;
    }

    public function consecutiveErrorsForVar($station_id,$var_array,$date1,$date2)
    {

    }

    public function calculateVulnerabillity($station_id,$countStation,$countRule){


        if ($countStation!=0){

        $vulnerabillity= floatval(($countRule*3)/($countStation*3))*100;
     }

        else{
            $vulnerabillity=0;

        }

        return $vulnerabillity;



    }

    /*public function vulnerabillityQualityData($vulnerabillitys){

        foreach ($vulnerabillitys as $key){

        }

    }*/



}