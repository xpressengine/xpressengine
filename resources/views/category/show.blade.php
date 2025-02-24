{{ XeFrontend::css(
[
    '/assets/core/lang/langEditorBox.css',
    '/assets/core/xe-ui-component/xe-ui-component.css'
]
)->load() }}


{{ expose_route('auth.admin') }}
{{ expose_route('media_library.index') }}
{{ expose_route('media_library.drop') }}
{{ expose_route('media_library.get_folder') }}
{{ expose_route('media_library.store_folder') }}
{{ expose_route('media_library.update_folder') }}
{{ expose_route('media_library.move_folder') }}
{{ expose_route('media_library.get_file') }}
{{ expose_route('media_library.update_file') }}
{{ expose_route('media_library.modify_file') }}
{{ expose_route('media_library.move_file') }}
{{ expose_route('media_library.upload') }}
{{ expose_route('media_library.download_file') }}


{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->before('/assets/core/settings/css/admin.css')->load() }}

{{ XeFrontend::js(
[
    '/assets/core/lang/langEditorBox.bundle.js'
]
)->appendTo('head')->load() }}

{{ XeFrontend::js('/assets/core/common/js/xe.tree.js')->appendTo('body')->load() }}
{{ XeFrontend::js('/assets/core/category/Category.js')->appendTo('body')->load() }}

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
    'xe::delete',
    'xe::close',
    'xe::subCategoryDestroy',
    'xe::confirmDelete',
]) }}

@section('page_title')
    <h2>{{xe_trans('xe::category')}}</h2>
@endsection

@section('page_description')
    {{xe_trans('xe::categoryModifyDescription', ['name' => xe_trans($category->name)])}}
@endsection

<div id="__xe_category-tree-container" class="panel board-category">
</div>

<script type="text/javascript">
    $(function () {
        Category.init({
            load: '{{ route('manage.category.edit.item.children', ['id' => $category->id]) }}',
            add: '{{ route('manage.category.edit.item.store', ['id' => $category->id]) }}',
            modify: '{{ route('manage.category.edit.item.update', ['id' => $category->id]) }}',
            remove: '{{ route('manage.category.edit.item.destroy', ['id' => $category->id, 'force' => false]) }}',
            removeAll: '{{ route('manage.category.edit.item.destroy', ['id' => $category->id, 'force' => true]) }}',
            move: '{{ route('manage.category.edit.item.move', ['id' => $category->id]) }}',
            dynamicForm: '{{ route('manage.category_item.dynamic_fields.form', ['id' => $category->getKey()]) }}'
        });
    });
</script>
