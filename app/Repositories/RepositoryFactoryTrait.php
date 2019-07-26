<?php

namespace App\Repositories;

use Illuminate\Container\Container;

trait RepositoryFactoryTrait
{
    /**
     * @param string $repository
     * @return RepositoriesContract
     */
    public function factoryRepositories(string $repository) : RepositoriesContract
    {
        return new $repository(Container::getInstance());
    }
}