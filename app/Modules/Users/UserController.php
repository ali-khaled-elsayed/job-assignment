<?php

namespace App\Modules\Users;

use App\Http\Controllers\Controller;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;
use App\Modules\Users\Requests\ChangePasswordRequest;
use App\Modules\Users\Requests\CreateUserRequest;
use App\Modules\Users\Requests\ListUsersRequest;
use App\Modules\Users\Services\UserService;
use App\Modules\Users\Requests\UpdateUserRequest;
use App\Modules\Users\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function createUser(CreateUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return successJsonResponse(new UserResource($user), __('user.success.create_user'));
    }

    public function updateUser($id, UpdateUserRequest $request)
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return successJsonResponse(new UserResource($user), __('user.success.update_user'));
    }

    public function deleteUser($id)
    {
        $user = $this->userService->deleteUser($id);
        if ($user == true) {
            return successJsonResponse([], __('user.success.delete_user user_id = ' . $user['id']));
        } else {
            return errorJsonResponse("There is No user with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function toggleUserStatus($id)
    {
        $user = $this->userService->toggleUserStatus($id);
        return successJsonResponse(new UserResource($user), __('User.success.User_Status_Changed'));
    }

    public function listAllUsers(ListUsersRequest $request)
    {
        $users = $this->userService->listAllUsers($request->validated());
        return successJsonResponse(data_get($users, 'data'), __('users.success.get_all_Users'), data_get($users, 'count'));
    }

    public function getUserById($userId)
    {
        $user = $this->userService->getUserById($userId);
        if (!$user) {
            return errorJsonResponse("User $userId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new UserResource($user), __('User.success.user_details'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $response =$this->userService->changePassword($request->validated());
        if ($response) {
            return successJsonResponse([], __('User.success.reset_password'));
        }else{
            return errorJsonResponse("Unable to reset password, error:", HttpStatusCodeEnum::Bad_Request->value);
        }
    }
}
