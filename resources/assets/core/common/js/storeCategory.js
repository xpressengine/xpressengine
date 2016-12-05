import griper from 'griper';

var storeCategory = function (obj) {
  var params = {};
  var id = $(obj).closest('form').find('[name="id"]').val();

  if (id == '') {
    griper.form($(obj), 'You must first create a category ID.');

    return;
  } else {
    griper.form.fn.clear($(obj).closest('form'));
  }

  params.categoryName = id;

  XE.ajax({
    type: 'post',
    dataType: 'json',
    data: params,
    url: storeCategory.url,
    success: function (data) {
      var section = $(obj).closest('.__xe_df_category');
      section.find('[name="categoryId"]').val(data.id);
      section.find('button').hide();
      section.append(
       $('<a>').text(storeCategory.text).prop('target', '_blank').prop('href', '/settings/category/' + data.id)
     );
    },
  });
};
