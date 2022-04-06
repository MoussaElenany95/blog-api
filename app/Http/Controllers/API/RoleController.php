<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use App\Models\User;
class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-role');
        $roles = Role::with('permissions')->get();
        return $this->sendResponse($roles,'roles fetched');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-role');
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions'=>'required|array'
        ]);
        if($validator->fails()){
            
            return $this->sendError($validator->errors());
        }
        $role = Role::create(['name'=>$request->input('name')]);
        $permissions = $request->input('permissions');
        $role->permissions()->sync($permissions);
        return $this->sendResponse($role,'role created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-role');
        $role = Role::find($id);
        if(is_null($role)){
            return $this->sendError('Role not found');
        }
        return $this->sendResponse($role->with('permissions')->get(),'role fetched');

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
        $this->authorize('update-role');
        $role = Role::find($id);
        if(is_null($role)){
            return $this->sendError('Role not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id,
            'permissions'=>'required|array'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $role->update(['name'=>$request->input('name')]);
        $permissions = $request->input('permissions');
        $role->permissions()->sync($permissions);
        return $this->sendResponse($role,'role updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-role');
        $role = Role::find($id);
        if(is_null($role)){
            return $this->sendError('Role not found');
        }
        $role->delete();
        return $this->sendResponse($role,"role deleted");
    }
    public function assignRole(Request $request,$id){
        $this->authorize('assign-role');
        $user = User::find($id);
        if(is_null($user)){
            return $this->sendError('User not found');
        }
        $validator = Validator::make($request->all(), [
            'role_id'=>'required|exists:roles,id'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $user->update( ['role_id' => $request->input('role_id')]);
        return $this->sendResponse($user,"role assigned");
    }
}
