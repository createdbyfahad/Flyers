<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Post;
use App\Photo;
use Carbon\Carbon;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Faker;
use App\Search;

class PagesController extends Controller
{
    
    public function index()
    {
    	//Bring lists

    	$data['categories'] = Category::getParents();

    	$data['lastPosts'] = Post::mainViews(); // only with photos

//    	$data['lastPostsCats'][0] = Post::lastPostsThumbnails(7, 5);
//    	$data['lastPostsCats'][0]->headTitle = trans('word.strongestAdsIn').' <a href="'.categoryURL($data['lastPostsCats'][0]->categoryCode).'">'.$data['lastPostsCats'][0]->categoryName.'</a> <small>'.trans('word.duringLastHour').'</small>';
//    	$data['lastPostsCats'][1] = Post::lastPostsThumbnails(11, 5);
//    	$data['lastPostsCats'][1]->headTitle = trans('word.strongestAdsIn').' <a href="'.categoryURL($data['lastPostsCats'][1]->categoryCode).'">'.$data['lastPostsCats'][1]->categoryName.'</a> <small>'.trans('word.duringLastHour').'</small>';
    	
    	//dd($data['lastPostsCat']);
    	Carbon::setLocale('ar');

    	return view('index', $data);
    }

    public function search()
    {
        
        // if(! \Input::get('q')){
        //     \Flash::error('fasdfs');
        //     return \Redirect::home();
        // }

        // $search = Post::search(\Input::get('q'));
        $search = Search::searchEngine();

        return view('search', compact('search'));

    }

    public function command()
    {
        $reader = Reader::createFromPath(public_path().'\csv\lexus.csv');
        $data = $reader->fetchAssoc(['title', 'body']);

        $faker = Faker\Factory::create('ar_JO');

        foreach ($data as $k => $row) {
            if($k < 2) continue;
            if($row['title'] && $row['body'])
            {
                $post = new Post;
                $post->user_id = rand(1,2);
                $post->status = 0;
                $post->category_id = rand(6,25);
                $post->price = rand(0,8) * 32;
                $post->title = preg_replace('/\s+/', ' ', substr($row['title'], 5)); //Delete beggining and extra spaces
                $post->body = $row['body'];
                $districts = [0,3,4,6];
                $post->district_id = $districts[array_rand($districts)];

                $finish = $post->save();
                if($finish)
                {
                    $post->confirm();
                }
            }
        }
        echo 'success!';
    }


}
