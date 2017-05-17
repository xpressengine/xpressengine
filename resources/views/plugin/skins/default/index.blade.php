@section('page_title')
    <h2>{{ xe_trans('xe::pluginList') }}</h2>
@stop

@section('page_description')
    <p class="sub-text">{{ xe_trans('xe::pluginListDescription') }}</p>
@stop

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">

            @if($operation)
                <div class="__xe_operation" style="margin-bottom: 10px;">
                @include($_skin::view('operation'))
                </div>
            @endif

            <div class="panel">
                {{-- heading --}}
                <div class="panel-heading">
                    <div class="pull-right">
                        @if(!$operation || $operation['status'] !== 'running')
                            <div class="btn-group">
                                <button type="button" data-toggle="modal" data-target="#installPlugin" class="btn btn-primary">{{ xe_trans('xe::installNewPlugin') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <div class="btn-group">
                            <a href="{{ route('settings.plugins', Input::except('status')) }}" class="btn btn-default @if(Input::get('status') === null) btn-primary @endif">{{ xe_trans('xe::all') }}</a>
                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_ACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_ACTIVATED) btn-primary @endif">{{ xe_trans('xe::enabled') }}</a>
                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_DEACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_DEACTIVATED) btn-primary @endif">{{ xe_trans('xe::disabled') }}</a>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default __xe_btn-show-update">{{ xe_trans('xe::updateList') }}</button>
                        </div>
                    </div>

                    {{-- filter --}}
                    <div class="pull-right">
                        <div class="input-group search-group">
                            <form method="GET" action="{{ route('settings.plugins') }}" accept-charset="UTF-8" role="form" id="_search-form">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ Input::get('component') ? $componentTypes[Input::get('component')] : xe_trans('xe::supportingComponents') }}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('settings.plugins', Input::except(['component'])) }}"><span>{{ xe_trans('xe::all') }} {{ xe_trans('xe::component') }}</span></a>
                                        </li>
                                        @foreach($componentTypes as $type => $typeText)
                                            <li>
                                                <a href="{{ route('settings.plugins', array_merge( Input::all(), ['component'=> $type] )) }}"><span @if(Input::get('component') === $type)class="text-muted"@endif  >{{ $typeText }}</span></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @foreach(Input::except(['query']) as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <div class="search-input-group">
                                    <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="{{ xe_trans('xe::enterKeyword') }}" name="query" value="{{ Input::get('query') }}">
                                    <button class="btn-link">
                                        <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- plugin list --}}
                <ul class="list-group list-plugin">

                    @foreach($plugins as $plugin)
                    <!--[D] 플러그인 비활성화  상태off, 업데이트 필요 시 update 클래스 추가 -->
                    @if($plugin->isDevelopMode())
                        @section('plugin.list.dev')
                            @parent
                            @include($_skin::view('item'))
                        @endsection
                    @else
                        @section('plugin.list')
                            @parent
                            @include($_skin::view('item'))
                        @endsection
                    @endif
                    @endforeach

                    @yield('plugin.list')
                </ul>
            </div>

            <div class="panel">
                    {{-- heading --}}
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">수동 설치 플러그인</h3>
                        </div>
                    </div>

                    {{-- plugin list --}}
                    <ul class="list-group list-plugin">
                        @yield('plugin.list.dev')
                    </ul>
                </div>
        </div>
    </div>
</div>

<div id="installPlugin" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('settings.plugins.install') }}" method="POST" data-submit="xe-ajax" data-callback="checkPluginInstall">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ xe_trans('xe::installNewPlugin') }}</h4>
                </div>
                <div class="modal-body">
                    {{ uio('formText', ['name'=>'pluginId', 'label'=>xe_trans('xe::pluginId'), 'placeholder' => xe_trans('xe::inputNewPluginId')]) }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{xe_trans('xe::cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{ xe_trans('xe::install') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{!! app('xe.frontend')->html('plugin.install.check')->content("
<script>
    var checkPluginInstall = function (data) {
        location.reload();
    }
</script>
")->load() !!}

@if($operation && $operation['status'] === 'running')
    {{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
    {!! app('xe.frontend')->html('plugin.get-operation')->content("
    <script>
        $(function($) {
            var loadOperation = setInterval(function(){
                XE.page('".route('settings.plugins.operation')."', '.__xe_operation', {}, function(data){
                    if(data.operation.status != 'running') {
                        clearInterval(loadOperation);
                        location.reload();
                    }
                });
            }, 3000);
        });
    </script>
    ")->load() !!}
@endif

@if($operation && $operation['status'] !== 'running')
{!! app('xe.frontend')->html('plugin.delete-operation')->content("
<script>
    window.deletePluginOperation = function (data, textStatus, jqXHR) {
        XE.toast('success', data.message);
        $('.__xe_operation').slideUp();
    };
</script>
")->load() !!}
@endif
