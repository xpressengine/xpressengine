{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->load() }}

<div class="container-fluid container-fluid--part">
    <div id="menuContainer"
        class="row"
        data-url="{{ route('settings.menu.index') }}"
        data-home="{{$home}}"
        data-menus='{{ json_encode($menus) }}'
        data-createmenu='{{ route('settings.menu.create.menu') }}'>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", function () {
        XE.DynamicLoadManager.jsLoadMultiple([
            "/assets/core/common/js/xe.tree.js",
            "/assets/core/menu/SearchHead.js",
            "/assets/core/menu/Menu.js",
            "/assets/core/menu/SiteMap.js"], {
            complete: function () {
            }
        })
    });
</script>
