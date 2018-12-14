<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;

class InformationRequest extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'information_request';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'comment','subject','information_use','purpose','creation_date','answer_date','petitioner_name','petitioner_email',
        'petitioner_entity','petitioner_phone','petitioner_occupation','petitioner_profession'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at','creation_date','answer_date'
    ];
}
