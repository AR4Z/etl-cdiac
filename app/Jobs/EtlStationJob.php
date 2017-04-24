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
    private $typeProcess;
    /**
     * @var
     */
    private $idConnection;
    /**
     * @var
     */
    private $idStation;
    /**
     * @var bool
     */
    private $sequence;

    /**
     * Create a new job instance.
     * @param $typeProcess
     * @param $idConnection
     * @param $idStation
     * @param bool $sequence
     */
    public function __construct($typeProcess = 'Original',$idConnection,$idStation,$sequence = false)
    {
        Storage::put('file.txt','Hola');

        $this->typeProcess = $typeProcess;
        $this->idConnection = $idConnection;
        $this->idStation = $idStation;
        $this->sequence = $sequence;
    }

    /**
     * Execute the job.
     * @param Etl $etl
     * @return void

     */
    public function handle()
    {
        Storage::put('file.txt','Hola');

        $result= Etl::start($this->typeProcess, $this->idConnection, $this->idStation,$this->sequence)
                        ->extract('Database')
                        ->transform()
                        ->load();

        Storage::put('file.txt','Hola estoy desde un EtlStationjob final');

    }
}
