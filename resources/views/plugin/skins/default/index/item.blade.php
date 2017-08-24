<li class="list-group-item @if( ! $plugin->isActivated() )off @endif">
    <div class="list-group-item-checkbox">
        <label class="xe-label">
            <input type="checkbox" value="{{ $plugin->getId() }}" class="__xe_checkbox">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text xe-sr-only">체크박스</span>
        </label>
    </div>
    <div class="left-group">
        <a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}" class="plugin-title">{{ $plugin->getTitle() }}</a>
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
        </dl>
        <p class="ellipsis">{{ $plugin->getDescription() }}</p>
        {{-- component list --}}
        @foreach($componentTypes as $type => $typeText)
            @foreach($plugin->getComponentList($type) as $key => $component)
                <span class="label label-{{ $color[$type] }}" title="{{ $component['name'] }}" data-toggle="tooltip">{{ $type }}</span>
            @endforeach
        @endforeach

        @if(array_has($unresolvedComponents, $plugin->getId()))
            <hr>
            <div class="alert alert-warning" role="alert" style="margin-top:10px;">
                <p><i class="xi-info-o txt_red"></i> 정상적으로 등록되지 않은 컴포넌트가 있습니다. XE가 정상적으로 작동하지 않을 수 있습니다.</p>
                <ul class="list-unstyled">
                    @foreach(array_get($unresolvedComponents, $plugin->getId()) as $cId => $info)
                        {{ $cId }}
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- status info --}}
        {{-- 업데이트가 다운로드 돼 있는 상태 --}}
        @if($plugin->needUpdateInstall() && $plugin->isActivated())
            <div class="alert alert-danger" role="alert">
                <i class="xi-info-o txt_red"></i>{{ xe_trans('xe::pluginIsChanged') }}
                <a href="#" data-url="{{ route('settings.plugins.update', [$plugin->getId()]) }}" class="__xe_btn-update-plugin alert-link">{{ xe_trans('xe::applyUpdateNow') }}</a>
            </div>
        @endif
    </div>
    <div class="btn-right">
        @if($plugin->isActivated() && ($plugin->getSettingsURI() !== null) )
            <a class="btn-link"
               href="{{ $plugin->getSettingsURI() }}">{{ xe_trans('xe::settings') }}</a>
        @endif
    </div>
</li>
