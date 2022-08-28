<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeEmailNotification;

class UserRepository implements UserRepositoryInterface 
{
    //get all Users
    public function getAllUsers() 
    {
        return User::with('groups')->sortable()->paginate(5);
    }

    //get specific User
    public function getUserById($userId) 
    {
        return User::with('groups')->findOrFail($userId);
    }

    //delete User
    public function deleteUser($userId) 
    {
        return User::destroy($userId);
    }

    //create User
    public function createUser(array $userDetails, array $groups) 
    {
        $user = User::create($userDetails);
        $user->groups()->attach($groups);  
        
        //email notification
        $listOfGroups = 'The Groups you are a part of are ';
        foreach($user->groups() as $group){
            $listOfGroups .= $group.' ';
        }

        Notification::send($user, new WelcomeEmailNotification($listOfGroups    ));

        return $user;
    }

    //update User
    public function updateUser($userId, array $newDetails) 
    {
        return User::whereId($userId)->update($newDetails);
    }

    //mass assign / assign or remove User from groups
    public function syncGroups($userId, array $groups) 
    {
        $user = User::find($userId);
        $user->groups()->sync($groups); 
        return $user;
    }

    //get list of users with filters and sorting
    public function userFilters($filters){
     
        $users = User::with('groups'); 
        //filters
        foreach($filters['filters'] as $filter){
            foreach($filter as $fil=>$val){
                $users->where($fil, $val);
            }
        }
        return $users->sortable()->paginate(5);
    }

    

}
