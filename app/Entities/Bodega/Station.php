<?php

namespace App\Entities\Bodega;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $connection = 'bodega';

    protected $table = 'estacion';

}
