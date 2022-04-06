<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Validator;
class TagController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return $this->sendResponse($tags,'tags fetched');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-tag');
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name',
        ]);
        if($validator->fails()){
            
            return $this->sendError($validator->errors());
        }
        $tag = Tag::create($request->all());

        return $this->sendResponse($tag,'tag created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-tag');
        $tag = Tag::find($id);
        if(is_null($tag)){
            return $this->sendError('tag not found');
        }
        return $this->sendResponse($tag,'tag fetched');
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
        $this->authorize('update-tag');
        $tag = Tag::find($id);
        if(is_null($tag)){
            return $this->sendError('tag not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $tag->update(['name'=>$request->input('name')]);
        return $this->sendResponse($tag,'tag updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-tag');
        $tag = Tag::find($id);
        if(is_null($tag)){
            return $this->sendError('tag not found');
        }
        $tag->delete();
        return $this->sendResponse($tag,"tag deleted");
    }
}
