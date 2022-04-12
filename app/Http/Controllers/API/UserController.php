<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
 
 
    //user login
    public function signin(Request $request)
    {
        /*if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->sendResponse($success, 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
        */
        $client = Client::where('email', $request->email)->first();

        if ( !$client || ! Hash::check($request->password, $client->password)){ 
            
            return $this->sendError('Unauthorised.',401);  
         } 
        $success['token'] =  $client->createToken('token')->plainTextToken; 
        $success['name'] =  $client->fname.' '.$client->lname;
        return $this->sendResponse($success, 'client signed in');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create-user");
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User created successfully.');
    }
    public function index(Request $request){
        $users = User::all();
        return $this->sendResponse($users,"users fetched");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return $this->sendError("User not found");
        }
        return $this->sendResponse($user,"user fetched");
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize("update-user",$id);
        $user = User::find($id);
        if(is_null($user)){
            return $this->sendError("user not found");
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return $this->sendError("validation error",$validator->errors());
        }
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->save();

        return $this->sendResponse($user,"user updated");

    }
    public function logout(Request $request)
    {    
        auth()->user()->currentAccessToken()->delete();
        return $this->sendResponse([],"user loged out");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize("delete-user");
        $user = User::find($id);
        if(is_null($user)){
            return $this->sendError("user not found");
        }
        $user->delete();
        return $this->sendResponse([],"User has been deleted");
        //
    }
}
