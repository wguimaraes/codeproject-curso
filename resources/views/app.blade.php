<!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    
    <!-- Styles -->
    @if(Config::get('app.debug'))
        <link href="{{asset('build/css/app.css')}}" rel="stylesheet" />
        <link href="{{asset('build/css/components.css')}}" rel="stylesheet" />
        <link href="{{asset('build/css/flaticon.css')}}" rel="stylesheet" />
        <link href="{{asset('build/css/font-awesome.css')}}" rel="stylesheet" />
    @else
        <link href="{{elixir('css/all.css')}}" rel="stylesheet" />
    @endif
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div ng-view></div>
    
    <!-- JavaScripts -->
    @if(Config::get('app.debug'))
    
        <script type="text/javascript" src="{{asset('build/js/vendor/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular-route.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular-resource.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular-animate.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular-messages.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/ui-bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/navbar.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular-cookies.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/query-string.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/vendor/angular-oauth2.min.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('build/js/app.js')}}"></script>
        
        <!-- CONTROLLER'S -->
        <script type="text/javascript" src="{{asset('build/js/controllers/login.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/home.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/client/clientList.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/client/clientNew.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/client/clientEdit.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/client/clientRemove.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('build/js/controllers/project/notes/ProjectNotesList.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/project/notes/ProjectNotesNew.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/project/notes/ProjectNotesEdit.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/project/notes/ProjectNotesRemove.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/project/notes/ProjectNotesShow.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('build/js/controllers/project/ProjectList.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/controllers/project/ProjectNew.js')}}"></script>
        
         <!-- FILTER'S -->
        <script type="text/javascript" src="{{asset('build/js/filters/dateBr.js')}}"></script>
        
        <!-- SERVICE'S -->
        <script type="text/javascript" src="{{asset('build/js/services/Client.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/services/ProjectNotes.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/services/User.js')}}"></script>
        <script type="text/javascript" src="{{asset('build/js/services/Project.js')}}"></script>
    @else
        <script type="text/javascript" src="{{elixir('js/all.js')}}"></script>
    @endif
</body>
</html>
