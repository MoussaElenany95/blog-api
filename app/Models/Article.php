<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Article extends Model
{
    use HasFactory;
    protected $fillable = ['status','title', 'article_text','image'];
    // article's user
    public function user(){
        return $this->belongsTo(User::class)->select(['name','id']);
    }
    // article's tags
    public function tags(){
        return $this->belongsToMany(Tag::class,'article_tags');
    }
    //upload image 
    public function setImageAttribute($value){
        $imageName = time().'.'.$value->extension();
        $value->move(public_path('images'), $imageName);
        $this->attributes['image'] = $imageName; 
    }
    //get image attribute
    public function getImageAttribute($value){
       return public_path('images').'\\'.$value;
    }
}
