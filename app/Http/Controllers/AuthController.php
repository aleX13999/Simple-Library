<?php

namespace App\Http\Controllers;

use App\Application\User\DTO\UserCreateData;
use App\Application\User\Exception\UserException;
use App\Application\User\Exception\UserValidationException;
use App\Application\User\UserService;
use App\Http\Requests\User\AdminRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'name'     => 'required|string',
                'email'    => 'required|email|unique:users',
                'password' => 'required|string',
            ],
        );

        $createUserData = new UserCreateData();
        $createUserData
            ->setName($validated['name'])
            ->setEmail($validated['email'])
            ->setPassword($validated['password']);

        try {
            $user = $this->userService->create($createUserData);
        } catch (UserValidationException $exception) {
            return new JsonResponse(['errors' => $exception->getMessage()], 422);
        } catch (UserException $exception) {
            return new JsonResponse(['errors' => $exception->getMessage()], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function registerAdmin(AdminRegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $createUserData = new UserCreateData();
        $createUserData
            ->setName($validated['name'])
            ->setEmail($validated['email'])
            ->setPassword($validated['password']);

        try {
            $user = $this->userService->create($createUserData);

            $user->assignRole('admin');

        } catch (UserValidationException $exception) {
            return new JsonResponse(['errors' => $exception->getMessage()], 422);
        } catch (UserException $exception) {
            return new JsonResponse(['errors' => $exception->getMessage()], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ],
        );

        $user = $this->userService->getOneByEmail($validated['email']);

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return new JsonResponse(['error' => 'The provided credentials are incorrect.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
