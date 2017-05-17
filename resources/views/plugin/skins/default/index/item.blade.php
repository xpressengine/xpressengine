<li class="list-group-item @if( ! $plugin->isActivated() )off @endif">
    <div class="text-right">
        <input type="checkbox" value="{{ $plugin->getId() }}" class="__xe_checkbox">
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

        {{-- status info --}}
        {{-- 업데이트가 다운로드 돼 있는 상태 --}}
        @if($plugin->needUpdateInstall() && $plugin->isActivated())
            <div class="alert alert-danger" role="alert">
                <i class="xi-info-o txt_red"></i>{{ xe_trans('xe::newUpdateDownloaded') }}
                <a href="#" data-url="{{ route('settings.plugins.update', [$plugin->getId()]) }}" class="__xe_btn-update-plugin alert-link">{{ xe_trans('xe::applyUpdateNow') }}</a>
            </div>
        @elseif($plugin->hasUpdate())
            <div class="alert alert-danger" role="alert">
                <i class="xi-info-o"></i>{{ xe_trans('xe::hasNewUpdate') }}
                <a href="{{ $plugin->getStoreLink() }}" class="alert-link" target="_blank">{{ xe_trans('xe::version') }} {{ $plugin->getLatestVersion() }} {{ xe_trans('xe::details') }}</a> {{ xe_trans('xe::or') }} <a href="{{ route('settings.plugins.show', [$plugin->getId()]) }}" class="alert-link">{{ xe_trans('xe::update_plugin') }}</a>
            </div>
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
