<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

use Facades\App\Repositories\Config\ConnectionRepository;
use Facades\App\Repositories\Config\StationRepository;

class EtlGeneralProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
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
        $connections = ConnectionRepository::where('active', true)->get();

        foreach ($connections as $connection){

            $stations = StationRepository::where('connection_id', $connection->id)->where('active', true)->get();
            foreach ($stations as $station){

                $message = 'Hola estoy desde un job .'.$station->name.' .';

                Storage::put('file.txt',$message);
            }
        }
    }
}
