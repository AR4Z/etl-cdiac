<?php

namespace App\Console\Commands;

use App\Jobs\EtlGeneralProcessJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
        dispatch(new EtlGeneralProcessJob());
    }
}

