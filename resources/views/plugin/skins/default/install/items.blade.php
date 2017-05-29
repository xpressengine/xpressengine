<div class="panel">
    <div class="panel-heading">
        <div class="pull-left">
            <div class="row">
                <div class="col-sm-9">
                    <ul class="nav nav-pills __xe_nav_link">
                        @if(isset($q)) <li role="presentation" class="active"><a href="#" onclick="return false;">검색결과</a></li>@endif
                        <li role="presentation" @if($filter === 'top')class="active" @endif><a href="{{ route('settings.plugins.install.items', ['filter' => 'top']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.reset">추천</a></li>
                        <li role="presentation" @if($filter === 'popular')class="active" @endif><a href="{{ route('settings.plugins.install.items', ['filter' => 'popular']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.reset">인기</a></li>
                        <li role="presentation" @if($filter === 'purchased')class="active" @endif><a href="{{ route('settings.plugins.install.items', ['filter' => 'purchased']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.reset">내가 구매한 플러그인</a></li>
                    </ul>
                </div>
                <hr class="visible-xs-block">
                <div class="col-sm-3">
                    {{--<a class="btn btn-default pull-right"
                       href="{{ route('settings.plugins.install.items', ['filter' => 'purchased']) }}"
                       data-toggle="xe-page" data-target=".__xe_plugin_items">구매한 플러그인</a>--}}
                    <form action="{{ route('settings.plugins.install.items') }}" data-submit="xe-plugin-items" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="검색어를 입력하세요" name="q" value="{{ $q or ''}}">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">검색</button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{-- plugin list --}}
        @if($plugins->count())
            <ul class="list-group list-plugin">
                @foreach($plugins as $plugin)
                    @include($_skin::view('install.item'))
                @endforeach
            </ul>
        @else
            <div class="panel-body">
                <p>조회된 플러그인이 없습니다.</p>
            </div>
        @endif
    </div>

    @if($filter !== 'purchased' && $plugins->hasPages())
    <div class="panel-footer">
        <div class="pull-left">
            <nav class="__xe_plugin_items_link" data-url="">
                {!! $plugins->render() !!}
            </nav>
        </div>
    </div>
    @endif
</div>
