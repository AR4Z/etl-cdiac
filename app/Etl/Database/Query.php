<?php

namespace App\Etl\Database;

use Carbon\Carbon;
use DB;
use function foo\func;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

class Query
{
    /**
     * @var Builder
     */
    public $query = null;

    /**
     * @var Collection
     */
    public $data = null;

    /**
     * @var bool
     */
    private $init = false;

    /**
     * @var bool
     */
    private $select = false;


    /**
     * @param string $connection
     * @param string $table
     * @return $this
     */
    public function init(string $connection, string $table) : Query
    {
        if (!($connection and $table)){
            dd('Los parametros connection y table son obligatorios para la inicializacion de la consulta');
        }

        $this->query = DB::connection($connection)->table($table);
        $this->init = true;

        return $this;
    }

    /**
     * @param $select
     * @return $this
     */
    public function select(string $select) : Query
    {
        if (!$this->init){ dd('Error no se puede hacer un select sin iniciar la consulta'); }
        if (!$select){dd('Error el parametro select es obligatorio');}
        $this->query->select(DB::raw($select));
        $this->select = true;
        return $this;
    }

    /**
     * @param string $keys
     * @param string $initialDate
     * @param string $initialTime
     * @param string $finalDate
     * @param string $finalTime
     * @return $this
     */
    public function externalWhereBetween(string $keys, string $initialDate, string $initialTime, string $finalDate, string $finalTime)
    {
        if (!$this->select){dd('Error no se puede hacer un where sin el select');}
        if (!$keys){dd('Error el parametro key es obligatorio');}
        if (!($initialTime and $initialDate)){dd('Error los parametros initialTime e initialDate son obligatorios');}
        if (!($finalTime and $finalDate)){dd('Error los parametros finalDate e finalTime son obligatorios');}

        $carbonInitial = Carbon::parse($initialDate.' '.$initialTime);
        $carbonFinal = Carbon::parse($finalDate.' '.$finalTime);

        $this->query->whereBetween(DB::raw("concat_ws(' ',".$keys.")"),[$carbonInitial,$carbonFinal]);

        return $this;
    }

    /**
     * @param int $stationSk
     * @param int $initialDateSk
     * @param int $initialTimeSk
     * @param int $finalDateSk
     * @param int $finalTimeSk
     * @return $this
     */
    public function localWhere(int $stationSk, int $initialDateSk, int $initialTimeSk, int $finalDateSk, int $finalTimeSk) : Query
    {
        if (!$this->select){dd('Error no se puede hacer un where sin el select');}
        if (!($initialTimeSk and $initialDateSk)){dd('Error los parametros initialTime e initialDate son obligatorios');}
        if (!($finalTimeSk and $finalDateSk)){dd('Error los parametros finalDate e finalTime son obligatorios');}

        $this->query->where('station_sk','=',$stationSk);

        $this->query->where(function(Builder $query) use ($initialDateSk,$initialTimeSk,$finalDateSk,$finalTimeSk){
            $query->where('date_sk', '=', $initialDateSk)
                ->where('time_sk' ,'>=' ,$initialTimeSk)
                ->orWhere('date_sk' ,'>' ,$initialDateSk)
                ->where('date_sk', '<' ,$finalDateSk)
                ->orWhere('date_sk' ,'=' ,$finalDateSk)
                ->where('time_sk', '<=' ,$finalTimeSk);
        });

        return $this;
    }

    /**
     * @param string $keys
     * @return $this
     */
    public function orderBy(string $keys) : Query
    {
        if (!$this->select){dd('Error no se puede hacer un order by sin el select');}
        $this->query->orderby(DB::raw($keys), 'asc');

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit) : Query
    {
        if (!$this->select){dd('Error no se puede hacer un limit sin el select');}
        if (!is_null($limit)){$this->query->limit($limit);}
        return $this;
    }

    /**
     * @return $this
     */
    public function execute() : Query
    {
        if (!$this->select){dd('Error no se puede hacer un execute sin el select');}
        $this->data = $this->query->get()->all();
        return $this;
    }

}