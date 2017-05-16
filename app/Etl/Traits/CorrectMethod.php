<?php

namespace App\Etl\Traits;

use DB;


trait CorrectMethod
{

    public function correctControl($spaceTable,$variable,$latestData)
    {
        $data = $this->getDataInNull($spaceTable,$variable->name_locale,$latestData);

        foreach ($data as $key =>$fact)
        {
            $previousData = $this->getSpecificData($spaceTable,$variable->name_locale,($fact->id)-1);
            $nextData = $this->getSpecificData($spaceTable,$variable->name_locale,($fact->id)+1);

            if (!is_null($previousData)){
                if (!is_null($previousData->{$variable->name_locale})){
                    if (!is_null($nextData)){
                        if (!is_null($nextData->{$variable->name_locale})){
                            $this->directionCorrect($variable->correction_type,$spaceTable,$variable->name_locale,$fact,$previousData->{$variable->name_locale},$nextData->{$variable->name_locale});
                            unset($data[$key]);
                        }
                    }

                }
            }

        }
        return;
    }
    public function correctPreviousData($spaceTable,$variable,$value,$previousData)
    {
        $this->updateSpecificData($spaceTable,$variable,$value->id,$previousData);
        $this->updateHistoryCorrect($value,$variable,$previousData,'correct_previous_data');
    }
    
    public function correctAverageData($spaceTable,$variable,$value,$previousData,$nextData)
    {
        $avg = ($previousData + $nextData )/2;
        $this->updateSpecificData($spaceTable,$variable,$value->id,$avg);
        $this->updateHistoryCorrect($value,$variable,$avg,'correct_average_data');
    }
    
    public function correctDifferenceData($spaceTable,$variable,$value,$previousData,$nextData)
    {
       $new = abs($previousData - $nextData);
       if ($new > 0.2){
           $this->updateHistoryCorrect($value,$variable,null,'correct_0,2_not_possible');
       }else{
           $this->updateSpecificData($spaceTable,$variable,$value->id,$new);
           $this->updateHistoryCorrect($value,$variable,$new,'correct_average_data');
       }
    }

    public function correctToZeroData()
    {
        // TODO: fill correct to zero data
    }

    private function directionCorrect($correctionType,$spaceTable,$variable,$value,$previousData,$nextData)
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

    private function updateSpecificData($spaceTable,$variable,$id,$value)
    {
        return DB::connection('temporary_work')->table($spaceTable)->where('id', '=', $id)->update([$variable => $value]);
    }

    private function getSpecificData($spaceTable,$variable,$id)
    {
        return DB::connection('temporary_work')->table($spaceTable)->select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)->find($id);
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
            ->select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)
            ->whereNull($variable)
            ->whereNotIn('id',[1,$latestData])
            ->orderby('id')
            ->get();

    }

}