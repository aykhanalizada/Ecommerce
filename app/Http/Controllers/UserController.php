<?php

namespace App\Http\Controllers;


use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserStatusRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers();

        return view('user', compact('users'));
    }

    public function store(StoreUserRequest $request)
    {

        $data = $request->validated();

        $user = $this->userService->storeUser(
            $data['firstName'],
            $data['lastName'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['file'] ?? null,
            $data['is_admin'] ?? null);
        return response()->json([
            'message' => 'Successfully created'
        ], 201);
    }


    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();

        $brand = $this->userService->updateUser(
            $data['id'],
            $data['firstName'],
            $data['lastName'],
            $data['username'],
            $data['email'],
            $data['password'] ?? null,
            $data['file'] ?? null,
            $data['is_admin'] ?? null
        );
        if ($brand) {
            return response()->json([
                'message' => 'Successfully updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Brand not found'], 404);
        }

    }

    public function destroy(Request $request)
    {
        $user = $this->userService->destroyUser($request->id);
        if ($user) {
            return response()->json(['message' => 'Successfully deleted']);
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }

    public function updateUserStatus(UpdateUserStatusRequest $request)
    {
        $data = $request->validated();

        $this->userService->updateUserStatus($data['id_user'], $data['is_active']);

        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }


}
