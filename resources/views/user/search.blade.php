@extends('layouts.app')

@section('content')
		
	<div class="container">
		<h2>Search Results</h2>

		@if(empty($results->toArray()))

			<h2>No Users Found!</h2>

		@else
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Avatar</th>
						<th>Username</th>
						<th>Email</th>
					</tr>
				</thead>

				@foreach($results as $user)
					<tr>
						<td><a href="{{ url('users/' . $user->id) }}"><img src="{{ Request::root() . '/' . $user->avatar }}" width="100" height="100"></a></td>
						<td><a href="{{ url('users/' . $user->id) }}">{{ $user->username }}</a></td>
						<td>{{ $user->email }}</td>
					</tr>
				@endforeach
			</table>
		@endif
	</div>

@endsection