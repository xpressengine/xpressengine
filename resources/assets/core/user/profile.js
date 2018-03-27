$(function ($) {
  var $box = $('.__xe_profileBox')
  var $editBtn = $('.__xe_profileEditBtn')
  var $saveBtn = $('.__xe_profileSaveBtn')
  var $cancelBtn = $('.__xe_profileEditCancelBtn')
  var $imgUploadBox = $('.__xe_imgUploadBox')
  var $nameInput = $('.__xe_nameInput')
  var $introView = $('.__xe_introView')
  var $introInput = $('.__xe_introInput')

  $editBtn.click(function () {
    $box.addClass('edit')
    $saveBtn.show()
    $cancelBtn.show()
    $editBtn.hide()
    $imgUploadBox.show()
    $nameInput.removeAttr('readonly').focus()
    $introView.hide()
    $introInput.show()
    return false
  })

  $cancelBtn.click(function () {
    $box.removeClass('edit')
    $saveBtn.hide()
    $cancelBtn.hide()
    $editBtn.show()
    $imgUploadBox.hide()
    $nameInput.attr('readonly', 'readonly')
    $introView.show()
    $introInput.hide()
    return false
  })
})
