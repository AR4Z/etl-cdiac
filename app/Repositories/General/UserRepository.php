<?php

namespace App\Repositories\General;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\General\User;
use DB;

class UserRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(User::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Builder
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function queryBuilder(): Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
    }

    /**
     * @param User $user
     * @return User
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function createUser(User $user) : User
    {
        $user = $this->createModel()->fill($user);
        $user->password = bcrypt($user->password);
        return $this->create($user->toArray());
    }
}
