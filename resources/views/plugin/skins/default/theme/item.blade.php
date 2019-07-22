@php
    $themeEntity = $pluginHandler->getPlugin(data_get($theme, 'plugin_id'));
@endphp
<li @if ($themeEntity != null && $themeEntity->isActivated()) class="active" @endif>
    <a href="{{route('settings.plugins.detail', ['pluginName' => data_get($theme, 'plugin_id')])}}" data-toggle="xe-page-modal">
        <span class="blind">카드 이미지</span>
        <div class="list-card__image">
            <div class="list-card__image-content" style="background-image: url({{$theme->icon}})"></div>
        </div>
        <div class="list-card__search-icon">
            <i class="xi-search"></i>
        </div>
        <div class="list-card-info">
            <div class="list-card-info__title-box">
                <p class="list-card-info__title">{{ $theme->title }}</p>
                @if ($theme->price > 0)
                    <span class="list-card-info__price">{{'￦ ' . number_format($theme->price) }}</span>
                @endif
            </div>
            <div class="list-card-info__sub-text-box">
                <span class="list-card-info__sub-text">{{ $theme->author }}</span>
                <span class="list-card-info__sub-text">{{ $theme->category_titles[0] }}</span>
            </div>
        </div>
    </a>
    <div class="list-card-footer">
        <div class="list-card-download">
            <i class="xi-download"></i>
            <span class="list-card-download__text">{{ number_format($theme->downloadeds) }}</span>
        </div>
        <div class="list-card-button-box">
            @if ($themeEntity != null)
                @if ($themeEntity->isActivated() == true)
                    <a href="{{ route('settings.plugins.manage.deactivate') }}" class="xu-button xu-button--default admin-button--disabled __xe_deactivate_plugin" data-plugin-id="{{ $themeEntity->getId() }}">{{ xe_trans('xe::deactivation') }}</a>
                @else
                    <a href="{{ route('settings.plugins.manage.activate') }}" class="xu-button xu-button--default admin-button--active __xe_activate_plugin" data-plugin-id="{{ $themeEntity->getId() }}">{{ xe_trans('xe::activation') }}</a>
                @endif
            @else
                @if(data_get($theme, 'is_purchased'))
                    <button class="plugin-install xu-button xu-button--primary" data-target="{{$theme->plugin_id}}">{{ xe_trans('xe::installNow') }}</button>
                @elseif(data_get($theme, 'is_free') === false)
                    <a href="{{ data_get($theme, 'link') }}" class="btn-link xu-button xu-button--primary" target="_blank">{{ xe_trans('xe::buying') }}</a>
                @else
                    <button class="plugin-install xu-button xu-button--primary" data-target="{{$theme->plugin_id}}">{{ xe_trans('xe::installNow') }}</button>
                @endif
            @endif
        </div>
    </div>
</li>
