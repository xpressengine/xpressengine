@section('page_title')
    <h2>업데이트</h2>
@endsection
<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            @if(!$available)
            <div class="alert alert-danger" role="alert">
                <code>allow_url_fopen</code> 옵션이 꺼져 있습니다. 옵션을 켜야 업데이트가 정상적으로 동작합니다.
            </div>
            @endif

            @if(version_compare($latest, __XE_VERSION__) === -1 || version_compare(__XE_VERSION__, $installedVersion) === -1)
                @include('update.case.conflict')
            @elseif($latest === __XE_VERSION__ && $installedVersion === __XE_VERSION__)
                @include('update.case.latest')
            @else
                @include('update.case.updatable')
            @endif

            @include('update.plugin.index')

        </div>
    </div>
</div>

