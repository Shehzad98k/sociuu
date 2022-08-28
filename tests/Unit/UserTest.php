<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

     //save user in db test
    public function testStoreUsers()
    {
        $response = $this->post('api/users', [
            "first_name" => "John",
            "last_name" => "Doe",
            "email" => "john@gmail.com",
            "groups" => [1,2]
        ]);
        $response->assertStatus(200);
    }

    //get list of users test
    public function testUsersList()
    {
        $response = $this->get('api/users');
        $response->assertStatus(200);
    }

    //get single user test
    public function testSingleUsers()
    {
        $response = $this->get('api/users/1');
        $response->assertStatus(200);
    }

    
    //update user test
    public function testUpdateUsers()
    {
        $response = $this->put('api/users/1', [
            "first_name" => "Michael",
            "last_name" => "Jordan",
            "email" => "Jordan@gmail.com",
            "groups" => [1,2]
        ]);
        $response->assertStatus(200);
    }

    
    //assign or remove groups from user test
    public function testMassAssignGroups()
    {
        $response = $this->put('api/users/groups/1', [
            "groups" => [1,2]
        ]);
        $response->assertStatus(200);
    }
}
