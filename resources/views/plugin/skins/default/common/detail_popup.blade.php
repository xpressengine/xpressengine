
<div class="admin-layer-plugin-popup admin-layer-plugin-popup--plugin" style="display: block">
    <div class="admin-layer-plugin-popup-content">
        <div class="admin-layer-plugin-popup-header">
            <h3 class="blind">테마, 익스텐션 플러그인 상세보기 레이어팝업</h3>
            <div class="admin-layer-plugin-popup-plugin__title-box">
                <div class="admin-layer-plugin-popup-plugin__thumb" style="background-image: url({{$storePluginItem->icon_url}})"></div>
                <h3 class="admin-layer-plugin-popup-plugin__title">{{$storePluginItem->title . ' v' . $storePluginItem->latest_release->version}}</h3>
            </div>
            <p class="admin-layer-plugin-popup-plugin__title-sub-text">{{$storePluginItem->latest_release->description}}</p>
            <div class="admin-layer-plugin-popup-plugin__button-box">
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
        <div class="admin-layer-plugin-popup-body">
            <iframe src="{{'https://store.xehub.io/plugins/' . $storePluginItem->plugin_id . '/iframe'}}" id="iframeStore" class="admin-layer-plugin-popup__iframe" width="100%" height="100%"></iframe>
        </div>
        <div class="admin-layer-plugin-popup-footer">
            <button type="button" class="xu-button xu-button--default __close-layer-popup" data-dismiss="xe-modal">{{xe_trans('xe::close')}}</button>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // XE.pageModal 팝업 사이즈 컨트롤 하기 위해 클래스 추가
        $('.xe-modal').addClass('popup-plugin-modal');
    });
</script>
