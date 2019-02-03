<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class BaseFactStructureRepository extends AppBaseRepository
{
    /**
     * @param int $stationSk
     * @param int $dateSk
     * @param int $timeSk
     * @return bool
     */
    public function evaluateExistence(int $stationSk,int $dateSk,int $timeSk) : bool
    {
        $count = $this->selectRaw('count(station_sk) AS count')
            ->where('date_sk','=', $dateSk)
            ->where('station_sk','=',$stationSk)
            ->where('time_sk','=',$timeSk)
            ->get()->toArray()[0]['count'];

        return ($count == 0) ? false : true;
    }

    /**
     * @param int $dateSk
     * @return int
     */
    public function countRowForDate(int $dateSk)
    {
        return $this->queryBuilder()->select('*')->where('date_sk',$dateSk)->count();
    }

    /**
     * @param $dateSk
     * @param $timeSk
     * @return int
     */
    public function deleteFromDateAndTime(int $dateSk, int $timeSk)
    {
        return $this->queryBuilder()->where('date_sk',$dateSk)->where('time_sk',$timeSk)->delete();
    }

    /**
     * @param int $stationSk
     * @param string $variable
     * @param string $as
     * @return Collection
     */
    public function countVariableFromStationAndDate(int $stationSk, string $variable, string $as = 'variable') : Collection
    {
        return $this->queryBuilder()
            ->selectRaw("CAST(station_sk AS integer),CAST(date_sk AS integer),COUNT($variable) AS $as")
            ->where('station_sk',$stationSk)
            ->groupby('station_sk','date_sk')
            ->orderByRaw("station_sk asc,date_sk asc")
            ->get();
    }

    /**
     * @param int $stationSk
     * @param string $countSelect
     * @return Collection
     */
    public function specificConsultValuesRaw(int $stationSk, string $countSelect) : Collection
    {
        return $this->queryBuilder()
            ->selectRaw('CAST(station_sk AS integer),CAST(date_sk AS integer),'.$countSelect)
            ->where('station_sk',$stationSk)
            ->groupby('station_sk','date_sk')
            ->orderByRaw('station_sk asc,date_sk asc')
            ->get();
    }
}