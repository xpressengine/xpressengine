<div class="xe-modal-body">
    <div class="xe-modal fade in admin-layer-popup admin-layer-popup--full-page-inner-scroll admin-layer-popup--plugin" style="display: block">
        <div class="admin-layer-popup-content">
            <div class="admin-layer-popup-header">
                <h3 class="blind">테마, 익스텐션 플러그인 상세보기 레이어팝업</h3>
                <div class="admin-layer-popup-plugin__title-box">
                    <div class="admin-layer-popup-plugin__thumb" style="background-image: url({{$storePluginItem->icon_url}})"></div>
                    <h3 class="admin-layer-popup-plugin__title">{{$storePluginItem->title . ' v' . $storePluginItem->latest_release->version}}</h3>
                </div>
                <p class="admin-layer-popup-plugin__title-sub-text">{{$storePluginItem->latest_release->description}}</p>
                <div class="admin-layer-popup-plugin__button-box">
                    <button type="button" class="xu-button xu-button--default admin-button--complete">{{xe_trans('xe::installed')}}</button>
                    @if ($pluginEntity != null)
                        @if ($pluginEntity->isActivated() == true)
                            <a href="{{ route('settings.plugins.manage.deactivate') }}" class="xu-button xu-button--default admin-button--disabled __xe_deactivate_plugin" data-plugin-id="{{ $pluginEntity->getId() }}">{{ xe_trans('xe::deactivation') }}</a>
                        @else
                            <a href="{{ route('settings.plugins.manage.activate') }}" class="xu-button xu-button--default admin-button--active __xe_activate_plugin" data-plugin-id="{{ $pluginEntity->getId() }}">{{ xe_trans('xe::activation') }}</a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="admin-layer-popup-body">
                <iframe src="{{'https://store.xehub.io/plugins/' . $storePluginItem->plugin_id . '/iframe'}}" id="iframeStore" class="admin-layer-popup__iframe" width="100%" height="100%"></iframe>
            </div>
            <div class="admin-layer-popup-footer">
                <button type="button" class="xu-button xu-button--default __close-layer-popup">{{xe_trans('xe::close')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.__close-layer-popup').click(function() {
        $('.admin-layer-popup--plugin').css('display', 'none');
    });
</script>
