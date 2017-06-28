<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateInPath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:inPath {action? : action execute [ migrate | reset | rollback | refresh | rollback ]} { pre_path? : path for execute [ administrator | etl | dataWareHouse ] }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrations with custom path';

    protected $route = 'database/migrations/';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        $path =  $this->argument('pre_path');

        if ($this->validateAction($action) and $this->validatePath($path)){
            if ($action == 'migrate'){
                $this->line('executing migrate:'.$action.' --path='.$this->route.''.$path);
                Artisan::call($action, [ '--path' => $this->route.''.$path ]);
                $this->line(Artisan::output());
            }else{
                $this->line('executing migrate:'.$action.' --path='.$this->route.''.$path);
                Artisan::call('migrate:'.$action, [ '--path' => $this->route.''.$path]);
                $this->line(Artisan::output());
            }
        }
    }

    private function validateAction($action)
    {
        if (is_null($action)){
            $this->error('action is required for execution');
            return false;
        }

        if ($action != 'migrate' and $action != 'reset' and $action != 'rollback' and $action != 'refresh' and $action != 'rollback'){
            $this->error(' action is optional field [ migrate | reset | rollback | refresh | rollback ]');
            return false;
        }

        return true;
    }

    private function validatePath($path){

        if (is_null($path)){
            $this->error('path is required for execution');
            return false;
        }

        if ($path != 'administrator' and $path != 'etl' and $path != 'dataWareHouse'){
            $this->error(' path is optional field [ administrator | etl | dataWareHouse ]');
            return false;
        }

        return true;
    }


}