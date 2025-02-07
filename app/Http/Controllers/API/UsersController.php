<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return ApiResponseHelper::executeWithApiResponse(function () use ($request) {
            $perPage = $request->query('per_page', 15);

            $perPage = min(max((int) $perPage, 1), 100); 


            $users = $this->userRepository->paginateUsers($perPage);
            return [
                'data' => UserResource::collection($users),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'next_page_url' => $users->nextPageUrl(),
                    'prev_page_url' => $users->previousPageUrl(),
                ],
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        return ApiResponseHelper::executeWithApiResponse(function () use ($request) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            return new UserResource($this->userRepository->createUser($validatedData));
        }, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return ApiResponseHelper::executeWithApiResponse(fn() => new UserResource($this->userRepository->findUser($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request): JsonResponse
    {
        return ApiResponseHelper::executeWithApiResponse(function () use ($request, $id) {
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => "sometimes|email|unique:users,email,{$id}",
                'password' => 'sometimes|string|min:8',
            ]);

            return $this->userRepository->updateUser($id, $validatedData) ? 'User updated successfully' : 'User not updated found';
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return ApiResponseHelper::executeWithApiResponse(fn() => ['message' => $this->userRepository->deleteUser($id) ? 'User deleted successfully' : 'User not found']);
    }
}
