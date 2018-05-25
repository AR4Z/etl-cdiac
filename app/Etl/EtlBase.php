<?php

namespace App\Etl;

use App\Etl\Traits\CorrectMethod;
use App\Etl\Traits\DateSkTrait;
use app\Etl\Traits\RemoveAccents;
use App\Etl\Traits\TimeSkTrait;
use app\Etl\Traits\TrustTrait;
use App\Etl\Traits\WorkDatabaseTrait;

class EtlBase
{
    use TrustTrait,DateSkTrait,TimeSkTrait,CorrectMethod,RemoveAccents, WorkDatabaseTrait;

}