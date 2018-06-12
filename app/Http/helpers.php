<?php
	
	use App\User;



	/**
	* 
	*/
	class MyCallback
	{
		
		public $users_mentioned_acc;
		function __construct($users_mentioned_acc){
			$this->users_mentioned_acc = $users_mentioned_acc;
		}

		public function callback($input)
		{
		$regex =  '/@(\w+)/';

		if (is_array($input)) {
			$user = getUserByName(substr($input[0], 1));
			if($user){
				$input = "<a href= \"" . url('/users/' . $user->id) . "\">#" . substr($input[0], 1) . '</a>';

				if(!array_key_exists($user->id, $this->users_mentioned_acc)) // If they weren't mentioned before in the same tweet. log(n)
					$this->users_mentioned_acc[$user->id] = true;
			}
			else
				$input = '#' . substr($input[0], 1);
		}

		return preg_replace_callback($regex, array($this, 'callback'), $input);
		}
	}

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

	function parseMentions($input, &$users_mentioned_acc){

		$callback = new MyCallback($users_mentioned_acc);
		$out = $callback->callback($input, $users_mentioned_acc);
		$users_mentioned_acc = $callback->users_mentioned_acc;

		return $out;
	}  