<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    // public function index() {
    //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function register(UserRegisterRequest $request): JsonResponse {
        $data = $request->validated();


        if (User::where('username', $data['username'])->count() >= 1) {
            throw new HttpResponseException(response([
                'errors' => 'Username Already Registered'
            ], 400));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function get(Request $request): UserResource {
        $user = Auth::user();
        return new UserResource($user);
    }

    /**
     * Login function
     */
    public function login(UserLoginRequest $request): UserResource {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => 'Wrong username or password!'
                ]
            ], 401));
        }


        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request): UserResource {
        $data = $request->validated();

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request): Response {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response(null, 204);
    }
}
