@if ($config == null)
	<script>
		var storeCategory = function(obj) {
			var params = {},
					id = $(obj).closest('form').find('[name="id"]').val();

			if (id == '') {
				System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
					griper.form($(obj), '아이디 입력 후 생성 가능합니다.');
				});
				return;
			} else {
				System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
					griper.form.fn.clear($(obj).closest('form'));
				});
			}

			params['categoryName'] = id;

			XE.ajax({
				type: 'post',
				dataType: 'json',
				data: params,
				url: '{{route('fieldType.storeCategory')}}',
				success: function(data) {
					var section = $(obj).closest('.__xe_df_category');
					section.find('[name="categoryId"]').val(data.id);
					section.find('button').hide();
					section.append(
							$('<a>').text('카테고리 관리').prop('target', '_blank').prop('href', '/settings/category/'+data.id)
					);
				}
			});
		}
	</script>
@endif

<div class="form-group __xe_df_category">
	<input type="hidden" name="categoryId" value="{{ $config != null ? $config->get('categoryId') : '' }}" />
	@if ($config == null)
		<button type="button" onclick="storeCategory(this)">카테고리 그룹 생성</button>
	@else
		<a href="{{ route('manage.category.show', ['id' => $config->get('categoryId')]) }}" target="_blank">카테고리 관리</a>
	@endif
</div>
