<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;

class CreateUserService
{
    private $userRepository;
    /**
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $params
     * @return User
     */
    public function __invoke(array $params): User
    {
        return $this->userRepository->create($params);
    }
}
