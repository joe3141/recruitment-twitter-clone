<?php
	
	use App\User;

	/*
	*	Retrieves the user record by name.
	*	Could work using exact search by username, or using algolia's fuzzy search. 
	*	Current method chosen is exact search.
	*/
	function getUserByName($username){
		// $user = User::search($username)->first(); // This works.
		$user = User::where('username', '=', $username)->first();

		return $user;
	}

	function parseMentions($input){
		$regex =  '/@(\w+)/';

		if (is_array($input)) {
			$user = getUserByName(substr($input[0], 1));
			if($user)
				$input = "<a href= \"" . url('/users/' . $user->id) . "\">#" . substr($input[0], 1) . '</a>';
			else
				$input = '#' . substr($input[0], 1);
		}

		return preg_replace_callback($regex, 'parseMentions', $input);
	} 