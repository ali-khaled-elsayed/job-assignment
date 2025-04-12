<?php

namespace  App\Modules\Users\Services;

use App\Modules\Users\Resources\UserCollection;
use App\Modules\Users\Repositories\UsersRepository;
use App\Modules\Users\Requests\ListAllUsersRequest;

class UserService
{
    public function __construct(private UsersRepository $usersRepository)
    {
    }

    public function createUser($request)
    {
        $user = $this->constructUserModel($request);
        return $this->usersRepository->create($user);
    }

    public function updateUser($id, $request)
    {
        $user = $this->constructUserModel($request);
        return $this->usersRepository->update($id, $user);
    }

    public function deleteUser($id)
    {
        return $this->usersRepository->delete($id);
    }

    public function listAllUsers(array $queryParameters)
    {
        // Construct Query Criteria
        $listAllUsers = (new ListAllUsersRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $users = $this->usersRepository->findAllBy($listAllUsers);

        return [
            'data' => new UserCollection($users['data']),
            'count' => $users['count']
        ];
    }

    public function toggleUserStatus($id)
    {
        $user = $this->usersRepository->find($id);
        $user->toggleStatus();
        return $user;
    }

    public function getUserById($id)
    {
        return $this->usersRepository->find($id);
    }

    public function constructUserModel($request)
    {
        $userModel = [
            'name' => $request['name'],
            'email' => $request['email'],
            'language' => $request['language'],
            'phone' => $request['phone'],
            'fulfillment_center_id' => $request['fulfillmentCenterId'],
            'role_id' => $request['roleId']?? '2',
            'settings' => $request['settings'],
        ];
        
        if (!isset($request['settings']['canPrintGift'])) {
            $userModel['settings']['canPrintGift']= false;
        }
        if (!isset($request['settings']['canPrintSlip'])) {
            $userModel['settings']['canPrintSlip']= false;
        }
        return $userModel;
    }

    public function getUserByEmail($email){
        return $this->usersRepository->getUserByEmail($email);
    }

    public function changePassword($request){
        $user = $this->usersRepository->find($request['id']);
        $user->password = bcrypt($request['password']);
        return $user->save();
    }
}
