<?php

namespace App\Http\Middleware;

use Closure;
use App\Post;
use Auth;

class PostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // post is valid
        $post = Post::findOrFail($request->post_id);
        if($post->user_id != Auth::id()) return redirect()->route('home');

        return $next($request);
    }
}
