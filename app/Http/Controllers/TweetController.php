<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tweet;
use App\Mention;
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

			$usersMentionedIds = array();
			$body = str_replace("#", "@", parseMentions(request('tweet'), $usersMentionedIds));

			$tweet = Tweet::create(['body' => $body, 'user_id' => $user->id]);
			$user->tweets()->save($tweet);

			foreach ($usersMentionedIds as $id => $value) {
				
				$mention = Mention::create(['tweet_id' => $tweet->id, 'user_id' => $id]);
				$mention->tweet()->associate($tweet->id);
				$mention->user()->associate($id);
			}

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

	public function like(Tweet $tweet)
	{
		if(!$tweet)
			return redirect()->back()->withErrors(array('like' => 'Tweet does not exist!'));

		Auth::user()->likes()->attach($tweet->id);
		return back();
	}

	public function unlike(Tweet $tweet)
	{
		if(!$tweet)
			return redirect()->back()->withErrors(array('like' => 'Tweet does not exist!'));

		Auth::user()->likes()->detach($tweet->id);
		return back();
	}
}
