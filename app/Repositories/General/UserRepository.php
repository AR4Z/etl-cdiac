<?php

namespace App\Repositories\General;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\General\User;
/**
 *
 */
class UserRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = User::class;

  public function createUser($user)
  {
    $user = $this->createModel()->fill($user);
    $user->password = bcrypt($user->password);
    return $this->create($user->toArray());
  }

}
