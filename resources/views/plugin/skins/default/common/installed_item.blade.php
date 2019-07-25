<li class="list-group-item @if (!$item->isActivated()) off @endif ">
    <div class="list-group-item-checkbox">
        <label class="xe-label">
            <input type="checkbox" value="{{ $item->getId() }}" class="__xe_checkbox">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text xe-sr-only">체크박스</span>
        </label>
    </div>

    <div class="left-group">
        <span class="plugin-title">{{ $item->getTitle() }}</span>
        <dl>
            <dt class="sr-only">version</dt>
            <dd>Version {{ $item->getVersion() }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::author') }}</dt>
            <dd>By
                @if($authors = $item->getAuthors())
                    <a href="{{ array_get(reset($authors),'homepage', array_get(reset($authors),'email')) }}" target="_blank">
                        {{ reset($authors)['name'] }}
                    </a>
                @endif
            </dd>
            <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
            <dd>plugins/{{ $item->getId() }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::pluginDetails') }}</dt>
            <dd><a href="{{ route('settings.plugins.show', [$item->getId()]) }}">{{ xe_trans('xe::viewDetails') }}</a></dd>
        </dl>
        <p class="ellipsis">{{ $item->getDescription() }}</p>

        @if(array_has($unresolvedComponents, $item->getId()))
            <hr>
            <div class="alert alert-warning" role="alert" style="margin-top:10px;">
                <p><i class="xi-info-o txt_red"></i> {{ xe_trans('xe::componentNotRegisteredProperly') }}</p>
                <ul class="list-unstyled">
                    @foreach(array_get($unresolvedComponents, $item->getId()) as $cId => $info)
                        {{ $cId }}
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!$item->isAllowVersion())
            <hr>
            <div class="notice notice-warning notice-warning-bg" role="alert">
                <p>
                    {!! xe_trans('xe::pluginRequiredVerHigherThanCurrentCore', ['ver' => preg_replace('/[^0-9\.]/', '', $item->requireCoreVersion()), 'action' => '<a href="https://github.com/xpressengine/xpressengine/releases" target="_blank">'.xe_trans('xe::coreUpdate').'</a>']) !!}
                </p>
                <button type="button" class="notice__button-close"><i class="xi-close-thin"></i><span class="sr-only">notice 닫기</span></button>
            </div>
        @endif

        @if($item->isActivated() && $item->needUpdateInstall())
            <form id="update" method="POST" action="{{ route('settings.plugins.update', [$item->getId()]) }}" accept-charset="UTF-8" role="form" style="display: inline;">
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
        @if ($item->isActivated())
            <a href="{{ route('settings.plugins.manage.deactivate') }}" class="xe-btn __xe_deactivate_plugin" data-plugin-id="{{ $item->getId() }}">{{ xe_trans('xe::deactivation') }}</a>
            @if($item->getSettingsURI() !== null)
                <a class="xe-btn xe-btn-positive-outline" href="{{ $item->getSettingsURI() }}">{{ xe_trans('xe::settings') }}</a>
            @endif
        @else
            <a href="{{ route('settings.plugins.manage.activate') }}" class="xe-btn xe-btn-positive-outline __xe_activate_plugin" data-plugin-id="{{ $item->getId() }}" {{ array_key_exists($item->getId(), $handler->getErrors()) ? 'disabled' : '' }}>{{ xe_trans('xe::activation') }}</a>
            <a href="{{ route('settings.plugins.manage.delete') }}" class="xe-btn xe-btn-danger-outline __xe_remove_plugin" data-plugin-id="{{ $item->getId() }}">{{ xe_trans('xe::delete') }}</a>
        @endif
        @if($item->isPrivate())
            <form id="update" method="POST" action="{{ route('settings.plugins.renew', [$item->getId()]) }}" accept-charset="UTF-8" role="form" style="display: inline;">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <button type="submit" class="xe-btn xe-btn-warning-outline">{{xe_trans('xe::dependenciesUpdate')}}</button>
            </form>
        @endif
    </div>
</li>
