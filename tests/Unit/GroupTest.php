<?php

namespace Tests\Unit;

use Tests\TestCase;

class GroupTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    

    //save group in db test
    public function testStoreGroups()
    {
        $response = $this->post('api/groups', [
            "name" => "Group A",
        ]);
        $response->assertStatus(200);
    }

    //groups list test
    public function testGroupList()
    {
        $response = $this->get('api/groups');
        $response->assertStatus(200);
    }

    //get single group test
    public function testSingleGroup()
    {
        $response = $this->get('api/groups/1');
        $response->assertStatus(200);
    }
    
    
    //update user test
    public function testUpdateGroups()
    {
        $response = $this->put('api/groups/1', [
            "name" => "Group B",
        ]);
        $response->assertStatus(200);
    }

    
    //attact a group to user test
    public function testAttachUser()
    {
        $response = $this->post('api/groups/attach_user', [
            "userId" => 1,
            "groupId" => 1,
        ]);
        $response->assertStatus(200);
    }
    
    //detact a group to user test
    public function testDetachUser()
    {
        $response = $this->post('api/groups/detach_user', [
            "userId" => 1,
            "groupId" => 1,
        ]);
        $response->assertStatus(200);
    }

}
