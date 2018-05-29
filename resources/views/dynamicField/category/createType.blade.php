@if ($config == null)
    @expose_route('fieldType.storeCategory')
    @expose_trans('xe::categoryManagement')
    {{ XeFrontend::js('/assets/core/common/js/storeCategory.js')->loadAsync() }}
@endif

<div class="form-group __xe_df_category">
	<input type="hidden" name="category_id" value="{{ $config != null ? $config->get('category_id') : '' }}" />
	@if ($config == null)
		<button type="button" id="btnCreateCategory">{{xe_trans('xe::createCategoryGroup')}}</button>
	@else
		<a href="{{ route('manage.category.show', ['id' => $config->get('category_id')]) }}" target="_blank">{{xe_trans('xe::categoryManagement')}}</a>
	@endif
</div>
