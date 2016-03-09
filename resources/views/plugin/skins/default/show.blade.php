@section('page_title')
    <h2><a href="{{ route('settings.plugins') }}"><i class="xi-arrow-left"></i>플러그인 상세</a></h2>
@stop

<!--어드민 컨텐츠 영역 col-sm-"n" n:1~12에 따라 그리드 사용가능-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel plugin_detail">
            <div class="panel-heading">
                <div class="col_left">
                    <p class="plugin_tit">{{$plugin->getTitle()}}</p>
                    <div class="plugin_summary">
                        <div class="img_thmb">
                            @if($plugin->getIcon() === null)
                                <img src="{{ asset('assets/core/plugin/img/noicon.png') }}" width="100" height="100" alt="{{$plugin->getTitle()}}">
                            @else
                                <img src="{{$plugin->getIcon()}}" width="100" height="100" alt="{{$plugin->getTitle()}}">
                            @endif
                        </div>

                        {{-- author info --}}
                        <dl>

                        @if($author = $plugin->getAuthor())

                            {{-- author name --}}
                            <dt class="blind">{{xe_trans('xe::author')}}</dt>
                            <dd>
                                <i class="xi-user"></i>
                                @if($email = array_get($author, 'email'))
                                <a href="mailto:{{ $email }}">
                                    {{ '@'.array_get($author, 'name', '') }}
                                </a>
                                @else
                                    {{ '@'.array_get($author, 'name', '') }}
                                @endif
                            </dd>

                            {{-- author homepage --}}
                            @if($homepage = array_get($author, 'homepage'))
                            <dt class="blind">{{xe_trans('xe::author')}}</dt>
                            <dd>
                                <i class="xi-clip"></i>
                                <a href="{{ $homepage }}">
                                    {{ $homepage }}
                                </a>
                            </dd>
                            @endif

                        @endif

                            {{-- author source--}}
                            @if($source = $plugin->getSupport('source'))
                            <dt class="blind">Source</dt>
                            <dd><i class="xi-download"></i>
                                <a href="{{ $source }}" target="_blank">{{ $source }}</a>
                            </dd>
                            @endif
                        </dl>

                    </div>
                </div>
                <div class="col_right">
                    @if($plugin->isActivated())
                        <form method="POST" action="{{ route('settings.plugins.deactivate', [$plugin->getId()]) }}" accept-charset="UTF-8" role="form">
                            {!! csrf_field() !!}
                            <button class="btn btn-danger v2">끄기</button>
                        </form>

                        @if($plugin->isActivated() && $plugin->checkUpdated($plugin->getInstalledVersion()))
                            {{--<button class="btn btn-default blue v2">업데이트</button>--}}
                        @endif

                        @if($plugin->getSettingsURI() !== null)
                            {{--<button class="btn btn-default blue v2">관리</button>--}}
                        @endif
                    @else
                        <form method="POST" action="{{ route('settings.plugins.activate', [$plugin->getId()]) }}" accept-charset="UTF-8" role="form">
                            {!! csrf_field() !!}
                            <button class="btn btn-default blue v2">켜기</button>
                        </form>
                    @endif

                </div>
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#details" data-toggle="tab" role="tab">Details</a></li>
                    <li><a href="#readme" data-toggle="tab" role="tab">Documentation</a></li>
                    {{--<li><a href="#support" data-toggle="tab" role="tab">지원</a></li>--}}
                    <li><a href="#changelog" data-toggle="tab" role="tab">Change Log</a></li>
                </ul>
            </div>
            <div class="tab-content">
                {{-- 세부사항 --}}
                <ul role="tabpanel" id="details" class="list-group tab-pane fade in active">
                    <li class="list-group-item">
                        <p class="tit">{{xe_trans('xe::description')}}</p>
                        <p>{{ $plugin->getDescription() }}</p>
                    </li>
                    <li class="list-group-item">
                        <p class="tit">정보</p>
                        <div>
                            <table class="plugin_tbl">
                                <colgroup>
                                    <col width="200">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th scope="row">{{xe_trans('xe::version')}}</th>
                                    <td>{{$plugin->getVersion()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{xe_trans('xe::author')}}</th>
                                    <td>
                                        @if($authors = $plugin->getAuthors())
                                            {{ '@'.reset($authors)['name'] }}
                                        @endif
                                    </td>
                                </tr>
                                {{--<tr>--}}
                                {{--<th scope="row">업데이트</th>--}}
                                {{--<td>2015.10.15</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                {{--<th scope="row">인스톨 수</th>--}}
                                {{--<td>1+ million</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                <th scope="row">지원컴포넌트</th>
                                <td>
                                @foreach($componentTypes as $type => $typeText)
                                    @foreach($plugin->getComponentList($type) as $key => $component)
                                        <span class="label label-{{ $color[$type] }}" title="{{ $component['name'] }}" data-toggle="tooltip">{{ $type }}</span>
                                    @endforeach
                                @endforeach
                                </td>
                                </tr>
                                {{--<tr>--}}
                                {{--<th scope="row">호환성</th>--}}
                                {{--<td>XpressEngine 0.8 or higher</td>--}}
                                {{--</tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <p class="tit">스크린샷</p>
                        @if($screenshots = $plugin->getScreenshots())
                        <div class="swiper-container swiper">
                            <div class="swiper-wrapper">
                                @foreach($screenshots as $screenshot)
                                <div class="swiper-slide">
                                    <div class="thum_plugin">
                                        <img src="{{ $screenshot }}" height="400" alt="plugin screenshot">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination swiper-pagination-white swiper-pagination"></div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white swiper-button-next" style="opacity:0"></div>
                            <div class="swiper-button-prev swiper-button-white swiper-button-prev" style="opacity:0"></div>
                        </div>
                        @else
                            스크린샷이 없습니다.
                        @endif

                    </li>
                    <li class="list-group-item">
                        <p class="tit">{{xe_trans('xe::supportComponents')}}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{xe_trans('xe::name')}}</th>
                                    <th>{{xe_trans('xe::type')}}</th>
                                    <th>{{xe_trans('xe::description')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($componentTypes as $type => $typeText)
                                    @foreach($plugin->getComponentList($type) as $key => $component)
                                        @if($class = $component['class'])
                                            @if(class_exists($class))
                                                <tr>
                                                    <td>
                                                        {{ $class::getComponentInfo('name') }}
                                                        @if($plugin->isActivated() && $class::getSettingsUri() !== null)
                                                            <a href="{{ $class::getSettingsUri()}}" class="btn_plugin_cog"><i class="xi-cog"></i></a>
                                                        @endif
                                                    </td>
                                                    <td><span class="label label-green">{{ $typeText }}</span></td>
                                                    <td>{{ $class::getComponentInfo('description') }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>

                {{-- 문서정보 --}}
                <div role="tabpanel" class="tab-pane fade panel-body" id="readme">
                    @if($readme = $plugin->getReadMe())
                    {{ nl2br($readme) }}
                    @else
                    작성된 문서가 없습니다.
                    @endif
                </div>

                {{-- 지원 --}}
                {{--<div role="tabpanel" class="tab-pane fade panel-body" id="support">

                </div>--}}

                {{-- 업데이트 기록 --}}
                <div role="tabpanel" class="tab-pane fade panel-body" id="changelog">
                    @if($changelog = $plugin->getChangeLog())
                        {{ nl2br($changelog) }}
                    @else
                        작성된 업데이트 사항이 없습니다.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!--//어드민 컨텐츠 영역 -->

{!! uio('uiobject/xpressengine@chakIt', 'Settings:플러그인') !!}
