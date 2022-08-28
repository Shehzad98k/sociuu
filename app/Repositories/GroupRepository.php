<?php

namespace App\Repositories;

use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;

class GroupRepository implements GroupRepositoryInterface 
{
    //get all groups
    public function getAllGroups() 
    {
        return Group::with('users')->get();
    }

    //get specific group
    public function getGroupById($groupId) 
    {
        return Group::with('users')->findOrFail($groupId);
    }

    //delete group
    public function deleteGroup($groupId) 
    {
        return Group::destroy($groupId);
    }

    //create group
    public function createGroup(array $groupDetails) 
    {
        return Group::create($groupDetails);
    }

    //update group
    public function updateGroup($groupId, array $newDetails) 
    {
        return Group::whereId($groupId)->update($newDetails);
    }

    //assign group to a user
    public function attachUser($groupId, $userId) 
    {
        $group = Group::with('users')->find($groupId);
        if(!$group->users->contains($userId)){
            $group->users()->attach($userId); 
        }
        //get group again to also get updated users relation
        $group = Group::with('users')->find($groupId);
        return $group;
    }

    //remove group to a user
    public function detachUser($groupId, $userId) 
    {
        $group = Group::find($groupId);
        if($group->users->contains($userId)){
            $group->users()->detach($userId);
        }
        //get group again to also get updated users relation
        $group = Group::with('users')->find($groupId);
        return $group;
    }

}
