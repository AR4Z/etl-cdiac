<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class MigrateInPath extends Command
{
    /**
     *  Execution Example => php artisan migrate:inPath $optionAction $optionPath --seed
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:inPath {action} {pre_path} {--seed : Indicates if the seed task should be re-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrations with custom path';

    /**
     * @var string
     */
    protected $route = '/database/migrations/';

    /**
     * @var array
     */
    protected $optionPaths = ['public','administrator', 'dataWareHouse','temporaryWork','audit','user'];

    /**
     * @var array
     */
    protected $optionActions = ['migrate','reset','refresh'];

    /**
     * @var array
     */
    protected $actionCompatibilitySeed = ['migrate','refresh'];

    /**
     * @var array
     */
    protected $seedOptions = [
        'administrator' => 'AdministratorProcessSeeder',
        'dataWareHouse' => 'DataWareHouseProcessSeeder',
        'user'          => 'UserSeeder'
    ];

    /**
     * TypeExecute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $flag = false;

        if ($this->validateAction($this->argument('action')) and $this->validatePath($this->argument('pre_path'))){
            $this->migrateCall(
                ($this->argument('action') == 'migrate') ? "migrate" : "migrate:{$this->argument('action')}",
                $this->route.$this->argument('pre_path')
            );
            $flag = true;
        }

        if ($this->option('seed') and $flag){
            if ($this->validateCompatibilitySeed($this->argument('action'),$this->argument('pre_path'))){
                $this->seedCall($this->argument('pre_path'));
            }
        }

        return;
    }

    /**
     * @param string $action
     * @param string $path
     * @return bool
     */
    private function validateCompatibilitySeed(string $action,string $path) :bool
    {
        if (!in_array($action,$this->actionCompatibilitySeed,true)){
            $this->info("the action {$action} is not compatible. Try alone with [ ".implode(' | ',$this->actionCompatibilitySeed)." ]");
            return false;
        }

        if (!in_array($path,array_keys($this->seedOptions),true)){
            $this->info("the path {$path} is not compatible. Try alone with [ ".implode(' | ',array_keys($this->seedOptions))." ]");
            return false;
        }

        if (is_null($this->seedOptions[$path])){
            $this->info("the path {$path} is not configured. enter the value in MigrateInPath:seedOptions:$path");
            return false;
        }

        return true;
    }

    /**
     * @param string $action
     * @return bool
     */
    private function validateAction(string $action) : bool
    {
        if (is_null($action)){
            $this->error('Action is required for execution');
            return false;
        }

        if (!in_array($action,$this->optionActions,true)){
            $this->error("Action is optional field [ ".implode(' | ',$this->optionActions)." ]");
            return false;
        }

        return true;
    }

    /**
     * @param string $path
     * @return bool
     */
    private function validatePath(string $path) : bool
    {
        if (is_null($path)){
            $this->error('path is required for execution');
            return false;
        }

        if (!in_array($path,$this->optionPaths,true)){
            $this->error("path is optional field [ ".implode(' | ',$this->optionPaths)." ]");
            return false;
        }

        return true;
    }

    /**
     * @param string $command
     * @param string $path
     */
    private function migrateCall(string $command, string $path)
    {
        $this->comment("executing $command --path=$path");

        Artisan::call($command,['--path'=> $path, '-vvv' => true],$this->getOutput());
    }

    /**
     * @param string $path
     */
    private function seedCall(string $path)
    {
        $this->comment("executing db:seed --class={$this->seedOptions[$path]}");

        Artisan::call('db:seed',['--class'=> $this->seedOptions[$path],'-vvv' => true],$this->getOutput());
    }
}