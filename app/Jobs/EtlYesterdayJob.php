<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Etl\Traits\BaseExecuteEtl;

class EtlYesterdayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BaseExecuteEtl;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        #iniciar el proceso para las estaciones presentes en la tabla de originales
        $this->executeAllOriginalYesterday();

        #iniciar el proceso para las estaciones presentes en la tabla de filtrados
        $this->executeAllFilterYesterday();
    }
}
