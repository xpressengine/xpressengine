@section('page_title')
    <h2>{{ xe_trans('xe::pluginList') }}</h2>
@stop

@section('page_description')
    <p class="sub-text">{{ xe_trans('xe::pluginListDescription') }}</p>
@stop

@include($_skin::view('index.tab'))

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
                <div class="panel-heading" style="padding-top: 17px; padding-bottom: 17px;">

                    <div class="pull-right">
                        <div class="search-btn-group">
                            <a href="{{ route('settings.plugins.install') }}" class="xe-btn xe-btn-install"><i class="xi-plus"></i> {{ xe_trans('xe::installNewPlugin') }}</a>
                            <a href="{{ route('settings.plugins.manage.update') }}" class="xe-btn __xe_update_plugin"><span>{{ xe_trans('xe::update_plugin') }} 확인</span></a>
                        </div>
                        <div class="input-group search-group">
                            <form>
                                <div class="search-group-filter">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="text">정렬 필터</span> <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('settings.plugins', Request::except('status')) }}">{{ xe_trans('xe::all') }}</a></li>
                                        <li><a href="{{ route('settings.plugins', array_merge(Request::all(), ['status'=> XePlugin::STATUS_ACTIVATED] )) }}">{{ xe_trans('xe::activatedPlugin') }}</a></li>
                                        <li><a href="{{ route('settings.plugins', array_merge(Request::all(), ['status'=> XePlugin::STATUS_DEACTIVATED] )) }}">{{ xe_trans('xe::deactivatedPlugin') }}</a></li>
                                    </ul>
                                </div>

                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ Request::get('component') ? $componentTypes[Request::get('component')] : xe_trans('xe::supportingComponents') }}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('settings.plugins', Request::except(['component'])) }}"><span>{{ xe_trans('xe::all') }} {{ xe_trans('xe::component') }}</span></a>
                                        </li>
                                        @foreach($componentTypes as $type => $typeText)
                                            <li>
                                                <a href="{{ route('settings.plugins', array_merge( Request::all(), ['component'=> $type] )) }}"><span @if(Request::get('component') === $type)class="text-muted"@endif  >{{ $typeText }}</span></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="search-input-group">
                                    @foreach(Request::except(['query']) as $name => $value)
                                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="{{ xe_trans('xe::enterKeyword') }}" name="query" value="{{ Request::get('query') }}">
                                    <button class="btn-link">
                                        <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="pull-left">
                        <div class="btn-group">
                            <button class="btn btn-default __xe_check_all">전체 선택</button>
                        </div>
                        <div class="btn-group __xe_controll_btn">
                            <a href="{{ route('settings.plugins.manage.activate') }}" class="btn btn-default on __xe_activate_plugin"><span>켜기</span></a>
                            <a href="{{ route('settings.plugins.manage.deactivate') }}" class="btn btn-default on __xe_deactivate_plugin"><span>끄기</span></a>
                            <a href="{{ route('settings.plugins.manage.delete') }}" class="btn btn-default on __xe_remove_plugin"><span>삭제</span></a>
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
