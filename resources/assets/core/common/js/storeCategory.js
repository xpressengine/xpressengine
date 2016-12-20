import griper from 'griper';

$('#btnCreateCategory').on('click', (e) => {
  var _this = e.target;
  var id = $(_this).closest('form').find('[name="id"]').val();
  var params = {};

  if (!id) {
    griper.form($(_this), 'You must first create a category ID.');

    return;
  } else {
    griper.form.fn.clear($(_this).closest('form'));
  }

  params.categoryName = id;

  XE.ajax({
    type: 'post',
    dataType: 'json',
    data: params,
    url: storeCategoryInfo.url,
    success: function (data) {
      var section = $(_this).closest('.__xe_df_category');
      section.find('[name="categoryId"]').val(data.id);
      section.find('button').hide();
      section.append(
        $('<a>').text(storeCategoryInfo.text).prop('target', '_blank').prop('href', '/settings/category/' + data.id)
      );
    },
  });
});
