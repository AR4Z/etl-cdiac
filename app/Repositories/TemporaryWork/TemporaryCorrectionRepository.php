<?php


namespace App\Repositories\TemporaryWork;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\TemporaryCorrection;

class TemporaryCorrectionRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';
    protected $model = TemporaryCorrection::class;
}