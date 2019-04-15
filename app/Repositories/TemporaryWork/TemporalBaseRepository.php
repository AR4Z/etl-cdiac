<?php

namespace App\Repositories\TemporaryWork;

use App\Repositories\DataWareHouse\BaseFactRepository;
use Illuminate\Support\Collection;

class TemporalBaseRepository extends BaseFactRepository
{
    /**
     * @param string $select
     * @return array
     */
    public function getAllDataPersonalSelect(string $select = '*') : array
    {
        return $this->queryBuilder()
            ->selectRaw($select)
            ->whereNotNull('station_sk')
            ->whereNotNull('date_sk')
            ->whereNotNull('time_sk')
            ->get()
            ->toArray();
    }

    /**
     * @return int
     */
    public function getIncomingAmount() : int
    {
        return $this->queryBuilder()->selectRaw('COUNT(id) AS count')->get()->toArray()[0]->count;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getLastMigrateData()
    {
        return $this->queryBuilder()->orderby('id','DESC')->first();
    }

    /**
     * @param $stationSk
     * @param $dateSk
     * @param $initTimeSk
     * @param $finalTimeSk
     * @return Collection
     */
    public function getValInRange($stationSk,$dateSk, $initTimeSk, $finalTimeSk) : Collection
    {
        return $this->queryBuilder()
            ->select('*')
            ->where('station_sk',$stationSk)
            ->where('date_sk', $dateSk)
            ->whereBetween('time_sk',[$initTimeSk,$finalTimeSk])
            ->orderby('date_sk','ASC')
            ->orderby('time_sk','ASC')
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getInitialData()
    {
        return $this->queryBuilder()->select('*')->orderByRaw("date_sk ASC, time_sk ASC")->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getFinalData()
    {
        return $this->queryBuilder()->select('*')->orderByRaw("date_sk DESC, time_sk DESC")->first();
    }

    /**
     * @param string $variable
     * @param array $search
     * @return Collection
     */
    public function getVariableToSearchLimit(string $variable, array $search) : Collection
    {
        return $this->queryBuilder()
            ->select('id','station_sk','date_sk','time_sk',$variable)
            ->whereIn($variable,$search)
            ->orderby('id')
            ->get();
    }

    /**
     * @param int $stationSk
     * @return array
     */
    public function getDuplicates(int $stationSk) : array
    {
        return $this->queryBuilder()
            ->selectRaw('station_sk,date_sk,time_sk, max(id)')
            ->where('station_sk',$stationSk)
            ->groupBy('station_sk','date_sk','time_sk')
            ->havingRaw('count(station_sk) > 1')
            ->orderByRaw('station_sk, date_sk, time_sk')
            ->get()
            ->toArray();
    }

    /**
     * @param int $timeSk
     * @param null $time
     * @return mixed
     */
    public function updateTimeFromTimeSk(int $timeSk, $time = null)
    {
        return $this->queryBuilder()->where('time_sk', '=',$timeSk)->update(['time'=> $time]);
    }

    /**
     * @param int $dateSk
     * @param null $date
     * @return mixed
     */
    public function updateDateFromDateSk(int $dateSk, $date = null)
    {
        return $this->queryBuilder()->where('date_sk', '=',$dateSk)->update(['date'=> $date]);
    }

    /**
     * @param string $key
     * @param string $column
     * @return mixed
     */
    public function selectColumnWhereNull(string $key, string $column) : array
    {
        return $this->queryBuilder()
            ->select($key)
            ->distinct($column) // TODO este distintic no recibe paametros...
            ->whereNull($column)
            ->orderBy($key)
            ->get()
            ->toArray();
    }

    /**
     * @return Collection
     */
    public function getIdAndDateTime() : Collection
    {
        return $this->queryBuilder()->select('id','date','time')->get();
    }

    /**
     * @return Collection
     */
    public function getDateTime(): Collection
    {
        return $this->select('id','date_time')->get();
    }

    /**
     * @param string $variable
     * @return mixed
     */
    public function deleteNullVariable(string $variable)
    {
        return $this->queryBuilder()->whereNull($variable)->delete();
    }

    /**
     * @param string $commentInit
     * @param string $commentFinal
     * @return array
     */
    public function gerElementsWhereInComments(string $commentInit, string $commentFinal) : array
    {
        return $this->queryBuilder()
            ->where('comment','like',"%$commentInit%")
            ->orWhere('comment','like',"%$commentFinal%")
            ->orderBy('id')
            ->get(['id','comment'])
            ->toArray();
    }

}