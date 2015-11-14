@section('page_title')
    <h2>플러그인 자세히 보기 - {{ $plugin->getTitle() }}</h2>
@stop


@section('page_description')
    <p class="sub_txt">등록된 플러그인 목록을 볼 수 있습니다.</p>
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
                            @if(empty($plugin->getMetaData()['extra']['xpressengine']['icon']))
                                <img src="/assets/settings/img/@tmp_plugin_logo.jpg" width="100" height="100" alt="{{$plugin->getTitle()}}">
                            @else
                                <img src="{{$plugin->getMetaData()['extra']['xpressengine']['icon']}}" width="100" height="100" alt="{{$plugin->getTitle()}}">
                            @endif
                        </div>
                        <dl>
                            <dt class="blind">{{xe_trans('xe::author')}}</dt>
                            <dd>
                                <i class="xi-user"></i>
                                @if($authors = $plugin->getAuthors())
                                    <a href="{{ array_get(reset($authors),'homepage', array_get(reset($authors),'email')) }}">
                                        {{ '@'.reset($authors)['name'] }}
                                    </a>
                                @endif
                            </dd>
                            <dt class="blind">{{xe_trans('xe::author')}}</dt>
                            <dd><i class="xi-clip"></i>
                                @if($authors = $plugin->getAuthors())
                                    <a href="{{ reset($authors)['homepage'] }}">
                                        {{ '@'.reset($authors)['name'] }}
                                    </a>
                                @endif
                            </dd>
                            <dt class="blind">Source</dt>
                            <dd><i class="xi-download"></i>
                                @if(!empty($plugin->getSupport()['source']))
                                <a href="{{$plugin->getSupport()['source']}}" target="_blank">{{$plugin->getSupport()['source']}}</a>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="col_right">
                    @if($plugin->isActivated())
                        <form method="POST" action="{{ route('settings.plugins.deactivate', [$plugin->getId()]) }}" accept-charset="UTF-8" role="form">
                            {!! csrf_field() !!}
                            <button class="btn btn-danger v2">끄기</button>
                        </form>

                        @if($plugin->isActivated() && $plugin->checkUpdate())
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
                {{--<ul class="nav nav-pills nav-justified">--}}
                    {{--<li class="active"><a href="#">세부사항</a></li>--}}
                    {{--<li><a href="#">문서정보</a></li>--}}
                    {{--<li><a href="#">지원</a></li>--}}
                    {{--<li><a href="#">업데이트 기록</a></li>--}}
                {{--</ul>--}}
            </div>
            <ul class="list-group">
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
                            {{--<th scope="row">지원컴포넌트</th>--}}
                            {{--<td>--}}
                            {{--<span class="label label-green">label-green</span>--}}
                            {{--<span class="label label-teal">label-teal</span>--}}
                            {{--<span class="label label-blue">label-blue</span>--}}
                            {{--<span class="label label-violet">label-violet</span>--}}
                            {{--<span class="label label-purple">label-purple</span>--}}
                            {{--<span class="label label-pink">label-pink</span>--}}
                            {{--<span class="label label-brown">label-brown</span>--}}
                            {{--<span class="label label-grey">label-grey</span>--}}
                            {{--<span class="label label-black">label-black</span>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<th scope="row">호환성</th>--}}
                            {{--<td>XpressEngine 0.8 or higher</td>--}}
                            {{--</tr>--}}
                            </tbody>
                        </table>
                    </div>
                </li>
                {{--<li class="list-group-item">--}}
                {{--<p class="tit">스크린샷</p>--}}
                {{--<div class="swiper-container swiper">--}}
                {{--<div class="swiper-wrapper">--}}
                {{--<div class="swiper-slide">--}}
                {{--<div class="thum_plugin">--}}
                {{--<!--[D] 실제 이미지 사이즈 800*500 -->--}}
                {{--<img src="assets/settings/img/@tmp_plugin_st.jpg" width="640" height="400" alt="plugin screenshot">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                {{--<div class="thum_plugin">--}}
                {{--<img src="assets/settings/img/@tmp_plugin_st2.jpg" width="640" height="400" alt="plugin screenshot">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                {{--<div class="thum_plugin">--}}
                {{--<img src="assets/settings/img/@tmp_plugin_st.jpg" width="640" height="400" alt="plugin screenshot">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<!-- Add Pagination -->--}}
                {{--<div class="swiper-pagination swiper-pagination-white swiper-pagination"></div>--}}
                {{--<!-- Add Arrows -->--}}
                {{--<div class="swiper-button-next swiper-button-white swiper-button-next" style="opacity:0"></div>--}}
                {{--<div class="swiper-button-prev swiper-button-white swiper-button-prev" style="opacity:0"></div>--}}
                {{--</div>--}}
                {{--</li>--}}
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
        </div>
    </div>
</div>
<!--//어드민 컨텐츠 영역 -->

{!! uio('uiobject/xpressengine@chakIt', 'Settings:플러그인') !!}
