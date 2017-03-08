{{-- script --}}
{{ app('xe.frontend')->js([
    'assets/vendor/bootstrap/js/bootstrap.min.js'
])->load() }}

{{-- stylesheet --}}
{{ app('xe.frontend')->css([
    'assets/vendor/bootstrap/css/bootstrap.min.css',
    $theme::asset('css/theme.css')
])->load() }}

{{-- inline style --}}
{{ app('xe.frontend')->html('theme.style')->content("
<style>
    body {
        padding-top: 50px;
        padding-bottom: 20px;
    }
</style>
")->load() }}

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url() }}">{{ $config->get('logo_title', 'Xpressengine') }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            @include($theme::view('gnb'))

            @if(auth()->check())
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->getDisplayName() }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('user.profile', ['user'=> auth()->id()]) }}">Profile</a></li>
                            <li><a href="{{ route('user.settings') }}">My Settings</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}">logout</a></li>
                        </ul>
                    </li>
                </ul>
            @else
            <div class="navbar-form navbar-right">
                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" placeholder="Email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control" name="password">
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>
            </div>
            @endif
        </div><!--/.navbar-collapse -->
    </div>
</nav>

@if($config->get('show_spot', 'hide') === 'show')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>{{ $config->get('spot_title', 'Xpressengine') }}</h1>
        <p>{!! nl2br($config->get('spot_content', 'This theme is the implementation of <a href="http://getbootstrap.com/examples/jumbotron/">Bootstrap Jumbotron Template</a>.')) !!}</p>

        @if($config->get('spot_image') !== null)
        <p class="lead">
                <img src="{{ $config->get('spot_image.path') }}">
        </p>
        @endif

    </div>
</div>
@endif

<div class="container">
    <div id="content">
        {!! $content !!}
    </div>

    <hr>

    <footer>
        <p>© 2016 Company, Inc.</p>
    </footer>
</div>

