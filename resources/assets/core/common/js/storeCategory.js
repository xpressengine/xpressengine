// @FIXME 적당한 곳으로 이동

import $ from 'jquery'
import griper from 'xe-common/griper' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import XE from 'xe'

$('#btnCreateCategory').on('click', (e) => {
  var _this = e.target
  var id = $(_this).closest('form').find('[name="id"]').val()
  var params = {}

  if (!id) {
    griper.form($(_this), 'You must first create a category ID.') // @FIXME

    return
  } else {
    griper.form.fn.clear($(_this).closest('form'))
  }

  params.categoryName = id

  XE.ajax({
    type: 'post',
    dataType: 'json',
    data: params,
    url: window.storeCategoryInfo.url, // @FIXME
    success: function (data) {
      var section = $(_this).closest('.__xe_df_category')
      section.find('[name="category_id"]').val(data.id)
      section.find('button').hide()
      section.append(
        $('<a>').text(window.storeCategoryInfo.text).prop('target', '_blank').prop('href', '/settings/category/' + data.id)
      )
    }
  })
})
