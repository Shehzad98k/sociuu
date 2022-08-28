<?php

namespace App\Http\Controllers;

use App\Interfaces\GroupRepositoryInterface; //our group repository interface
use Illuminate\Http\JsonResponse; //to return json response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator; //for data validation
use Illuminate\Validation\Rule; // to make rules like avoiding unique for update 

class GroupController extends Controller
{

    private GroupRepositoryInterface $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository) 
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse 
    {
        return response()->json([
            'data' => $this->groupRepository->getAllGroups()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse 
    {
        //validate data start
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255|unique:groups'
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        //validate data end

        $groupDetails = $request->only([
            'name',
        ]);

        return response()->json(
            [
                'data' => $this->groupRepository->createGroup($groupDetails)
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request): JsonResponse 
    {
        $groupId = $request->route('id');

        return response()->json([
            'data' => $this->groupRepository->getGroupById($groupId)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request): JsonResponse 
    {
        $groupId = $request->route('id');

        //validate data start
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255|'.Rule::unique('groups')->ignore($groupId)
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        //validate data end

        $groupDetails = $request->only([
            'name',
        ]);

        return response()->json([
            'data' => $this->groupRepository->updateGroup($groupId, $groupDetails)
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): JsonResponse 
    {
        $groupId = $request->route('id');
        $this->groupRepository->deleteGroup($groupId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    //attach a group to a user
    public function attachUser(Request $request): JsonResponse 
    {
        //validate data start
        $validation = Validator::make(
            $request->all(),
            [
                'groupId' => 'required|numeric',
                'userId' => 'required|numeric',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        //validate data end

        return response()->json([
            'data' => $this->groupRepository->attachUser($request->groupId, $request->userId)
        ]);
    }

    
    //attach a group to a user
    public function detachUser(Request $request): JsonResponse 
    {
        //validate data start
        $validation = Validator::make(
            $request->all(),
            [
                'groupId' => 'required|numeric',
                'userId' => 'required|numeric',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        //validate data end

        return response()->json([
            'data' => $this->groupRepository->detachUser($request->groupId, $request->userId)
        ]);
    }

}
