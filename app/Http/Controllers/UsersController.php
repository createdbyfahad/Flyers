<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;
use Hash;
use Redirect;
use File;
use Illuminate\Http\UploadedFile;
use Image;
use App\Post;
use App\Offer;
use Carbon\Carbon;
use DB;

class UsersController extends Controller
{

    public function preferences()
    {

        $user = Auth::user();

        return view('form.user_preferences', compact('user'));
    }

    private function handleProfilePic(UploadedFile $file, $user_id)
    {
        //process the image, and return info to add to the profile database
        $path = sprintf('profiles/pp%s-%s.%s', rand(0,100), $user_id, "jpg");
        $photo = Image::make($file)->fit(50, 50)->save($path, 85);
        return $path;

    }

    public function preferencesProcess(Request $request)
    {
//        $request->validate([
//            'password' => 'bail|required|string|min:6|confirmed',
//            'name' => 'required|string|max:255',
//            'email' => 'string|email|max:255|unique:users',
//            'phone' => 'required|min:10|max:14|unique:users',
//        ]);

        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = User::find(Auth::id());

        if(! Hash::check($request->password, $user->password)){
            return Redirect::back();
        }
        $request->validate([
            'publicNameRadio'    => 'required',
            'profilePic'        => 'nullable|image|max:1500',
        ]);

        if($request->publicNameRadio == "1"){
            $request->validate(['nicknameVal' => 'required|min:3|max:13']);
            $user->nickname = $request->nicknameVal;
        }

        $user->public_name = $request->publicNameRadio;

        if(isset($request->profilePic) && $request->profilePicDisable == null){
            $profile_pic_path = $this->handleProfilePic($request->file('profilePic'), $user->id);
            $user->pic_path = $profile_pic_path;
        }

        if($request->profilePicDisable == 'on'){
            // delete the profile pic
            $user->pic_path = null;
        }

        $user->save();

        return redirect()->route('userPreferences');
    }

    public function myOffers(Request $request)
    {
        $posts = Post::createdBy(Auth::id());

        return view('form.user_my_offers', compact('posts'));
    }

    public function inMessages()
    {
        // used for the menu
        $offers = Offer::offersTo(Auth::id())->byNewMessage()->get();
        $other['in'] = true;
        $other['current'] = null;

        return view('user_in_messages', compact('offers', 'other'));
    }

    public function inMessagesDialog($offer_id)
    {
        $offer = Offer::findOrFail($offer_id);
        if($offer->offeree_id != Auth::id()) redirect('/');

        // used for the menu
        $offers = Offer::offersTo(Auth::id())->byNewMessage()->get();
        $other['in'] = true;
        $other['current'] = $offer_id;

        // get the messages, and post info
        $messages = $offer->messages;

        Carbon::setLocale('ar');

        return view('user_in_messages', compact('offers', 'other', 'offer', 'messages'));
    }

    public function inMessagesPost($offer_id, Request $request)
    {
        $offer = Offer::findOrFail($offer_id);
        if($offer->offeree_id != Auth::id()) redirect('/');

        $this->validate($request, [
            'userMessage'   => 'required|max:64'
        ]);

        // consider removing the receiver_id from the messages schema
        if(Offer::postMessage($offer_id, Auth::id(), $offer->offeree_id, $request->userMessage))
        {
            return redirect()->route('userInMessagesDialog', $offer_id);
        }
    }


}
