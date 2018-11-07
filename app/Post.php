<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Events\APostWasActivated;
use App\Search;

class Post extends Model
{

    protected $fillable = ['title', 'body', 'user_id', 'primary_photo_id'];

    protected $dates = ['created_at', 'updated_at', 'repost_at'];

    public function photos()
    {
    	return $this->hasMany('App\Photo', 'post_id');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'district_id');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer', 'post_id');
    }

    public function setTitleAttribute($value)
    {
    	$slug = str_replace(' ', '-', $value);
    	$this->attributes['title'] = $value;
    	$this->attributes['slug'] = $slug;
    }

    public function scopeActive($query)
    {
        $query->where('posts.status', 1); // should be changed to 2
        // $query->where('posts.status', 2); 
    }

    public function scopeNewest($query)
    {
        $query->orderBy('posts.created_at', 'desc');
    }

    public static function postAttr($id)
    {
    	$query = DB::table('post_attr_value')
    				->where('post_id', $id)
    				->join('post_attr', 'post_attr_value.attr_id', '=', 'post_attr.id')
    				->select('post_attr.answer_type', 'post_attr.name', 'post_attr.options', 'post_attr.length', 'post_attr_value.attr_id', 'post_attr_value.value')
    				->get();

    	if(count($query) > 0)
    	{
    		foreach ($query as $attr) {
    			if($attr->answer_type == 'Dropdown' || $attr->answer_type == 'Checkbox')
    			{
	    			$attr->options = explode(',', $attr->options);
	    			if($attr->answer_type == 'Dropdown'){
	    				$attr->value = $attr->options[$attr->value];
	    				$attr->options = null;
	    			} 
	    			if( $attr->answer_type == 'Checkbox')
	    			{
	    				$values = explode(',', $attr->value);
	    				$attr->value = array();
	    				foreach ($values as $value) {
	    					array_push($attr->value, $attr->options[$value]);
	    				}
	    				$attr->options = null;
	    			}
	    		}

    		}
    		return $query;
    	}else{
    		return false;
    	}

    }

    public static function getPostAndAttr($id)
    {
    	$post = Post::findOrFail($id);
    	$attr = Post::postAttr($id);
    	$post->attr = $attr;

    	return $post;
    }

    public function confirm($primary_id)
    {
        $primary = Photo::findOrFail($primary_id);
        $post = Post::findOrFail($this->id);
        $post->status = 1;
        $post->primary_photo_id = $primary->id;
        $post->thumbnail_height = $primary->thumbnail_height;
        $post->primary_photo_path = $primary->thumbnail_path;
        $confirm = $post->save();

        //if($confirm) \Event::fire(new APostWasActivated($post));

        return $confirm;
    }

    public static function mainViews()
    {
        $post = Post::active()->newest()
                    ->select('id', 'user_id', 'title', 'slug', 'price', 'created_at', 'primary_photo_id', 'primary_photo_path', 'thumbnail_height', 'district_id')
            ->where("primary_photo_id", "!=", "NULL")->get();

        return $post;
    }

    public function getUrlAttribute()
    {
        //return '/'.$post->id.'/'.$post->slug;
        return '/p/'.$this->id;
    }

    public function hasPhoto()
    {
        return $this->photos()->exists();
    }

    public function makePrimaryPhoto($photo_id = null)
    {
        if($photo_id != null) {
            $photo = Photo::findOrFail($photo_id);
            return $photo->makePrimary();
        }elseif(!$this->primary_photo_id){
            // check if it has any photos
            // choose the first photo and make it primary
            $photo = $this->photos()->first();
            return $photo->makePrimary();
        }

        return true;
    }

    //for url correction
    public static function URLredirect($id)
    {
        $post = (new static)->select('id', 'slug')->findOrFail($id);

        return redirect($post->id.'/'.$post->slug);
    }

    public function thumbnailInfo()
    {
        $photo = $this->photos()->get();
        return $photo;
        //return "<img src='".$photo->thumbnail_path."' />";
    }

//    public static function lastPostsThumbnails($catId, $count = 5)
//    {
//        $category = Category::find($catId);
//        //return $category->posts()->newest()->take($count)->join('photo', '->select('title', 'price')->get();
//        $query = $category->posts()
//                ->join('photos', 'photos.post_id', '=', 'posts.id')
//                ->active()->newest()->where('photos.primary', 1)
//                ->select('posts.id', 'posts.title', 'posts.price', 'posts.slug', 'posts.created_at', 'photos.thumbnail_path')->get();
//        $query->categoryName = $category->name;
//        $query->categoryCode = $category->code;
//        return $query;
//    }

    public function primaryPhoto($photo)
    {

        return Photo::findOrFail($photo)->thumbnail_path;

    }

    public function changePrimaryPhoto(Photo $photo)
    {
        $this->primary_photo_id = $photo->id;
        $this->thumbnail_height = $photo->thumbnail_height;
        $this->primary_photo_path = $photo->thumbnail_path;
        return $this->save();
    }

    public function getBPriceAttribute()
    {
        $value = $this->price;
        if($value === NULL){
            return NULL;
        }else if($value == 0){
            return trans('word.free');
        }else{
            return $value.' '.trans('word.riyal');
        }
    }

    public function getWearDescriptionAttribute()
    {
        $wear = trans('post.wear_'.$this->wear);
        $wear_desc = trans('post.wear_'.$this->wear.'_desc');
        return sprintf("<b>%s:</b> %s", $wear, $wear_desc);
    }

    public static function createdBy($user_id)
    {
        $posts = Post::where('user_id', $user_id);

        return $posts->get();
    }

    public static function emptyPost($user_id)
    {

        // if the user has already empty post, then return it
        $post = Post::where("status", 0)->where('user_id', $user_id)->first();
        if(!$post){
            // user has posts under creation, so create a new one
            $post = new Post;
            $post->user_id = $user_id;
            $post->status = 0; // means post is null and has no photos
            $post->category_id = 0;
            $post->save();
        }

        return $post;
    }

}
