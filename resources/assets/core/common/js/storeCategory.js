// @FIXME 적당한 곳으로 이동

import $ from 'jquery'
import griper from 'xe-common/griper' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import XE from 'xe'

window.jQuery('#btnCreateCategory').on('click', (e) => {
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

  XE.post('fieldType.storeCategory', params)
    .then(function success (response) {
      var section = $(_this).closest('.__xe_df_category')
      section.find('[name="category_id"]').val(response.data.id)
      section.find('button').hide()
      section.append($('<a>')
        .text(XE.Lang.trans('xe::categoryManagement'))
        .prop('target', '_blank')
        .prop('href', '/settings/category/' + response.data.id))
    })
})
