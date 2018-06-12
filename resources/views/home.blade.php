@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">News Feed</div>

                
                <div class="container">
                    <div class="row">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Avatar</th>
                                    <th>Username</th>
                                    <th>Tweet</th>
                                    <th>Like</th>
                                </tr>
                            </thead>

                        @foreach($newsFeedContent as $tweet)
                        <tr>
                            <td><a href="{{ url('users/' . $tweet->user->id) }}">
                             @if(!$tweet->user->provider)
                            <img src="{{ Request::root() . '/' . $tweet->user->avatar }}" width="100" height="100">

                        @else
                            <img src="{{ Request::root() . '/' . $tweet->user->avatar }}" width="100" height="100">
                        @endif
                            </a></td>
                            <td><a href="{{ url('users/' . $tweet->user->id) }}">{{ $tweet->user->username }}</a></td>
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
                        </tr>
                    @endforeach

                        </table>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
