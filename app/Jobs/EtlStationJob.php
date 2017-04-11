<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Etl\Etl;
use Illuminate\Support\Facades\Storage;

class EtlStationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param $typeProcess
     * @param $idConnection
     * @param $idStation
     * @param bool $sequence
     * @return void
     */
    public function handle($typeProcess,$idConnection,$idStation,$sequence = false)
    //public function handle()
    {
        Storage::put('file.txt','Hola estoy desde un EtlStationjob');

        Etl::start($typeProcess, $idConnection, $idStation,$sequence)
            ->extract('Database')
            ->transform()
            ->load();

        Storage::put('file.txt','Hola estoy desde un EtlStationjob final');

    }
}
