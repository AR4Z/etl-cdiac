<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface BaseFactStructureContract extends RepositoriesContract
{
    /**
     * @param int $stationSk
     * @param int $dateSk
     * @param int $timeSk
     * @return bool
     */
    public function evaluateExistence(int $stationSk,int $dateSk,int $timeSk) : bool;

    /**
     * @param int $dateSk
     * @return int
     */
    public function countRowForDate(int $dateSk);

    /**
     * @param $dateSk
     * @param $timeSk
     * @return int
     */
    public function deleteFromDateAndTime(int $dateSk, int $timeSk);

    /**
     * @param int $stationSk
     * @param string $variable
     * @param string $as
     * @return Collection
     */
    public function countVariableFromStationAndDate(int $stationSk, string $variable, string $as = 'variable') : Collection;

    /**
     * @param int $stationSk
     * @param string $countSelect
     * @return Collection
     */
    public function specificConsultValuesRaw(int $stationSk, string $countSelect) : Collection;
}