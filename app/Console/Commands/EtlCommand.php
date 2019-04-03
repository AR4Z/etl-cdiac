<?php

namespace App\Console\Commands;

use App\Etl\Execution\{EtlExecute,FilterExecute,OriginalExecute};
use App\Etl\Execution\Options\FilterOptions\FilterWeatherOption;
use App\Etl\Execution\Options\OriginalOptions\OriginalWeatherDatabaseOption;
use App\Repositories\Administrator\StationRepository;
use Illuminate\Console\Command;

class EtlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Etl:Start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TypeExecute Etl all yesterday';

    /**
     * @var StationRepository
     */
    private $stationRepository;

    # php artisan Etl:Star

    /**
     * Create a new command instance.
     * @param StationRepository $stationRepository
     */
    public function __construct(StationRepository $stationRepository)
    {
        parent::__construct();
        $this->stationRepository = $stationRepository;
    }

    /**
     * TypeExecute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        # se extrae la fecha del dia anterior
        $date = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string('-1 days'))->format('Y-m-d');

        #iniciar el proceso para las estaciones presentes en la tabla de originales
        $this->executeAllOriginalWeather($date);

        #iniciar el proceso para las estaciones presentes en la tabla de filtrados
        $this->executeAllFilterWeather($date);
    }

    /**
     * @param string $date
     */
    public function executeAllOriginalWeather(string $date)
    {
        $execute = new EtlExecute(
            $method = new OriginalExecute(
                $option = new OriginalWeatherDatabaseOption(
                    array_column($this->stationRepository->getStationToOriginalMethod('weather'),'id'),
                    $date,
                    $date
                )
            )
        );

        $execute->execute();
    }

    /**
     * @param string $date
     */
    public function executeAllFilterWeather(string $date)
    {
        $execute = new EtlExecute(
            $method = new FilterExecute(
                $option = new FilterWeatherOption(
                    array_column($this->stationRepository->getStationToFilterMethod('weather'),'id'),
                    $date,
                    $date
                )
            )
        );

        $execute->execute();
    }
}

