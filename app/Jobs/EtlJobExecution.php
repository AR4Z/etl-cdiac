<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use App\Etl\EtlFactoryContract;

class EtlJobExecution implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var EtlFactoryContract[]
     */
    private $etlProcess;

    /**
     * EtlJobExecution constructor.
     * @param array $etlProcess
     */
    public function __construct(array $etlProcess = [])
    {
        Storage::put('file.txt','Hola');
        $this->etlProcess = $etlProcess;
    }

    /**
     * TypeExecute the job.
     * @return void
     */
    public function handle()
    {
        Storage::put('file.txt','Hola');

        foreach ($this->etlProcess as $process){$process->run();}

        Storage::put('file.txt','Hola estoy desde un EtlStationjob final');
    }
}