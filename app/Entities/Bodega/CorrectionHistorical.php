<?php

namespace App\Entities\Bodega;

use Illuminate\Database\Eloquent\Model;

class CorrectionHistorical extends Model
{
    protected $connection = 'bodega';

    protected $table = 'historial_correccion';

}
