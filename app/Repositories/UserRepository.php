<?php

namespace App\Repositories;

use App\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

final class UserRepository implements UserRepositoryInterface
{
    protected $model;

    /**
     * @param $model User
     *
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $parameters array<string, string| int>
     *
     * @return User
     */
    public function create(array $parameters): User
    {

        return $this->model->create([
            'name' => $parameters['name'],
            'email' => $parameters['email'],
            'password' => Hash::make($parameters['password']),
        ]);
    }

    /**
     * @param $email string
     *
     * @return null|User
     */
    public function find(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}
