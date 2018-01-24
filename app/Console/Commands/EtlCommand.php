<?php

namespace App\Console\Commands;

use App\Jobs\EtlYesterdayJob;
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
    protected $description = 'Execute Etl all yesterday';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        #iniciar el proceso para las estaciones presentes en la tabla de originales
        $this->executeAllOriginalYesterday();

        #iniciar el proceso para las estaciones presentes en la tabla de filtrados
        $this->executeAllFilterYesterday();
    }
}

