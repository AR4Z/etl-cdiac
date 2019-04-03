<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Etl\Etl;
use Storage;

class EtlStationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $work;

    /**
     * EtlStationJob constructor.
     * @param Etl $work
     */
    public function __construct(Etl $work)
    {
        Storage::put('file.txt','Hola');
        $this->work = $work;
    }

    /**
     * TypeExecute the job.
     * @return void
     * @internal param Etl $etl
     */
    public function handle()
    {
        Storage::put('file.txt','Hola');
        $result= $this->work->run();
        Storage::put('file.txt','Hola estoy desde un EtlStationjob final');
    }
}
