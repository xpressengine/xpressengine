{{ XeFrontend::css(
[
'/assets/vendor/jqueryui/jquery-ui.css',
'/assets/core/lang/LangEditorBox.css',
'/assets/core/lang/flag.css'
]
)->load() }}

{{ XeFrontend::css('/assets/core/category/style.css')->load() }}

{{ XeFrontend::js(
[
'/assets/vendor/jqueryui/jquery-ui.js',
'/assets/vendor/expanding/expanding.js',
'/assets/core/lang/LangEditorBox.js'
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
    <h2>카테고리</h2>
@endsection

@section('page_description')
    {{ $category->name }} 을(를) 수정합니다.
@endsection


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
