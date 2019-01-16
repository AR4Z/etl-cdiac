<?php

namespace App\Entities\Bodega;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $connection = 'bodega';

    protected $table = 'variable';

}
