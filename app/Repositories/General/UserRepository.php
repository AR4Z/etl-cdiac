<?php

namespace App\Repositories\General;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Rinvex\Repository\Exceptions\RepositoryException;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\General\User;

class UserRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(User::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param User $user
     * @return User
     */
    public function createUser(User $user) : User
    {
        try { $user = $this->createModel()->fill($user); } catch (RepositoryException $e) { /*TODO*/}
        $user->password = bcrypt($user->password);
        return $this->create($user->toArray());
    }
}
