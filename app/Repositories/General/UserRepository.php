<?php

namespace App\Repositories\General;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Rinvex\Repository\Exceptions\RepositoryException;
use App\Entities\Users\User;

class UserRepository extends AppBaseRepository implements RepositoriesContract
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
     * @param array $user_data
     * @return User
     */
    public function createUser(array $user_data): User
    {
        $user = $this->createModel();
        $user->fill($user_data + ['confirmed_code' => str_random(30)]);
        $user->password = bcrypt($user->password);

        return $this->create($user->toArray());
    }
}
