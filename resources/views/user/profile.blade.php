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

			@if(Auth::id() === $user->id)
				<div class="col-lg-4">
					<a href="{{ Request::url() . '/edit' }}"><h3>Edit Your Profile</h3></a>
				</div>
			@endif
		</div>

		@if(Auth::id() !== $user->id)
			@if(!(Auth::user()->doesFollow($user->id)))
				<div class="row">
					<div class="col-lg-4"></div>

					<div class="col-lg-4">
						<form method="post" action="{{  Request::url() . '/follow' }}">
							@csrf
							<button type="submit" class="btn btn-primary" style="margin-top: 10px">Follow</button>
							@includeWhen($errors->has('follow'), 'layouts.error')
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
							@includeWhen($errors->has('unfollow'), 'layouts.error')
						</form>
					</div>
				</div>
			@endif
		@endif
	</div>

@endsection