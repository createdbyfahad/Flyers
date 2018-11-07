<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Offer extends Model
{
    //

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function offered()
    {
        return $this->belongsTo('App\User', 'offered_id');
    }

    public function offeree()
    {
        return $this->belongsTo('App\User', 'offeree_id');
    }

    public static function store($offer_data)
    {
        $offer = new static;
        $offer->offeree_id = $offer_data['offeree_id'];
        $offer->offered_id = $offer_data['offered_id'];
        $offer->post_id = $offer_data['post_id'];
        $offer->amount = $offer_data['price'];
        $offer->message = $offer_data['message'];

        return $offer->save();
    }

    public function scopeOffersTo($query, $user_id){
        return $query->where('offered_id', $user_id);
    }

    public function scopeByNewMessage($query){
        return $query->orderBy('new_message', 'desc');
    }

    public function getMessagesAttribute()
    {
        return DB::table('messages')->where('offer_id', $this->id)->get();;
    }

    public static function postMessage($offer_id, $sender_id, $receiver_id, $message)
    {
        $query = DB::table('messages')->insert(
            ['offer_id' => $offer_id, 'sender_id' => $sender_id,
            'receiver_id' => $receiver_id, 'message' => $message]
        );
        if($query) return true;
    }
}
