<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Users Controller
    |--------------------------------------------------------------------------
    */

    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
 
        $email = $request->get('email');
        $password = Hash::make($request->get('password'));
        $user = User::create([
            'email' => $email,
            'password' => $password,
            'name' => $request->get('name')
        ]);
        
        event(new Registered($user));

        return response()->json(['user' => $user]);
    }
    /**
     * Show all the users
     *
     * @return JSON
     */
    public function index()
    {
        $users = User::paginate(15);

        return response()->json(['users' => $users]);
    }

    /**
     * Display the specified user.
     *
     * @param App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user){
            return response()->json(['user' => $user]);
        }

        return response()->json([
            'error' => 'User Not Found'
        ], 404);
    }

    /**
     * Store a newly user in database.
     *
     * @param App\Http\Requests\UserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->active = true;
        $user->save();

        return response()->json(['user' => $user]);
    }

    /**
     * Update the user
     *
     * @param App\Models\User $user
     * @param App\Http\Requests\UserUpdateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'sometimes|string',
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($id)],
        ]);

        $user = User::find($id);
        if($user){
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->save();

            return response()->json(['user' => $user]);
        }
        return response()->json([
            'error' => 'User Not Found'
        ], 404);
    }

    /**
     * Update the user's profile image
     *
     * @param App\Models\User $user
     * @param App\Http\Requests\UserAvatarRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateUserAvatar($id, Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|mimes:jpeg,jpg,png'
        ]);

        $user = User::find($id);
        
        if($user){
            $imagePath = $request->avatar->store('images/users');
            $user->avatar = basename($imagePath);
            $user->save();
            return response()->json(['user' => $user]);
        }
        return response()->json([
            'error' => 'User Not Found'
        ], 404);
    }

    public function delete($id){
        
        $user = User::find($id);

        if($user && $user->delete()){
            return response()->json(['message' => 'User Deleted successfully']);
        }

        return response()->json([
            'error' => 'User Not Found'
        ], 404);
    }
}