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
                        {{ '@'.reset($authors)['name'] }}
                    </a>
                @endif
            </dd>
            <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
            <dd>plugins/{{ $plugin->getId() }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::pluginDetails') }}</dt>
            <dd><a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}">상세보기</a></dd>
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
        @if ($plugin->isActivated() == true)
            <button type="button" class="xe-btn __xe_self_deactivate_plugin">비활성화</button>
        @else
            <form method="post" action="{{ route('settings.plugins.manage.activate') }}" class="form-inline">
                {!! csrf_field() !!}
                <input type="hidden" name="pluginId" value="{{ $plugin->getId() }}">
                <button type="submit" class="xe-btn xe-btn-positive-outline">활성화</button>
            </form>
        @endif

        @if($plugin->isActivated() && ($plugin->getSettingsURI() !== null) )
            <a class="xe-btn xe-btn-positive-outline" href="{{ $plugin->getSettingsURI() }}">{{ xe_trans('xe::settings') }}</a>
        @endif
    </div>
</li>
