<?php

namespace App\Console\Commands;

use App\Etl\Etl;
use App\Jobs\EtlYesterdayJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Etl\Traits\BaseExecuteEtl;

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
    protected $description = 'Execute Etl all yesterday';
    /**
     * @var EtlYesterdayJob
     */
    private $etlYesterdayJob;

    /**
     * Create a new command instance.
     * @param EtlYesterdayJob $etlYesterdayJob
     */
    public function __construct(EtlYesterdayJob $etlYesterdayJob)
    {
        parent::__construct();

        $this->etlYesterdayJob = $etlYesterdayJob;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->etlYesterdayJob::dispatch();
        #iniciar el proceso para las estaciones presentes en la tabla de originales
        //$this->executeAllOriginalYesterday();

        #iniciar el proceso para las estaciones presentes en la tabla de filtrados
        //$this->executeAllFilterYesterday();
    }
}

