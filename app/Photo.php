<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Facades\Image;
use DB;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = ['post_id', 'photo', 'photo_name', 'thumbnail_height'];

    protected $tn_width = 200;

    protected $width_heigth = 960;

    protected $baseDir = 'photos';

    public function post()
    {
    	return $this->belongsTo('App\Post', 'post_id');
    }

    public static function fromForm(UploadedFile $file, $post_id)
    {
    	$photo = new static;

        $photo->saveAs($post_id, $file->getClientOriginalExtension())
            ->makePhoto($file);

        $photo->makeThumbnail();

    	return $photo;
    }

    protected function saveAs($post_id, $mime)
    {
//        $this->photo_name = sprintf('%s-%s', time(), str_replace(' ', '_', $name));
        $this->photo_name = sprintf('%s-%s.%s', time() + rand(0,100), $post_id, "jpg");
        $this->photo_path = sprintf('%s/%s', $this->baseDir, $this->photo_name);
        $this->thumbnail_path = sprintf('%s/tn-%s', $this->baseDir, $this->photo_name);

        return $this;
    }

    public function makePhoto(UploadedFile $file)
    {
        //$file->move($this->baseDir, $this->photo_name);
        // resize and optimize the photo

        $image = Image::make($file)->orientate();
        if($image->height() > $image->width()){
            $image->heighten($this->width_heigth);
        }else{
            $image->widen($this->width_heigth);
        }

        // orientate and optimize
        // save as jpg of quality 75%
        $image->save($this->photo_path, 75);

        // need to optimize using already installed saptire library with jpegoptim, it need to be downloaded and installed
    }

    public function makeThumbnail()
    {
        $image = Image::make($this->photo_path)
                ->widen($this->tn_width, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($this->thumbnail_path);

        $this->thumbnail_height = $image->height();
    }

    public function scopePrimary($query)
    {
        $query->where('primary', 1);
    }

    public function makePrimary()
    {
        $post = Post::find($this->post_id);
        // update all photos of this post
        Photo::where('post_id', $this->post_id)
            ->update(['primary' => 0]);
        $this->primary = 1;
        $this->save();
        return $post->changePrimaryPhoto($this);
    }
}
