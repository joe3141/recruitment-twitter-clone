<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Image;
use Auth;
// use Redirect;

class UserController extends Controller
{	

	public function __construct()
	   {
	   	$this->middleware('auth');
	   }   


	public function show(User $user) {	
		$tweets = $user->tweets()->orderBy('created_at', 'desc')->get();
		$profileOwner = Auth::id() === $user->id;
		return view('user.profile', compact('user', 'tweets', 'profileOwner'));
	}

	public function edit(User $user)
	{
		if(Auth::id() === $user->id)
			return view('user.edit');
		else
			// Redirect::back()->withErrors(['404', 'You are not authorized to edit another user\'s data!']);
		return redirect()->to(request()->root())->withErrors(['401' => 'You are not authorized to edit another user\'s data!']);
	}

	public function update(User $user)
	{
		$this->validate(request(), [
			'username' => 'nullable|string|max:30|alpha_dash|unique:users,username,' . $user->id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:6000'
			]);

		$user->username = request('username') ?: $user->username;
		$user->email = request('email') ?: $user->email;
		$user->password = request('password') ?: $user->password;


		$uri;
        if(request('avatar')){
            $filename = time() . '.' . request('avatar')->getClientOriginalExtension();
            Image::make(request('avatar'))->resize(300, 300)->save(public_path('/imgs/' . $filename));
            $uri = 'imgs/' . $filename;
        }else{
            $uri = 'imgs/default.png';
        }

        $user->avatar = $uri;

		$user->save();
		Auth::setUser($user);
		return view('user.profile', compact('user'));
	}

	public function search()
	{

		$this->validate(request(), [
			'query' => 'required|string|max:100|alpha_dash'
			]);

		$results = User::search(request('query'))->get();
		return view('user.search', compact('results'));
	}

	public function follow(User $user)
	{
		if(!$user)
			return redirect()->back()->withErrors(array('follow' => 'User does not exist!'));

		$user->followers()->attach(Auth::id());
		return back();
	}

	public function unfollow(User $user)
	{	
		if(!$user)
			return redirect()->back()->withErrors(array('follow' => 'User does not exist!'));

		$user->followers()->detach(Auth::id());
		return back();
	}
}
