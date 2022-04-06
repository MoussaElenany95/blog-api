<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Permission;
use Validator;
class PermissionController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-permission');
        $permssions = Permission::all();
        return $this->sendResponse($permssions,"permissions fetched");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(Request $request)
    {
        $this->authorize('create-permission');
        $validator = Validator::make($request->all(), [
            'permission' => 'required|unique:permissions,name',
        ]);
        
        if($validator->fails()){
           return $this->sendError($validator->errors());
        }

        $permission = Permission::create($request->all());
        return $this->sendResponse($permission,"permission created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-permission');
        $permission = Permission::find($id);
        if(is_null($permission)){
            return $this->sendError("Permission not found");
        }

        return $this->sendResponse($permission,"permission fetched");
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
        $this->authorize('create-permission');
        $permission = Permission::find($id);
        if(is_null($permission)){
            return $this->sendError("Permission not found");
        }

        $validator = Validator::make($request->all(), [
            'permission' => 'required',
        ]);
        
        if($validator->fails()){
           return $this->sendError($validator->errors());
        }
        $permission->update($request->all());

        return $this->sendResponse($permission,"permission updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-permission');
        $permission = Permission::find($id);

        if(is_null($permission)){
            return $this->sendError("Permission not found");
        }
        $permission->delete();

        return $this->sendResponse($permission,"permission deleted");
    }
}
