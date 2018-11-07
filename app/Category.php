<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    
    protected $table = 'categories';

    protected $fillable = ['name'];


    public function Parent()
    {
    	return $this->belongsTo('App\Category', 'parent');
    }

    public function children()
    {
    	return $this->hasMany('App\Category', 'parent');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'category_id');
    }

    public static function getParents()
    {
        $categories = Category::all();

        return $categories;

    }

    public function getUrlAttribute(){
        return '/q?cat='.$this->id;
    }

    public static function getSubcategories($category)
    {
        $subCategories = Category::where('parent', $category);

        return $subCategories->get();
    }

    public static function getCategoryAttr($code)
    {
        $query = DB::table('post_attr')->where('category_id', Category::getIdByCode($code));

        if($query->count() == 0) return false;

        $query = $query->get();

        return $query;
    }

    public static function getIdByCode($code)
    {
        $query = Category::where('code', $code)->select('id');
        if($query->count() == 0)
        {
            return 0;
        }else{
            return $query->first()->id;
        }
    }

    public static function getAttrLength($code)
    {
        $query = DB::table('post_attr')
            ->where('category_id', Category::getIdByCode($code))
            ->where('answer_type', 'Text')
            ->select('length', 'id');

        if($query->count() == 0) return false;

        foreach($query->get() as $field)
        {
            $data[$field->id]   = 'max:'.intval($field->length);
        }

        return $data;
    }


}