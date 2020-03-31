@section('page_title')
    <h2>{{ xe_trans('xe::updates') }}</h2>
@endsection

<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                @if(!$available)
                <div class="alert alert-danger" role="alert">
                    {!! xe_trans('xe::iniOptionOff', ['option' => '<code>allow_url_fopen</code>']) !!}
                    {!! xe_trans('xe::turnOnIniOptionForUpdate', ['option' => '<code>allow_url_fopen</code>']) !!}
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
</div>
