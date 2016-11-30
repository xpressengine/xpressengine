{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->load() }}
{{--{{ XeFrontend::js('/assets/vendor/vendor.bundle.js')->appendTo('head')->load() }}--}}
{{ XeFrontend::js('/assets/vendor/lodash/lodash.min.js')->appendTo('head')->load() }}
{{ XeFrontend::js('/assets/core/menu/Tree.js')->appendTo('head')->load() }}
{{ XeFrontend::js('/assets/core/menu/classnames.js')->appendTo('head')->load() }}
{{ XeFrontend::js('/assets/core/menu/menu.bundle.js')->appendTo('head')->load() }}

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
<div class="row" id="menuContainer" data-url="{{ route('settings.menu.index') }}" data-home="{{$home}}" data-menus='{!! json_encode($menus) !!}' data-createmenu='{{ route('settings.menu.create.menu') }}'>
</div>