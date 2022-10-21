{{ XeFrontend::css([
    '/assets/core/lang/langEditorBox.css',
    '/assets/core/xe-ui-component/xe-ui-component.css'
])->load() }}

{{ XeFrontend::css('/assets/core/settings/css/admin_menu.css')->before('/assets/core/settings/css/admin.css')->load() }}

{{ XeFrontend::js([
    '/assets/core/lang/langEditorBox.bundle.js'
])->appendTo('head')->load() }}

{{ XeFrontend::js([
    '/assets/core/common/js/xe.tree.js',
    '/assets/core/category/Category.js'
])->appendTo('body')->load() }}

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
    <h2>{{ xe_trans('xe::categoryManagement') }}</h2>
@endsection

<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">카테고리 관리<small>{{ count($categories) }} 개의 카테고리가 존재합니다.</small></h3>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">카테고리명</th>
                                <th width="10%" scope="col">개수</th>
                                <th width="10%" scope="col">{{ xe_trans('xe::management') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ xe_trans($category->name) }}</td>
                                        <td>{{ $category->count }}</td>
                                        <td><a href="{{ route('manage.category.show', $category->id) }}" class="btn btn-default">{{ xe_trans('xe::management') }}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>















