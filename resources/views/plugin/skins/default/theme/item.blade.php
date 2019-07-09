@php
    $themeEntity = $pluginHandler->getPlugin(data_get($theme, 'plugin_id'));
@endphp
<li @if ($themeEntity != null && $themeEntity->isActivated()) class="active" @endif>
    <a  href="{{route('settings.theme.detail', ['pluginName' => $theme->name])}}" data-toggle="xe-page-modal" class="list-card__link">
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
                    <button type="button" class="xu-button xu-button--default admin-button--preview">미리보기</button>
                    <button type="button" class="xu-button xu-button--default admin-button--disabled">비활성화</button>
                @else
                    <button type="button" class="xu-button xu-button--default admin-button--active">활성화</button>
                @endif
            @else
                @if(data_get($theme, 'is_purchased'))
                    <button class="plugin-install xu-button xu-button--primary" data-target="{{$theme->plugin_id}}">{{ xe_trans('xe::installNow') }}</button>
                @elseif(data_get($theme, 'is_free') === false)
                    <a href="{{ data_get($theme, 'link') }}" class="btn-link" target="_blank">{{ xe_trans('xe::goToBuy') }}</a>
                @else
                    <button type="button" class="plugin-install xu-button xu-button--primary" data-target="{{$theme->plugin_id}}">{{ xe_trans('xe::installNow') }}</button>
                @endif
            @endif
        </div>
    </div>
</li>
