@inject('handler', 'xe.plugin')
<li class="list-group-item @if( ! $plugin->isActivated() )off @endif">
    <div class="list-group-item-checkbox">
        <label class="xe-label">
            <input type="checkbox" value="{{ $plugin->getId() }}" class="__xe_checkbox">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text xe-sr-only">체크박스</span>
        </label>
    </div>
    <div class="left-group">
        <span class="plugin-title">{{ $plugin->getTitle() }}</span>
        <dl>
            <dt class="sr-only">version</dt>
            <dd>Version {{ $plugin->getVersion() }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::author') }}</dt>
            <dd>By
                @if($authors = $plugin->getAuthors())
                    <a href="{{ array_get(reset($authors),'homepage', array_get(reset($authors),'email')) }}">
                        {{ reset($authors)['name'] }}
                    </a>
                @endif
            </dd>
            <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
            <dd>plugins/{{ $plugin->getId() }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::pluginDetails') }}</dt>
            <dd><a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}">{{ xe_trans('xe::viewDetails') }}</a></dd>
        </dl>
        <p class="ellipsis">{{ $plugin->getDescription() }}</p>

        @if(array_has($unresolvedComponents, $plugin->getId()))
            <hr>
            <div class="alert alert-warning" role="alert" style="margin-top:10px;">
                <p><i class="xi-info-o txt_red"></i> {{ xe_trans('xe::componentNotRegisteredProperly') }}</p>
                <ul class="list-unstyled">
                    @foreach(array_get($unresolvedComponents, $plugin->getId()) as $cId => $info)
                        {{ $cId }}
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!$plugin->isAllowVersion())
            <hr>
            <!--[D] notice 데이터 알림 관련해서 구조 새롭게 추가 -->
            <!--[D] notice 는 기본, 상황에 맞춰 앞에 바 컬러 노출, 배경색 노출, 닫기 버튼 노출 -->
            <!--[D] is-dissmiss (X 닫기버튼 노출 유무, 공통), 해당 클래스들은 원하는 기능만큼 중복으로 적용해주면 됩니다.
                빨간색 : notice-danger (왼쪽바), notice-danger-bg (박스 배경색)
                노란색 : notice-warning (왼쪽바), notice-warning-bg (박스 배경색)
                녹색 : notice-success (왼쪽바), notice-success-bg (박스 배경색)
            -->
            <!-- [D] 메시지 하단 구조는 제목은 h4, 내용은 p 태그로 적용해주면 됩니다. -->
            <div class="notice notice-warning notice-warning-bg" role="alert">
                <p>
                    {!! xe_trans('xe::pluginRequiredVerHigherThanCurrentCore', ['ver' => preg_replace('/[^0-9\.]/', '', $plugin->requireCoreVersion()), 'action' => '<a href="https://github.com/xpressengine/xpressengine/releases" target="_blank">'.xe_trans('xe::coreUpdate').'</a>']) !!}
                </p>
                <button type="button" class="notice__button-close"><i class="xi-close-thin"></i><span class="sr-only">notice 닫기</span></button>
            </div>
        @endif

        {{-- status info --}}
        {{-- 업데이트가 다운로드 돼 있는 상태 --}}
        @if($plugin->isActivated() && $plugin->needUpdateInstall())
            <form id="update" method="POST" action="{{ route('settings.plugins.update', [$plugin->getId()]) }}" accept-charset="UTF-8" role="form" style="display: inline;">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <div class="alert alert-danger" role="alert">
                    <i class="xi-info-o txt_red"></i>{{ xe_trans('xe::pluginIsChanged') }}
                    <a href="#" onclick="$(this).closest('form').submit();return false;" class="__xe_btn-update-plugin alert-link">{{ xe_trans('xe::applyUpdateNow') }}</a>
                </div>
            </form>
        @endif
    </div>
    <div class="btn-right form-inline">
        @if ($plugin->isActivated())
            <a href="{{ route('settings.plugins.manage.deactivate') }}" class="xe-btn __xe_deactivate_plugin" data-plugin-id="{{ $plugin->getId() }}">{{ xe_trans('xe::deactivation') }}</a>
            @if($plugin->getSettingsURI() !== null)
                <a class="xe-btn xe-btn-positive-outline" href="{{ $plugin->getSettingsURI() }}">{{ xe_trans('xe::settings') }}</a>
            @endif
        @else
            <a href="{{ route('settings.plugins.manage.activate') }}" class="xe-btn xe-btn-positive-outline __xe_activate_plugin" data-plugin-id="{{ $plugin->getId() }}" {{ array_key_exists($plugin->getId(), $handler->getErrors()) ? 'disabled' : '' }}>{{ xe_trans('xe::activation') }}</a>
            <a href="{{ route('settings.plugins.manage.delete') }}" class="xe-btn xe-btn-danger-outline __xe_remove_plugin" data-plugin-id="{{ $plugin->getId() }}">{{ xe_trans('xe::delete') }}</a>
        @endif
        @if($plugin->isPrivate())
            <form id="update" method="POST" action="{{ route('settings.plugins.renew', [$plugin->getId()]) }}" accept-charset="UTF-8" role="form" style="display: inline;">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <button type="submit" class="xe-btn xe-btn-warning-outline">의존성 갱신</button>
            </form>
        @endif
    </div>
</li>
