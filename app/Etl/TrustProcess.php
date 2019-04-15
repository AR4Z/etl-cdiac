<?php

namespace App\Etl;

use App\Repositories\DataWareHouse\ReliabilityRepositoryContract;
use App\Repositories\RepositoriesContract;
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
     * @param int $stationSk
     * @param array $variables
     * @return bool
     */
    public function incomingCalculation(TemporalRepositoryContract $TemporaryWorkRepository, int $stationSk, array $variables) : bool
    {
        if (!$this->active){ return false;}

        $trustActuality = [];
        foreach ($TemporaryWorkRepository->specificConsultValuesRaw($stationSk,$this->generateSelect($variables)) as $value) {
            $actualTrust = $this->repository->firstStationAndDate($value->station_sk,$value->date_sk);
            $trustActuality[] = (empty($actualTrust)) ? $this->createModel($value) : $this->updateModel($actualTrust,$value);
        }

        # Actualizar el estado del proceso de confianza
        $this->trustColumns = $trustActuality;

        return true;
    }


    /**
     * @param TemporalRepositoryContract $temporaryRepository
     * @param int $stationSk
     * @param string $variable
     * @param string $reliability_name
     * @return bool
     */
    public function insertGoods(TemporalRepositoryContract $temporaryRepository, int $stationSk , string $variable, string $reliability_name) : bool
    {
        if (!$this->active){return false;}

        foreach ($temporaryRepository->countVariableFromStationAndDate($stationSk,$variable,$reliability_name.$this->goods) as $value ){
            if (!empty($actualTrust = $this->repository->firstStationAndDate($value->station_sk,$value->date_sk))){
                $this->updateModel($actualTrust, $value);
            }
        }

        return true;
    }

    /**
     * @param $variables
     * @param $measurementsPerDay
     * @return bool
     */
    public function generateTrustAndSupport($variables, $measurementsPerDay)
    {
        if (!$this->active){ return false;}

        foreach ($this->trustColumns as $column){
            $temporal = [];
            $value = $this->repository->getFirstFromStationAndDate($column['station_sk'],$column['date_sk']);
            foreach ($variables as $variable){
                if (!is_null($variable->reliability_name)){
                    $temporal[$variable->reliability_name.$this->trust] = $this->calculateTrust($value->{$variable->reliability_name.$this->incoming},$value->{$variable->reliability_name.$this->goods});
                    $temporal[$variable->reliability_name.$this->support] = $this->calculateSupport($value->{$variable->reliability_name.$this->goods},$measurementsPerDay);
                }
            }
            $this->repository->updateTrustAndSupport($column['station_sk'],$column['date_sk'],$temporal);
        }

        return true;
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
     */
    private function updateModel($actualTrust, $value) : array
    {
        $trustModel = $this->repository->fillingColumnsModel($actualTrust);

        foreach ($value as $key => $val){$trustModel->$key += (!($key == 'station_sk' || $key == 'date_sk')) ? $val:0;}

        $this->repository->queryBuilder()->where('id',$trustModel->id)->update($trustModel->toArray());

        return ['station_sk' => $value->station_sk,'date_sk' => $value->date_sk];
    }

    /**
     * @param $value
     * @return array
     */
    private function createModel($value) : array
    {
        $trustModel = $this->repository->newEmptyEntity();

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

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * @param RepositoriesContract $repository
     */
    public function setRepository(RepositoriesContract $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active) : void
    {
        $this->active = $active;
    }

}