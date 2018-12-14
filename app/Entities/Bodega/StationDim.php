<?php

namespace App\Entities\Bodega;

use Illuminate\Database\Eloquent\Model;

class StationDim extends Model
{
    protected $connection = 'bodega';

    protected $table = 'station_dim';

}
