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

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $dto = UserDto::fromRequest($request);
        $user = $this->userService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 201);
    }

    public function getUserById($id)
    {
        $user = $this->userService->getById((int) $id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, int $id)
    {
        $dto = UserDto::fromRequest($request);
        $this->userService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
