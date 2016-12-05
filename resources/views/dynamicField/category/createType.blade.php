@if ($config == null)
	<script>
		var storeCategory = {
			url: "{{route('fieldType.storeCategory')}}",
			text: "{{xe_trans('xe::categoryManagement')}}"
		};
	</script>
	{{ XeFrontend::js('/assets/core/common/js/storeCategory.js')->load() }}
@endif

<div class="form-group __xe_df_category">
	<input type="hidden" name="categoryId" value="{{ $config != null ? $config->get('categoryId') : '' }}" />
	@if ($config == null)
		<button type="button" onclick="storeCategory(this)">{{xe_trans('xe::createCategoryGroup')}}</button>
	@else
		<a href="{{ route('manage.category.show', ['id' => $config->get('categoryId')]) }}" target="_blank">{{xe_trans('xe::categoryManagement')}}</a>
	@endif
</div>
