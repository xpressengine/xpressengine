@if ($config == null)
	<script>
		var storeCategoryInfo = {
			url: "{{route('fieldType.storeCategory')}}",
			text: "{{xe_trans('xe::categoryManagement')}}"
		};

		DynamicLoadManager.jsLoad('/assets/core/common/js/storeCategory.js');
	</script>
@endif

<div class="form-group __xe_df_category">
	<input type="hidden" name="categoryId" value="{{ $config != null ? $config->get('categoryId') : '' }}" />
	@if ($config == null)
		<button type="button" id="btnCreateCategory">{{xe_trans('xe::createCategoryGroup')}}</button>
	@else
		<a href="{{ route('manage.category.show', ['id' => $config->get('categoryId')]) }}" target="_blank">{{xe_trans('xe::categoryManagement')}}</a>
	@endif
</div>
