<?php

use App\Category;

function getPostAttributes($catCode , $class = null)
{
	$query = DB::table('post_attr')->where('category_id', Category::getIdByCode($catCode));
	// if there are no data return false
	if($query->count() == 0) return false;
	$data = null;
	$query = $query->get();
	
	foreach($query as $field)
	{
		//first decide what kind of field it is
		switch($field->answer_type){
			case 'Dropdown':
				$options = explode(',', $field->options);
				$top = "<select name='".$field->id."' class='form-control ".$class."'>";
				$top = $top."<option value=''></option>";
				$center = null;
				foreach($options as $key => $option)
				{
					$center = $center."<option value='".$key."'>".$option."</option>"; 
				}
				$bottom = "</select>";

				$data[$field->name] = $top . $center . $bottom;
				break;
			case 'Checkbox':

				$options = explode(',', $field->options);
				$center = null;
				
				foreach($options as $key => $option)
				{
					$center = $center."<div class='checkbox'><label><input type='checkbox' name='".$field->id."[]' value='".$key."'>".$option."</label></div>";
				}

				if(! is_null($class)) $center = "<div class='".$class."'>".$center."</div>";

				$data[$field->name] = $center;
				break;

			case 'Text':
				$text = "<div class='form-group ".$class."'><input type='text' name='".$field->id."' maxlength='".$field->length."' class='form-control' /></div>";
				$data[$field->name] = $text;
				break;
		}

	}
	
	return $data;
}

function savePostAttrValues($data)
{
	$query = DB::table('post_attr_value')->insert($data);

	if($query) return true;

	return false;
}

function categoryURL($code)
{
	return '/search?c='.$code;
}

function postURL($id=null, $slug=null)
{
	return '/'.$id.'/'.$slug;
}

function oldOrPost($post_var, $var)
{
    if(old($var)) return old($var);
    if($post_var != NULL) return $post_var;
}