<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function parent()
    {
    	$this->belongsTo('District', 'parent');
    }

    public function children()
    {
    	$this->hasMany('District', 'parent');
    }

    public static function getParents()
    {
        $districts = District::where('parent', null);

        return $districts->get();

    }

    public static function getSubdistricts($district)
    {
        $subDistricts = (new static)->where('parent', $district);

        return $subDistricts->get();
    }

}
