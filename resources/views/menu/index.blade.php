{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->load() }}
{{--{{ XeFrontend::js('/assets/vendor/vendor.bundle.js')->appendTo('head')->load() }}--}}
{{ XeFrontend::js('/assets/vendor/lodash/lodash.min.js')->appendTo('head')->load() }}
{{--{{ XeFrontend::js('/assets/core/menu/Tree.js')->appendTo('head')->load() }}--}}
{{--{{ XeFrontend::js('/assets/core/menu/classnames.js')->appendTo('head')->load() }}--}}
{{--{{ XeFrontend::js('/assets/core/menu/menu.bundle.js')->appendTo('head')->load() }}--}}

{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.sortable.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/vendor/nestedSortable/jquery.mjs.nestedSortable.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/tree/SearchHead.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/tree/Menu.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/tree/Item.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/tree/Tree.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/tree/SiteMap.js')->appendTo('body')->load() }}

@section('page_title',"<h2>".xe_trans('xe::siteMap')."</h2>")
@section('page_description',xe_trans('xe::siteMapDescription'))
<script>
    var Keys = {
        ENTER: 13,
        TAB: 9,
        BACKSPACE: 8,
        UP_ARROW: 38,
        DOWN_ARROW: 40,
        ESCAPE: 27
    };
    var SiteKey = '{{ $siteKey }}';
    var MaxDepth = parseInt('{{ $maxDepth }}');
    var nodeLeftPadding = 48;
</script>
<style type="text/css">
    .search-list {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .open .search-list {
        display: block;
    }

    .search-list ul {
        min-width: 160px;
        padding: 5px 0;
        margin: 2px 0 0;
        list-style: none;
        font-size: 14px;
        text-align: left;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 2px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
        background-clip: padding-box;
    }

    .search-list li a {
        position: relative;
        display: block;
        padding: 5px 20px;
        line-height: 1.42857;
        color: #333;
        white-space: nowrap;
        clear: both;
    }

    .search-list li a:hover, .search-list li a:focus {
        text-decoration: none;
        color: #262626;
        background-color: #f5f5f5;
    }

    .search-list li em {
        font-weight: bold;
        font-style: normal;
    }
    .search-list .on a, .search-list .on a:hover, .search-list .on a:focus {
        color: #fff;
        text-decoration: none;
        outline: 0;
        background-color: #6F8DFF;
    }


</style>
<div class="row" id="menuContainer" data-url="{{ route('settings.menu.index') }}" data-home="{{$home}}" data-menus='{{ json_encode($menus) }}' data-createmenu='{{ route('settings.menu.create.menu') }}'>
</div>