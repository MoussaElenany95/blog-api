<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Validator;
use Illuminate\Support\Facades\File; 
class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $article = Article::with('user')->get();
       return  $this->sendResponse($article,"articles");
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
        $this->authorize("create-article");
        //validate inputs
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:10',
            'body' => 'required|min:20',
            'image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status'=>'in:published,unpublished',
            'tags'=>'array',
            'tags.*' =>'exists:tags,id'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $article = new Article;
        $article->title = $request->title;
        $article->body  = $request->body;
        $article->image = $request->image;
        if($request->has('status'))
            $article->status = $request->status;
        
        auth()->user()->articles()->save($article);
        if($request->has('tags'))
            $article->tags()->sync($request->tags);
     
        return $this->sendResponse($article,"Article created");
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        if(is_null($article)){

            return $this->sendError("Article not found");
        }
        $article = $article->with('user')->get();
        return $this->sendResponse($article,"article fetched");

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
        $this->authorize("update-article",$id);
        $article = Article::find($id);
        if(is_null($article)){

            return $this->sendError("Article not found");
        }
        //validate inputs
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:10',
            'body' => 'required|min:20',
            'status'=>'in:published,unpublished',
            'tags'=>'array',
            'tags.*' =>'exists:tags,id'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $article->title = $request->title;
        $article->body  = $request->body;

        //if request has an image t oupdate
        if($request->has('image')){

            $validator = Validator::make($request->all(),[

                'image'=>'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                
            ]);
            if($validator->fails()){
                return $this->sendError($validator->errors());       
            }
            //delete old image
            File::delete($article->image);
            //upload new image 
            $article->image = $request->image;

        }
        // has status attribute
        if($request->has('status'))
            $article->status = $request->status;
        //commit update
        $article->save();

        //has tags
        if($request->has('tags'))
            $article->tags()->sync($request->tags);
        
        return $this->sendResponse($article,"Article updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize("delete-article");
        $article = Article::find($id);
        if(is_null($article)){

            return $this->sendError("Article not found");
        }
        File::delete($article->image);
        $article->delete();
        return $this->sendResponse($article,"article deleted");
    }
}
