<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tweet;
use Auth;

class TweetController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}   


	public function create(User $user)
	{
		if(Auth::id() === $user->id){
			$this->validate(request(), ['tweet' => 'required|string|max:140']);

			$body = str_replace("#", "@", parseMentions(request('tweet')));

			$tweet = Tweet::create(['body' => $body, 'user_id' => $user->id]);
			$user->tweets()->save($tweet);

			return back()->withSuccess('Tweeted!');
		}else
		return redirect()->to(request()->root())->withErrors(['401' => 'You are not authorized to create another user\'s tweet!']);	   
	}

	public function delete(User $user, Tweet $tweet)
	{
		if(Auth::id() === $user->id){
			$tweet->delete();
			return back();
		}else{
			return redirect()->to(request()->root())->withErrors(['401' => 'You are not authorized to delete another user\'s tweet!']);
		}
	}
}
