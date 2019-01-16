<?php

namespace App\Etl;

use App\Repositories\DataWareHouse\ReliabilityRepositoryContract;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;
use App\Etl\Traits\WorkDatabaseTrait;

class TrustProcess
{
    use WorkDatabaseTrait;
    /**
     * @var bool
     */
    public $active = false;

    /**
     * @var string
     */
    public $table = '';

    /**
     * @var ReliabilityRepositoryContract
     */
    public $repository = null;

    /**
     * @var string
     */
    private $incoming = '_total_records';

    /**
     * @var string
     */
    private $goods = '_correct_records';

    /**
     * @var string
     */
    private $support = '_support';

    /**
     * @var string
     */
    private $trust = '_trust';

    /**
     * @var array
     */
    private $trustColumns = [];

    /**
     * @var int
     */
    private $incomingAmount = 0;

    /**
     * @param TemporalRepositoryContract $TemporaryWorkRepository
     * @param $variables
     * @return array
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function incomingCalculation(TemporalRepositoryContract $TemporaryWorkRepository,$variables)
    {
        $trustActuality = [];

        foreach ($this->specificConsultValuesRawWDT($TemporaryWorkRepository,$this->generateSelect($variables)) as $value) {
            $actualTrust = $this->firstStationAndDateWDT($this->repository,$value->station_sk,$value->date_sk);
            array_push($trustActuality, (empty($actualTrust)) ? $this->createModel($value) : $this->updateModel($actualTrust,$value));
        }

        return $trustActuality;
    }

    /**
     * @param TemporalRepositoryContract $temporaryRepository
     * @param $variable
     * @param $reliability_name
     * @return void
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function insertGoods(TemporalRepositoryContract $temporaryRepository, $variable, $reliability_name) // TODO -->modificado
    {
        foreach ($this->countVariableFromStationAndDateWDT($temporaryRepository,$variable,$reliability_name.$this->goods) as $value ){
            if (count($actualTrust = $this->firstStationAndDateWDT($this->repository,$value->station_sk,$value->date_sk)) > 0){
                $this->updateModel($actualTrust, $value);
            }
        }
    }

    /**
     * @param $variables
     * @param $measurementsPerDay
     */
    public function generateTrustAndSupport($variables, $measurementsPerDay)
    {
        foreach ($this->trustColumns as $column){
            $value = $this->repository->getFirstFromStationAndDate($column['station_sk'],$column['date_sk']);
            foreach ($variables as $variable){
                if (!is_null($variable->reliability_name)){

                    $total_records = $value->{$variable->reliability_name.$this->incoming};
                    $correct_records = $value->{$variable->reliability_name.$this->goods};

                    $value->{$variable->reliability_name.$this->trust} = $this->calculateTrust($total_records,$correct_records);
                    $value->{$variable->reliability_name.$this->support} = $this->calculateSupport($correct_records,$measurementsPerDay);
                }
            }
            $value->update();
        }
    }


    /**
     * @param $total_records
     * @param $correct_records
     * @return float|int|null
     */
    private function calculateTrust($total_records, $correct_records)
    {
        if (is_null($total_records) or is_null($correct_records)){return 0;}

        return ($total_records != 0 and $correct_records != 0 ) ? round(($correct_records / $total_records),4) : 0;

    }

    /**
     * @param $correct_records
     * @param $measurementsPerDay
     * @return float|int|null
     */
    private function calculateSupport($correct_records, $measurementsPerDay)
    {
        if (is_null($correct_records) or is_null($measurementsPerDay)){ return 0;}

        return ($correct_records != 0 and $measurementsPerDay != 0 ) ?  round(($correct_records / $measurementsPerDay),4) : 0 ;

    }

    /**
     * @param $actualTrust
     * @param $value
     * @return array
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    private function updateModel($actualTrust, $value) : array
    {
        $trustModel = $this->repository->createModel()->fill($actualTrust);

        foreach ($value as $key => $val){$trustModel->$key += (!($key == 'station_sk' || $key == 'date_sk')) ? $val:0;}

        $this->repository->getFirstFromStationAndDate($trustModel->station_sk,$trustModel->date_sk)->fill($trustModel->toArray())->save();

        return ['station_sk' => $value->station_sk,'date_sk' => $value->date_sk];
    }

    /**
     * @param $value
     * @return array
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    private function createModel($value) : array
    {
        $trustModel = $this->repository->createModel();
        foreach ($value as $key => $val){$trustModel->$key = $val;}
        $trustModel->save();

        return ['station_sk' => $trustModel->station_sk,'date_sk' => $trustModel->date_sk];
    }

    /**
     * @param $variables
     * @return string
     */
    private function generateSelect($variables)
    {
        $text = '';
        foreach ($variables as $variable){
            if (!is_null($variable->reliability_name)){
                $text .= 'COUNT(case '.$variable->local_name.' when \'-\' then null else 1 end) AS '. $variable->reliability_name .''.$this->incoming.',';
            }
        }
        $text[strlen($text)-1] = ' ';

        return $text;
    }

    /**
     * @param array $trustColumns
     */
    public function setTrustColumns(array $trustColumns)
    {
        $this->trustColumns = $trustColumns;
    }

    /**
     * @return int
     */
    public function getIncomingAmount(): int
    {
        return $this->incomingAmount;
    }

    /**
     * @param int $incomingAmount
     */
    public function setIncomingAmount(int $incomingAmount)
    {
        $this->incomingAmount = $incomingAmount;
    }

}