@section('page_title')
    <h2>{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::list') }}</h2>
@stop

@section('page_description')
    <p class="sub-text">등록된 플러그인 목록을 볼 수 있습니다.</p>
@stop


<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">
            <div class="panel">
                {{-- heading --}}
                <div class="panel-heading">
                    <div class="pull-left">
                        <div class="btn-group">
                            <a href="{{ route('settings.plugins', Input::except('status')) }}" class="btn btn-default @if(Input::get('status') === null) on @endif">{{ xe_trans('xe::all') }}</a>
                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_ACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_ACTIVATED) on @endif">{{ xe_trans('xe::enabled') }}</a>
                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_DEACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_DEACTIVATED) on @endif">{{ xe_trans('xe::disabled') }}</a>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default">{{ xe_trans('xe::updateList') }}</button>
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
                                <input type="text" class="form-control"  placeholder="{{ xe_trans('xe::enterKeyword') }}" name="query" value="{{ Input::get('query') }}">
                                <button class="btn-link">
                                    <i class="xi-magnifier"></i><span class="sr-only">검색</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- plugin list --}}
                <ul class="list-group list-plugin">

                    @foreach($plugins as $plugin)

                    <!--[D] 플러그인 비활성화  상태off, 업데이트 필요 시 update 클래스 추가 -->
                    <li class="list-group-item @if($plugin->needUpdateInstall()){{--update--}} @endif @if( ! $plugin->isActivated() )off @endif">

                        <div class="left-group">
                            <a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}" class="plugin-title">{{ $plugin->getTitle() }}</a>
                            <dl>
                                <dt class="sr-only">version</dt>
                                <dd>Version {{ $plugin->getInstalledVersion() }}</dd>
                                <dt class="sr-only">{{ xe_trans('xe::author') }}</dt>
                                <dd>By
                                    @if($authors = $plugin->getAuthors())
                                        <a href="{{ array_get(reset($authors),'homepage', array_get(reset($authors),'email')) }}">
                                            {{ '@'.reset($authors)['name'] }}
                                        </a>
                                    @endif
                                </dd>
                                <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
                                <dd>plugins/{{ $plugin->getId() }}</dd>
                            </dl>
                            <p class="ellipsis">{{ $plugin->getDescription() }}</p>

                            {{-- component list --}}
                            @foreach($componentTypes as $type => $typeText)
                                @foreach($plugin->getComponentList($type) as $key => $component)
                                    <span class="label label-{{ $color[$type] }}" title="{{ $component['name'] }}" data-toggle="tooltip">{{ $type }}</span>
                                @endforeach
                            @endforeach

                            {{-- status info --}}
                            {{-- 업데이트가 다운로드 돼 있는 상태 --}}
                            @if($plugin->needUpdateInstall())
                            <div class="alert alert-danger" role="alert">
                                <i class="xi-info-o txt_red"></i>{{ xe_trans('xe::newUpdateDownloaded') }}
                                <a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}" class="alert-link">
                                    Version {{ $plugin->getVersion() }} {{ xe_trans('xe::changeLog') }}</a>
                                {{ xe_trans('xe::or') }}
                                <a href="#" class="alert-link">{{ xe_trans('xe::applyUpdateNow') }}</a>
                            </div>
                            {{--@elseif($plugin->needUpdateDownload())
                                <i class="xi-information-circle txt_red"></i>새로운 업데이트가 있습니다..
                                <a href="#LinkForStoreServer" class="alert-link">
                                    Version {{ $plugin->getLatestVersion() }} 세부 사항</a>
                                또는
                                <a href="#" class="alert-link">지금 업데이트 다운로드하기.</a>--}}
                            @endif

                        </div>
                        <div class="btn-right">
                            @if($plugin->isActivated() && ($plugin->getSettingsURI() !== null) )
                                <a class="btn-link"
                                   href="{{ $plugin->getSettingsURI() }}">{{ xe_trans('xe::settings') }}</a>
                            @endif
                            <a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}" class="btn-link">
                                {{ xe_trans('xe::showDetails') }}
                            </a>
                        </div>
                    </li>

                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</div>

