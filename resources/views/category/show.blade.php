
{{ Frontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load() }}

{{ Frontend::css('/assets/core/common/category/style.css')->load() }}

{{ Frontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load() }}
{{ Frontend::js('/assets/vendor/nestedSortable/jquery.mjs.nestedSortable.js')->appendTo('head')->load() }}
{{ Frontend::js('/assets/core/common/category/tree.js')->appendTo('head')->load() }}

{{ Frontend::translation([
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
