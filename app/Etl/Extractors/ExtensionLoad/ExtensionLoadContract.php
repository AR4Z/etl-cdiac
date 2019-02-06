<?php

namespace App\Etl\Extractors\ExtensionLoad;

use App\Repositories\TemporaryWork\TemporalRepositoryContract;
use Illuminate\Support\Collection;

interface ExtensionLoadContract
{
    /**
     * @param TemporalRepositoryContract $repository
     * @param string $method
     * @param Collection $variables
     * @param string $fileName
     * @return bool
     */
    public function loadFormatData(TemporalRepositoryContract $repository,string $method,Collection $variables,string $fileName) : bool ;

    /**
     * @return bool
     */
    public function isDateTime(): bool;

    /**
     * @param bool $dateTime
     */
    public function setDateTime(bool $dateTime): void;
}