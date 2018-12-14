<?php

namespace App\Entities\Bodega;

use Illuminate\Database\Eloquent\Model;

class DateDim extends Model
{
    protected $connection = 'bodega';

    protected $table = 'date_dim';

}
