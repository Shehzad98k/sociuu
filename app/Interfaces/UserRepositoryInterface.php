<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById($userId);
    public function deleteUser($userId);
    public function createUser(array $userDetails, array $groups);
    public function updateUser($userId, array $newDetails);
    public function syncGroups($userId, array $groups);
    public function userFilters($filters);
}
