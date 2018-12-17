<?php

namespace App\Entities\Bodega;

use Illuminate\Database\Eloquent\Model;

class FactTable extends Model
{
    protected $connection = 'bodega';

    protected $table = 'fact_table';

}
