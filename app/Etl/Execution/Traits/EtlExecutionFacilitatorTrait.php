<?php

namespace App\Etl\Execution\Traits;

use App\Etl\Execution\EtlExecute;
use App\Etl\Execution\FilterExecute;
use App\Etl\Execution\Options\FilterOptions\FilterAirOption;
use App\Etl\Execution\Options\FilterOptions\FilterWeatherOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalAirOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalGroundwaterOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalWeatherDatabaseOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalWeatherFilePlaneOption;
use App\Etl\Execution\OriginalExecute;
use App\Repositories\Administrator\StationRepository;

trait EtlExecutionFacilitatorTrait
{
    /**
     * @param StationRepository $stationRepository
     * @param int $net
     * @return array
     */
    public function optionalStationsInNet(StationRepository $stationRepository,int $net) : array
    {
        $arr = [];

        $stationsWeather = $stationRepository->getStationsId($net,'weather');
        if (count($stationsWeather) != 0 ){ $arr['weather'] = $stationsWeather;}

        $stationsAir = $stationRepository->getStationsId($net,'air');
        if (count($stationsAir) != 0 ){ $arr['air'] = $stationsAir;}

        $stationsGroundwater = $stationRepository->getStationsId($net,'groundwater');
        if (count($stationsGroundwater) != 0 ){ $arr['groundwater'] = $stationsGroundwater;}

        return $arr;
    }

    /**
     * @param StationRepository $stationRepository
     * @param int $station
     * @return array
     */
    private function optionalStationInNet(StationRepository $stationRepository,int $station) : array
    {
        return [$stationRepository->getStationId($station) => [$station]];
    }

    /**
     * @param string $initialDate
     * @param string $finalDate
     * @param array $stations
     * @param bool $sequence
     * @param bool $job
     * @return array
     */
    public function FilterWeather(
        string $initialDate,
        string $finalDate,
        array $stations,
        bool $sequence,
        bool $job
    ) : array
    {
        $execute = new EtlExecute(
            $method = new FilterExecute(
                $option = new FilterWeatherOption($stations,$initialDate,$finalDate)
            )
        );

        $execute->setSequence($sequence);
        $option->setRunType(($job)? 'Asynchronous' : 'Synchronous');

        return $execute->execute();
    }

    /**
     * @param string $initialDate
     * @param string $finalDate
     * @param array $stations
     * @param bool $sequence
     * @param bool $job
     * @return array
     */
    public function OriginalWeatherDatabase(
        string $initialDate,
        string $finalDate,
        array $stations,
        bool $sequence,
        bool $job
    ) : array
    {
        $execute = new EtlExecute(
            $method = new OriginalExecute(
                $option = new OriginalWeatherDatabaseOption($stations,$initialDate,$finalDate)
            )
        );

        $execute->setSequence($sequence);
        $option->setRunType(($job)? 'Asynchronous' : 'Synchronous');

        return $execute->execute();
    }

    /**
     * @param int $station
     * @param bool $sequence
     * @param bool $job
     * @param string $fileName
     * @return array
     */
    public function OriginalWeatherPlane(
        int $station,
        bool $sequence,
        bool $job,
        string $fileName
    ) : array
    {
        $execute = new EtlExecute(
            $method = new OriginalExecute(
                $option = new OriginalWeatherFilePlaneOption($station,$fileName)
            )
        );


        $execute->setSequence($sequence);
        $option->setRunType(($job)? 'Asynchronous' : 'Synchronous');

        return $execute->execute();
    }

    /**
     * @param string $initialDate
     * @param string $finalDate
     * @param array $stations
     * @param bool $sequence
     * @param bool $job
     * @return array
     */
    public function FilterAir(
        string $initialDate,
        string $finalDate,
        array $stations,
        bool $sequence,
        bool $job
    ) : array
    {
        $execute = new EtlExecute(
            $method = new FilterExecute(
                $option = new FilterAirOption($stations,$initialDate,$finalDate)
            )
        );

        $execute->setSequence($sequence);
        $option->setRunType(($job)? 'Asynchronous' : 'Synchronous');

        return $execute->execute();
    }

    /**
     * @param int $station
     * @param bool $sequence
     * @param bool $job
     * @param string $extension
     * @param string $fileName
     * @return array
     */
    public function OriginalAir(
        int $station,
        bool $sequence,
        bool $job,
        string $extension,
        string $fileName
    ) : array
    {
        $execute = new EtlExecute(
            $method = new OriginalExecute(
                $option = new OriginalAirOption($station,$extension,$fileName)
            )
        );

        $execute->setSequence($sequence);
        $option->setRunType(($job)? 'Asynchronous' : 'Synchronous');

        $execute->execute();

        dd($execute,$method,$option);

        return $execute->execute();
    }

    /**
     * @return array
     */
    public function FilterGroundwater() : array
    {
        # TODO No disponible para formato de servidor a servidor
        dd('stop => ExecuteEtlController@FilterGroundwater');

        return [];
    }


    /**
     * @param int $station
     * @param bool $sequence
     * @param bool $job
     * @param string $fileName
     * @return array
     */
    public function OriginalGroundwater(
        int $station,
        bool $sequence,
        bool $job,
        string $fileName
    ) : array
    {
        $execute = new EtlExecute(
            $method = new OriginalExecute(
                $option = new OriginalGroundwaterOption($station,$fileName)
            )
        );

        $execute->setSequence($sequence);
        $option->setRunType(($job)? 'Asynchronous' : 'Synchronous');

        return $execute->execute();
    }
}