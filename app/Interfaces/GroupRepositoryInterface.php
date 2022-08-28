<?php

namespace App\Interfaces;

interface GroupRepositoryInterface 
{
    public function getAllGroups();
    public function getGroupById($groupId);
    public function deleteGroup($groupId);
    public function createGroup(array $groupDetails);
    public function updateGroup($groupId, array $newDetails);
    public function attachUser($groupId, $userId);
    public function detachUser($groupId, $userId);
}
