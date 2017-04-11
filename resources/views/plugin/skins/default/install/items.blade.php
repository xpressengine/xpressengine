<div class="panel">
    <div class="panel-heading">
        <div class="pull-left">
            <div class="row">
                <div class="col-sm-9">
                    <form action="{{ route('settings.plugins.install.items') }}" data-submit="xe-plugin-items" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="검색어를 입력하세요" name="q" value="{{ $q or ''}}">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">검색</button>
                        </span>
                        </div>
                    </form>
                </div>
                <hr class="visible-xs-block">
                <div class="col-sm-3">
                    <a class="btn btn-default pull-right"
                       href="{{ route('settings.plugins.install.items', ['filter' => 'purchased']) }}"
                       data-toggle="xe-page" data-target=".__xe_plugin_items">구매한 플러그인</a>
                </div>
            </div>
        </div>
    </div>

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

    @if(!request()->has('filter') && $plugins->hasPages() )
    <div class="panel-footer">
        <div class="pull-left">
            <nav class="__xe_plugin_items_link" data-url="">
                {!! $plugins->render() !!}
            </nav>
        </div>
    </div>
    @endif
</div>
