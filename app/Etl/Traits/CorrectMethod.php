<?php

namespace App\Etl\Traits;

use DB;

trait CorrectMethod
{

    public function correctPreviousData($spaceWorkRepository,$spaceTable,$variable)
    {
        $data = $this->getDataInNull($spaceTable,$variable);

        foreach ($data as $key =>$fact)
        {
            if ($fact->id != 1){ // falta hacer la validacion si es el ultimo dato
                $previousData = $this->getSpecificData($spaceTable,$variable,($fact->id)-1);
                $nextData = $this->getSpecificData($spaceTable,$variable,($fact->id)+1);

                if ($previousData){
                    if ($previousData->$variable){
                        if ($nextData){
                            if ($nextData->$variable){
                                $this->updateSpecificData($spaceTable,$variable,$fact->id,$previousData->$variable);
                                unset($data[$key]);
                            }
                        }

                    }
                }
            }
        }

        dd($data);


    }
    
    public function correctAverageData()
    {
        
    }
    
    public function correctDifferenceData()
    {
        
    }

    public function correctToZeroData()
    {

    }

    private function updateSpecificData($spaceTable,$variable,$id,$value)
    {
        return DB::connection('temporary_work')->table($spaceTable)->where('id', '=', $id)->update([$variable => $value]);
    }

    private function getSpecificData($spaceTable,$variable,$id)
    {
        return DB::connection('temporary_work')->table($spaceTable)->select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)->find($id);
    }

    private function getDataInNull($spaceTable,$variable)
    {
        return DB::connection('temporary_work')
            ->table($spaceTable)
            ->select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)
            ->whereNull($variable)
            ->orderby('id')
            ->get();
    }

}