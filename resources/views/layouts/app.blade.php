<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Twitter Clone</title>
        <link rel="shortcut icon" type="image/gif/png" href="imgs/logo.png">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .form-inline{
              width: 100%;
              display: flex;
              justify-content: right;
            }

            .form-inline #search{
              width: 50%;
            }


            .avatar {
                height: 50px;
                width: 50px;
                border-radius: 100%;
            }
        </style>
    </head>
    <body>

            @if (Route::has('login'))


                <nav class="navbar navbar-expand-sm bg-light">

                  <ul class="navbar-nav nav-fill w-50">
                  @auth

                    <li>
                    <a href="{{ url('/users/' . Auth::user()->id) }}">
                        <img src="{{ Request::root() . '/' . Auth::user()->avatar }}" alt="{{ Auth::user()->username }}" class="avatar">
                    </a>
                    </li>
                    <li class="nav-item">
                       <a href="{{ url('/home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                    @else
                        <li class="nav-item">
                          <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                  </ul>

                  @auth
                  <form class="form-inline" action="{{ url('/search') }}" method="POST">
                    @csrf
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" name="query" required
                    autocomplete="off">
                    @if ($errors->has('query'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('query') }}</strong>
                        </span>
                    @endif
                    <button class="btn btn-success" type="submit">Search</button>
                  </form>

                  <form class="form-inline" action="{{ url('/tweet/' . Auth::id()) }}" method="POST">
                    @csrf
                    <input class="form-control mr-sm-2" type="text" placeholder="Share with the world!" name="tweet" required
                    autocomplete="off">
                    @if ($errors->has('tweet'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('tweet') }}</strong>
                        </span>
                    @endif
                    <button class="btn btn-success" type="submit">Tweet</button>
                  </form>
                  @endauth
                </nav>

            @endif

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                    </form>


            <div class="content">
                @yield('content')
            </div>

                {{-- @includeWhen($errors->has('401'), 'layouts.error', ['error' => $errors->first('401')]) --}}

        @if($errors->has('401'))
            <strong>{{ $errors->first('401') }}</strong>
        @endif
        
        @if (session()->has('success'))
                <h1>{{session()->get('success')}}</h1>
            @endif
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>