<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Photo;
use App\Post;
use App\District;
use Auth;

class AjaxController extends Controller
{
    
    public function subCategory(Request $request)
    {
    	if(! $request->input('cat_id')) return False;

    	$category = intval($request->input('cat_id'));

    	$subcategories = Category::getSubcategories($category);

    	return \Response::json($subcategories);
    }

    public function subDistrict(Request $request)
    {
        if(! $request->input('parent')) return False;

        $district = intval($request->input('parent'));

        $subDistricts = District::getSubdistricts($district);

        return \Response::json($subDistricts);
    }

    public function uploadPhoto(Request $request, $post_id)
    {
    	$this->validate($request, [
    		'photo' =>'required|mimes:jpg,jpeg,png,bmp|max:3277',
    		]);

    	$photo = Photo::fromForm($request->file('photo'), $post_id);

    	if (Post::findOrFail($post_id)->photos()->save($photo)) return response()->json(['success' => 'success'], 200);;
    }

    public function activatePost(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
//        if($post->user_id != Auth::id()) return response()->json(['error' => 'invalid user'], 401);
        $post->status = 1;
        if($post->save()) return response()->json(['success' => 'success'], 200);

    }
    public function disablePost(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
//        if($post->user_id != Auth::id()) return response()->json(['error' => 'invalid user'], 401);
        $post->status = 0;
        if($post->save()) return response()->json(['success' => 'success'], 200);
    }

    
}
