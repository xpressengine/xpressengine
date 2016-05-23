{{-- stylesheet --}}
{{ app('xe.frontend')->css([
    'assets/vendor/bootstrap/css/bootstrap.min.css',
    $theme::asset('css/theme.css')
])->load() }}

{{-- script --}}
{{ app('xe.frontend')->js([
    'assets/vendor/bootstrap/js/bootstrap.min.js'
])->load() }}

<div class="xe-container">
    <div class="header">
        <h3>{{ xe_trans(XeFrontend::output('title')) }}</h3>
    </div>

    <div class="spot">
        <h1>{{ $config->get('spotTitle', 'Xpressengine') }}</h1>
        <p class="lead">
            @if($config->get('spotImagePath') !== null)
                <img src="{{ $config->get('spotImagePath') }}">
            @endif
        </p>
    </div>

    <div class="xe-row">
        <div class="xe-col-md-12">
            <div id="content">
                {!! $content !!}
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>XpressEngine3</p>
    </footer>
</div>
