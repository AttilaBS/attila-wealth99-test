<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\CreateUserService;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @param CreateUserService $createUserService
     * @return JsonResponse
     */
    public function __invoke(
        CreateUserRequest $request,
        CreateUserService $createUserService
    ): JsonResponse {
        $user = $createUserService($request->validated());

        logger()->info("O usuário de id {$user->id} foi criado!");

        return (new UserResource($user))->response();
    }
}
