<div class="panel">
    <div class="panel-heading">
        <div class="panel-heading-search">
            <form action="{{ route('settings.plugins.install.items') }}" data-submit="xe-plugin-items" method="GET">
                <input type="text" class="xe-form-control" placeholder="{{ xe_trans('xe::enterKeyword') }}" name="q" value="{{ $q or ''}}">
                <button class="panel-heading-search-btn" type="button"><i class="xi-search"></i><span class="xe-sr-only">검색</span></button>
            </form>
        </div>
    </div>

    {{-- plugin list --}}
    @if($plugins->count())
        <ul class="list-group list-install">
            @foreach($plugins as $plugin)
                @include($_skin::view('install.item'))
            @endforeach
        </ul>
    @else
        <div class="panel-body">
            <p>{{ xe_trans('xe::noPlugins') }}</p>
        </div>
    @endif

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
