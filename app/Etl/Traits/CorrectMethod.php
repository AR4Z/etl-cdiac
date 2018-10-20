<?php

namespace App\Etl\Traits;

use DB;

trait CorrectMethod
{

    /**
     * @param $spaceTable
     * @param $variable
     * @param $latestData
     */
    public function correctControl($spaceTable, $variable, $latestData)
    {
        $data = $this->getDataInNull($spaceTable,$variable->local_name,$latestData);

        foreach ($data as $key =>$fact)
        {
            $previousData = $this->getSpecificData($spaceTable,$variable->local_name,($fact->id)-1);
            $nextData = $this->getSpecificData($spaceTable,$variable->local_name,($fact->id)+1);

            if (!is_null($previousData)){
                if (!is_null($previousData->{$variable->local_name})){
                    if (!is_null($nextData)){
                        if (!is_null($nextData->{$variable->local_name})){
                            $this->directionCorrect($variable->correction_type,$spaceTable,$variable->local_name,$fact,$previousData->{$variable->local_name},$nextData->{$variable->local_name});
                            unset($data[$key]);
                        }
                    }

                }
            }

        }
        return;
    }

    /**
     * @param $spaceTable
     * @param $variable
     * @param $value
     * @param $previousData
     */
    public function correctPreviousData($spaceTable, $variable, $value, $previousData)
    {
        $this->updateSpecificData($spaceTable,$variable,$value->id,$previousData);
        $this->updateHistoryCorrect($value,$variable,$previousData,'correct_previous_data');
    }

    /**
     * @param $spaceTable
     * @param $variable
     * @param $value
     * @param $previousData
     * @param $nextData
     */
    public function correctAverageData($spaceTable, $variable, $value, $previousData, $nextData)
    {
        $avg = ($previousData + $nextData )/2;
        $this->updateSpecificData($spaceTable,$variable,$value->id,$avg);
        $this->updateHistoryCorrect($value,$variable,$avg,'correct_average_data');
    }

    /**
     * @param $spaceTable
     * @param $variable
     * @param $value
     * @param $previousData
     * @param $nextData
     */
    public function correctDifferenceData($spaceTable, $variable, $value, $previousData, $nextData)
    {
       $new = abs($previousData - $nextData);
       if ($new > 0.2){
           $this->updateHistoryCorrect($value,$variable,null,'correct_0,2_not_possible');
       }else{
           $this->updateSpecificData($spaceTable,$variable,$value->id,$new);
           $this->updateHistoryCorrect($value,$variable,$new,'correct_average_data');
       }
    }

    /**
     *
     */
    public function correctToZeroData()
    {
        // TODO: fill correct to zero data
    }

    /**
     * @param $correctionType
     * @param $spaceTable
     * @param $variable
     * @param $value
     * @param $previousData
     * @param $nextData
     */
    private function directionCorrect($correctionType, $spaceTable, $variable, $value, $previousData, $nextData)
    {

        switch ($correctionType){
            case "promedio":
                $this->correctAverageData($spaceTable,$variable,$value,$previousData,$nextData);
                break;
            case  "dato_anterior":
                $this->correctPreviousData($spaceTable,$variable,$value,$previousData);
                break;
            case "diferencia_de_0,2":
                $this->correctDifferenceData($spaceTable,$variable,$value,$previousData,$nextData);
                break;
            case "a_cero":
                $this->correctToZeroData();
            default:
                // Metodo de correccion no encontrado

        }
    }

    /**
     * @param $spaceTable
     * @param $variable
     * @param $id
     * @param $value
     * @return mixed
     */
    private function updateSpecificData($spaceTable, $variable, $id, $value)
    {
        return DB::connection('temporary_work')->table($spaceTable)->where('id', '=', $id)->update([$variable => $value]);
    }

    /**
     * @param $spaceTable
     * @param $variable
     * @param $id
     * @return mixed
     */
    private function getSpecificData($spaceTable, $variable, $id)
    {
        return DB::connection('temporary_work')->table($spaceTable)->select('id','station_sk','date_sk','time_sk',$variable)->find($id);
    }

    /**
     * @param $spaceTable
     * @param $variable
     * @param $latestData
     * @return mixed
     */
    private function getDataInNull($spaceTable, $variable, $latestData)
    {
        return DB::connection('temporary_work')
            ->table($spaceTable)
            ->select('id','station_sk','date_sk','time_sk',$variable)
            ->whereNull($variable)
            ->whereNotIn('id',[1,$latestData])
            ->orderby('id')
            ->get();

    }

}