<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface; //our User repository interface
use Illuminate\Http\JsonResponse; //to return json response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator; //for data validation
use Illuminate\Validation\Rule; // to make rules like avoiding unique for update 

class UserController extends Controller
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse 
    {
        return response()->json([
            'data' => $this->userRepository->getAllUsers()
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
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email'     => 'required|string|email|max:255|unique:users',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }

        if (count($request->groups)<1) {
            return response()->json(array(
                'error'   =>  "A user must belong to atleast one group"
            ));
        }
        //validate data end

        $userDetails = $request->only([
            'first_name', 'last_name', 'description', 'email' 
        ]);

        return response()->json(
            [
                'data' => $this->userRepository->createUser($userDetails, $request->groups)
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request): JsonResponse 
    {
        $userId = $request->route('id');

        return response()->json([
            'data' => $this->userRepository->getUserById($userId)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request): JsonResponse 
    {
        $userId = $request->route('id');

        //validate data start
        $validation = Validator::make(
            $request->all(),
            [
                
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email'     => 'required|string|email|max:255|'.Rule::unique('users')->ignore($userId),
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        //validate data end

        $userDetails = $request->only([
            'first_name', 'last_name', 'description', 'email' 
        ]);

        return response()->json([
            'data' => $this->userRepository->updateUser($userId, $userDetails)
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): JsonResponse 
    {
        $userId = $request->route('id');
        $this->userRepository->deleteUser($userId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    public function syncGroups(Request $request): JsonResponse 
    {
        $userId = $request->route('id');

        //validate groups / a user must belong to atleast one group
        if (count($request->groups)<1) {
            return response()->json(array(
                'error'   =>  "A user must belong to atleast one group"
            ));
        }

        return response()->json([
            'data' => $this->userRepository->syncGroups($userId, $request->groups)
        ]);
    }

    //get list of users with filters and sorting
    public function userFilters(Request $request): JsonResponse 
    {
        $fliters = $request->only('filters');

        return response()->json([
            'data' => $this->userRepository->userFilters($fliters)
        ]);
    }




}
