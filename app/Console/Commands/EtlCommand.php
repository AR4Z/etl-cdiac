<?php

namespace App\Console\Commands;

use App\Etl\Etl;
use App\Jobs\EtlYesterdayJob;
use App\Repositories\Administrator\StationRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Etl\Traits\BaseExecuteEtl;


class EtlCommand extends Command
{
    use BaseExecuteEtl;
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
     * @var EtlYesterdayJob
     */
    private $etlYesterdayJob;
    /**
     * @var StationRepository
     */
    private $stationRepository;

    # php artisan Etl:Star

    /**
     * Create a new command instance.
     * @param EtlYesterdayJob $etlYesterdayJob
     * @param StationRepository $stationRepository
     */
    public function __construct(EtlYesterdayJob $etlYesterdayJob,StationRepository $stationRepository)
    {
        parent::__construct();

        $this->etlYesterdayJob = $etlYesterdayJob;
        $this->stationRepository = $stationRepository;
    }

    /**
     * TypeExecute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->etlYesterdayJob::dispatch();
        #iniciar el proceso para las estaciones presentes en la tabla de originales
        $this->executeAllOriginalYesterday();

        #iniciar el proceso para las estaciones presentes en la tabla de filtrados
        $this->executeAllFilterYesterday();
    }
}

