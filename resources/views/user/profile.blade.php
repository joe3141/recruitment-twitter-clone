@extends('layouts.app')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<h3><a href="{{ Request::url() }}">{{ $user->username }}</a></h3>				
			</div>

			<div class="col-lg-4">
				<a href="{{ Request::url() }}"><img src="{{ Request::root() . '/' . $user->avatar }}" width="100" height="100"></a>		
			</div>

			@if($profileOwner)
				<div class="col-lg-4">
					<a href="{{ Request::url() . '/edit' }}"><h3>Edit Your Profile</h3></a>
				</div>
			@endif
		</div>

		@if(!$profileOwner)
			@if(!(Auth::user()->doesFollow($user->id)))
				<div class="row">
					<div class="col-lg-4"></div>

					<div class="col-lg-4">
						<form method="post" action="{{  Request::url() . '/follow' }}">
							@csrf
							<button type="submit" class="btn btn-primary" style="margin-top: 10px">Follow</button>
							@includeWhen($errors->has('follow'), 'layouts.error', ['error' => $errors->first('follow')])
						</form>
					</div>
				</div>
			@else
				<div class="row">
					<div class="col-lg-4"></div>

					<div class="col-lg-4">
						<form method="post" action="{{ Request::url() . '/unfollow' }}">
							@csrf
							<button type="submit" class="btn btn-primary" style="margin-top: 10px">Unfollow</button>
							@includeWhen($errors->has('follow'), 'layouts.error', ['error' => $errors->first('follow')])
						</form>
					</div>
				</div>
			@endif
		@endif

		@if(!empty($tweets->toArray()))
			<div class="row">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Avatar</th>
							<th>Username</th>
							<th>Tweet</th>
							<th>Like</th>
							@if($profileOwner)
								<th>Remove</th>
							@endif
						</tr>
					</thead>

					@foreach($tweets as $tweet)
						<tr>
							<td><a href="{{ url('users/' . $user->id) }}"><img src="{{ Request::root() . '/' . $user->avatar }}" width="100" height="100"></a></td>
							<td><a href="{{ url('users/' . $user->id) }}">{{ $user->username }}</a></td>
							<td>{!! $tweet->body !!}</td>
							@if(!Auth::user()->likes()->find($tweet->id))

								<td>
									<a href="{{ url("like/$tweet->id") }}" class="btn btn-primary">Like</a>
								</td>

							@else

								<td>
									<a href="{{ url("unlike/$tweet->id") }}" class="btn btn-primary">Unlike</a>
								</td>

							@endif

							@if($profileOwner)
								<td>
									<form method="post" action="{{ url('/tweet/' . $user->id . '/' . $tweet->id) }}">
									@csrf
									{{ method_field('delete') }}
									<button type="submit" class="btn btn-danger">Delete Tweet</button>
									</form>
								</td>
							@endif
						</tr>
					@endforeach
				</table>
			</div>

			@includeWhen($errors->has('like'), 'layouts.error', ['error' => $errors->first('like')])
		@else
			<div class="row">
				<h3>User Has Not Made Any Tweets</h3>
			</div>
		@endif

	</div>

@endsection