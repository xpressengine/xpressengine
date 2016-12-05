{{ XeFrontend::css(
[
'/assets/vendor/jqueryui/jquery-ui.min.css',
'/assets/core/lang/langEditorBox.css',
'/assets/core/xe-ui-component/xe-ui-component.css'
]
)->load() }}


{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->before('/assets/core/settings/css/admin.css')->load() }}

{{ XeFrontend::js(
[
'/assets/vendor/jqueryui/jquery-ui.min.js',
'/assets/vendor/expanding/expanding.js',
'/assets/core/lang/langEditorBox.bundle.js'
]
)->appendTo('head')->load() }}

{{ XeFrontend::js('/assets/vendor/nestedSortable/jquery.mjs.nestedSortable.js')->appendTo('head')->load() }}
{{ XeFrontend::js('/assets/core/category/tree.js')->appendTo('head')->load() }}

{{ XeFrontend::translation([
    'xe::required',
    'xe::addItem',
    'xe::create',
    'xe::createChild',
    'xe::edit',
    'xe::unknown',
    'xe::word',
    'xe::description',
    'xe::save',
]) }}

@section('page_title')
    <h2>{{xe_trans('xe::category')}}</h2>
@endsection

@section('page_description')
    {{xe_trans('xe::categoryModifyDescription', ['name' => xe_trans($category->name)])}}
@endsection

<style type="text/css">
    .item.copy{
        background-color: #CAD9EA;
        border: 1px dashed #76AFE8;
    }
</style>

<div id="__xe_category-tree-container">
</div>

<script type="text/javascript">
    $(function () {
        categoryTree.init($('#__xe_category-tree-container'), {
            load: '{{ route('manage.category.edit.item.children', ['id' => $category->id]) }}',
            add: '{{ route('manage.category.edit.item.store', ['id' => $category->id]) }}',
            modify: '{{ route('manage.category.edit.item.update', ['id' => $category->id]) }}',
            remove: '{{ route('manage.category.edit.item.destroy', ['id' => $category->id]) }}',
            move: '{{ route('manage.category.edit.item.move', ['id' => $category->id]) }}'
        });
    });

</script>
