{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->load() }}

{{ XeFrontend::js('/assets/core/common/js/xe.tree.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/menu/SearchHead.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/menu/Menu.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/menu/SiteMap.js')->appendTo('body')->load() }}

@section('page_title',"<h2>".xe_trans('xe::siteMap')."</h2>")
@section('page_description',xe_trans('xe::siteMapDescription'))

<div id="menuContainer"
     class="row"
     data-url="{{ route('settings.menu.index') }}"
     data-home="{{$home}}"
     data-menus='{{ json_encode($menus) }}'
     data-createmenu='{{ route('settings.menu.create.menu') }}'>
</div>