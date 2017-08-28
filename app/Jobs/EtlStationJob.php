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
     * @var null
     */
    private $idNet;

    /**
     * Create a new job instance.
     * @param string $typeProcess
     * @param null $idNet
     * @param $idConnection
     * @param $idStation
     * @param bool $sequence
     */
    public function __construct(
        $typeProcess = 'Original',
        $idNet = null,
        $idConnection = null,
        $idStation,
        $sequence = false
    )
    {
        Storage::put('file.txt','Hola');

        $this->typeProcess = $typeProcess;
        $this->idConnection = $idConnection;
        $this->idStation = $idStation;
        $this->sequence = $sequence;
        $this->idNet = $idNet;
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
