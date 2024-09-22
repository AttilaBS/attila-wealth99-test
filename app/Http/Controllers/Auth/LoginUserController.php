<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

final class LoginUserController extends Controller
{
    public function __invoke(
        UserRequest $request,
        UserRepositoryInterface $userRepository
    ): JsonResponse {
        $validated = $request->validated();
        $user = $userRepository->find($validated['email']);

        if (($user) && Hash::check($validated['password'], $user->password)) {

            return (new UserResource($user))->response();
        }

        return response()->json('Usuário não encontrado');
    }
}
