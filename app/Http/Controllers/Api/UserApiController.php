<?php

namespace App\Http\Controllers\Api;

use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function findAll()
    {
        $users = $this->userService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    public function findById($id)
    {
        $user = $this->userService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function store(UserRequest $request)
    {
        $dto = UserDto::fromRequest($request);
        $user = $this->userService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 201);
    }

    public function update(UserRequest $request, $id)
    {
        $dto = UserDto::fromRequest($request);
        $this->userService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->userService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ], 200);
    }
}
