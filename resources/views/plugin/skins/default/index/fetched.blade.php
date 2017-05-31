@section('page_title')
    <h2>{{ xe_trans('xe::pluginList') }}</h2>
@stop

@section('page_description')
    <p class="sub-text">{{ xe_trans('xe::pluginListDescription') }}</p>
@stop

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">

            @include($_skin::view('index.tab'))

            @if($operation)
                <div class="__xe_operation" style="margin-bottom: 10px;">
                @include($_skin::view('operation'))
                </div>
            @endif

            <div class="panel">
                {{-- heading --}}
                <div class="panel-heading" style="padding-top: 17px; padding-bottom: 17px;">

                    <div class="row">

                        <div class="col-md-7 col-sm-12">
                            <form method="GET" action="{{ route('settings.plugins') }}" accept-charset="UTF-8" role="form" id="_search-form" class="form-inline">
                                    <div class="form-group">
                                        <div class="btn-group">
                                            <a href="{{ route('settings.plugins', Input::except('status')) }}" class="btn btn-default @if(Input::get('status') === null) btn-primary @endif">{{ xe_trans('xe::all') }}</a>
                                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_ACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_ACTIVATED) btn-primary @endif">{{ xe_trans('xe::enabled') }}</a>
                                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_DEACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_DEACTIVATED) btn-primary @endif">{{ xe_trans('xe::disabled') }}</a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group search-group">
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
                                            <div class="search-input-group">
                                                @foreach(Input::except(['query']) as $name => $value)
                                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                                @endforeach
                                                <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="{{ xe_trans('xe::enterKeyword') }}" name="query" value="{{ Input::get('query') }}">
                                                <button class="btn-link">
                                                    <i class="xi-magnifier"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <div class="col-md-5 col-sm-12 text-right">
                            <a href="{{ route('settings.plugins.install') }}" class="btn btn-primary">{{ xe_trans('xe::installNewPlugin') }}</a>
                            <a href="{{ route('settings.plugins.manage.update') }}" class="btn btn-default __xe_update_plugin"><span>{{ xe_trans('xe::update_plugin') }}</span></a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle __xe_manage_plugin" data-toggle="dropdown" aria-expanded="false" disabled="disabled">선택된 플러그인을 ... <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('settings.plugins.manage.activate') }}" class="__xe_activate_plugin"><span>켜기</span></a>
                                        <a href="{{ route('settings.plugins.manage.deactivate') }}" class="__xe_deactivate_plugin"><span>끄기</span></a>
                                        <a href="{{ route('settings.plugins.manage.delete') }}" class="__xe_remove_plugin"><span>삭제</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- plugin list --}}
                <ul class="list-group list-plugin">

                    @foreach($plugins as $plugin)
                        @include($_skin::view('index.item'))
                    @endforeach

                </ul>
            </div>

        </div>
    </div>
</div>
