<?php

namespace App\Http\Controllers;

use App\Events\PostWasActivated;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use Input;
use App\Post;
use App\Photo;
use Flash;
use Auth;
use App\District;
use Carbon\Carbon;
use App\Search;
use Image;
use App\Providers\PolylineEncoder;
use File;
use App\Offer;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //Check if the user is signed in
        $this->middleware('auth', ['only' => ['create', 'store', 'addPhoto', 'firstStep']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        // first create an empty post
        // and show the upload photos pages passed with post id
        $post = Post::emptyPost(Auth::id());


        // if the post is active, return to confirm post and request user to
        // disable the post
//        if($post->status == 1){
//            flash('need to disable the post first')->error();
//            return redirect()->route('confirmPost', $post_id);
//        }
        //check if the post is owned bt the signed user and status = 0
        // request has already gone through middleware
        // check if status == 0
        $post->owner = 1;
//        $progress_bar = ($post->status == 1)? 3 : 2;
        $progress_bar = 1;
        return view('addPhoto', compact('post', 'progress_bar'));

//        $categories = Category::getParents();
//        $districts = District::getParents();
//        $progress_bar = 1;
//        return view('form.new_post', compact('categories', 'districts', 'progress_bar'));
//        if (! $cat_id) return redirect()->route('createPost');
//        // check if the code is existed in the database or not
//        if (! Category::find($cat_id)->exists()) return redirect()->route('createPost');
//        if (! $request->is('p/add/'.$request->cat)) return redirect()->route('createPost');
//
//        if(empty($request->input('lat')))
//        {
//            $lat = null;
//        }else{ $lat = $request->lat; }
//
//        if(empty($request->input('lng')))
//        {
//            $lng = null;
//        }else{ $lng = $request->lng; }
//
//        $data['attr'] = getPostAttributes($code, 'col-md-8');
//
//        //the name of the category
//        $category = Category::where('code', $code)->select('name', 'parent')->get()->first();
//        $data['category_child'] = $category->parent()->select('name')->get()->first()->name;
//        $data['category'] = $category->name;
//        $data['category_code']  = $code;
//
//        $request->session()->put('latlng', [$lat, $lng]);
//        $request->session()->put('district', $request->district);
//
//        return view('form.addPost', $data);
    }

    public function addInfo($post_id)
    {
        // first create an empty post
        // and show the upload photos pages passed with post id
        $post = Post::findOrFail($post_id);


        // if the post is active, return to confirm post and request user to
        // disable the post
//        if($post->status == 1){
//            flash('need to disable the post first')->error();
//            return redirect()->route('confirmPost', $post_id);
//        }
        //check if the post is owned bt the signed user and status = 0
        // request has already gone through middleware
        // check if status == 0
        $categories = Category::getParents();
        $districts = District::getParents();
        $progress_bar = 2;
        return view('form.new_post', compact('categories', 'districts', 'progress_bar', 'post'));
    }


    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        $post->owner = 1;
//        $progress_bar = ($post->status == 1)? 3 : 2;
        $progress_bar = 1;
        return view('addPhoto', compact('post', 'progress_bar'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($post_id, Request $request)
    {
        $this->validate($request, [
                'category'  => 'required|numeric',
                'title'     => 'required|min:5|max:255',
                'price'     => 'numeric',
                'description'      => 'required|min:10',
                'wear'    => 'required',
                'location'  => 'numeric|required',
            ]);

        $lat = $request->lat;
        $lng = $request->lng;

        if($lat == null || $lng == null){
            // what to do when no map location is provided
        }

        $post = Post::findOrFail($post_id);
        $post->status = 2;
        $post->title  = $request->title;
        $post->body   = $request->description;
        $post->category_id = $request->category;
        $post->wear = $request->wear;
        if ($request->postPriceCheck == 'on' || !$request->price){
            $post->price = 0;
        }else{
            $post->price = $request->price;
        }
        $post->district_id = $request->location;
//        if(!is_null($latlng)){
//            $post->lat = $latlng[0];
//            $post->lng = $latlng[1];
//        }
        $post->lat = $lat;
        $post->lng = $lng;

        if($post->save())
        {
//            $attr = Category::getCategoryAttr($code);
//            if($attr)
//            {
//                foreach ($attr as $field) {
//                    $value = Input::get($field->id);
//
//                    if ($value === 0 || !empty($value))
//                    {
//                        $data['attr_id'] = $field->id;
//                        $data['post_id'] = $post->id;
//                        if(is_array($value))
//                        {
//                            //this is a checkbox
//                            $data['value'] = implode(',', $value);
//
//                        }else{
//                            $data['value'] = $value;
//                        }
//                        savePostAttrValues($data);
//                    }
//                }
//            }
            Flash::success(trans('action.postSucceded'));
            return redirect()->route('showPost', [$post->id]);
        }
    }

    //Step 1- chosoe category and location
    public function firstStep()
    {
        $categories = Category::getParents();
        $districts = District::getParents();
        return view('form.chooseCategory', compact('categories', 'districts'));
    }
    //Step 2- add photos

    public function addPhoto($post_id)
    {
        $post = Post::find($post_id);

        //check if the post is owned bt the signed user and status = 0
        // request has already gone through middleware
        // check if status == 0
        $post->owner = 1;
        $progress_bar = ($post->status == 1)? 3 : 2;
        $post->edit = 1;
        return view('addPhoto', compact('post', 'progress_bar'));

    }

    public function deletePhoto($post_id, $photo_id)
    {
        $post = Post::find($post_id);
        $photo = Photo::findOrFail($photo_id);
        if($photo->post_id != $post_id) return redirect()->route('home');
        if($post->primary_photo_id == $photo->id){
            // update the post with null values
            $post->primary_photo_id = null;
            $post->thumbnail_height = null;
            $post->primary_photo_path = null;
            $post->save();
        }
        File::delete($photo->photo_path);
        File::delete($photo->thumbnail_path);

        // destroy the record
        $photo->delete();

        return back();
    }


    public function primaryPhoto($post_id, Request $request){

        $post = Post::findOrFail($post_id);

        // check if the photo has any photos or not
        if(!$post->hasPhoto()){
            flash("need to add at least one photo")->warning();
            return back();
        }

        if($post->makePrimaryPhoto($request->primary_photo_id)) return redirect()->route('addInfo', $post->id);

    }

    public function confirm($post_id, Request $request)
    {
        // show a preview of the post and confirm
        $post = Post::findOrFail($post_id);
        $progress_bar = 3;
        $post->owner_path = '#';
        return view('ownerPostView', compact('post', 'progress_bar'));
//        // check if this post has photos then confirm it (activate)
//        if($post->hasPhoto()){
//            if($request->primaryPhoto){
//                $post->confirm($request->primaryPhoto);
//            }else{
//                // get random photo and confirm
//                $query= DB::table('photos')
//                    ->where('post_id', $post)
//                    ->take(1);
//                $post->confirm($query);
//            }
//        } // no photo so don't activate
//
//        //$post->confirm(Photo::makePrimary($post->id, $request->primaryPhoto));
//
//        return redirect('/');
    }


    // activate and disable the post
    public function activate($post_id){
        $post = Post::findOrFail($post_id);

        $post->status = 1;

        event(new PostWasActivated($post));

        if($post->save()) return redirect()->route('confirmPost', $post_id);
    }

    public function disable($post_id)
    {
        $post = Post::findOrFail($post_id);

        $post->status = 0;

        if ($post->save()) return redirect()->route('confirmPost', $post_id);
    }

    private function GMapCircle($Lat,$Lng,$Rad,$Detail=8){
        $R    = 6371;
        $pi   = pi();
        $Lat  = ($Lat * $pi) / 180;
        $Lng  = ($Lng * $pi) / 180;
        $d    = $Rad / $R;
        $points = array();
        $i = 0;
        for($i = 0; $i <= 360; $i+=$Detail):
            $brng = $i * $pi / 180;
            $pLat = asin(sin($Lat)*cos($d) + cos($Lat)*sin($d)*cos($brng));
            $pLng = (($Lng + atan2(sin($brng)*sin($d)*cos($Lat), cos($d)-sin($Lat)*sin($pLat))) * 180) / $pi;
            $pLat = ($pLat * 180) /$pi;
            $points[] = array($pLat,$pLng);
        endfor;
        $PolyEnc   = new PolylineEncoder($points);
        $EncString = $PolyEnc->dpEncode();
        return $EncString['Points'];
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($post_id)
    {
        Carbon::setLocale('ar');
        $data['post'] = Post::getPostAndAttr($post_id);
        if($data['post']['lat'] != null && $data['post']['lng'] != null) {
            $EncString = $this->GMapCircle($data['post']['lat'], $data['post']['lng'], 3);
            $MapAPI = 'http://maps.google.com/maps/api/staticmap?';
            $MapURL = $MapAPI . 'center=' . $data['post']['lat'] . ',' . $data['post']['lng'] . '&size=300x300&maptype=roadmap&path=fillcolor:0x173bff33%7Ccolor:0x1d46ff00%7Cenc:' . $EncString . '&sensor=false&zoom=11&key=GOOGLE_API_KEY&scale=2';
            $data['post']['map_url'] = $MapURL;
        }
        if(Auth::check()){
            // user is signed
            if($data['post']['user_id'] == Auth::id()){
                // signed user is the owner
                $data['post']['is_owner'] = route('confirmPost', $data['post']['id']);
            }
        }
        //$data['similar'] = Search::similarPosts($id);
        return view('postView', $data);
    }

    public function change()
    {
        $images = Post::active()
            ->select('id', 'primary_photo_id')->where("primary_photo_id", "!=", "NULL")->get();;
        foreach($images as  $image){
            $photo = Photo::findOrFail($image->primary_photo_id);
            $image->primary_photo_path = $photo->thumbnail_path;
            $image->save();
        }
    }

    public function offer($post_id, Request $request)
    {
        $post = Post::find($post_id);

        // when the user bids on it's offer
        if(Auth::id() == $post->user_id)
        {
            return redirect()->back();
        }

        $offer = ['offeree_id'  => Auth::id(),
            'offered_id'    => $post->user_id,
            'post_id'   => $post_id,
            'price'     => $request->offer_price,
            'message'   => $request->offer_message];

        if(Offer::store($offer))
        {
            flash(trans('post.offer_posted'))->success();
            return redirect()->route('showPost', $post_id);
        }

        return 'true';
    }
}
