window.jQuery(function ($) {
  $('.skin-setting-list .__xe_assign-btn').click(function () {
    var $btn = $(this)
    var url = $btn.data('skinAssignLink')
    XE.ajax({
      type: 'put',
      url: url,
      dataType: 'json',
      success: function (data) {
        window.XE.toast(data.type, data.message)
        var type = $btn.data('skinType')
        if (type == 'desktop') {
          $btn.parents('.skin-setting-list').find('.__xe_skin-desktop').removeClass('on')
        } else {
          $btn.parents('.skin-setting-list').find('.__xe_skin-mobile').removeClass('on')
        }

        $btn.addClass('on')
      },

      error: function (data) {
        window.XE.toast(data.type, data.message)
      }
    })
  })

  // $('.skin-setting-list .__xe_skin-setting-btn').click(function(){
  //   var url = $(this).data('url');
  //   modalPage(url)
  // })

  $(document).on('submit', 'form.__xe_skin_form', function (e) {
    e.preventDefault()

    var $form = $(this)
    var $modal = $(this).closest('.xe-modal')

    var fileList = []
    $('input:file', this).each(function (i, dom) {
      if ($(dom).val()) {
        fileList.push($(dom).val())
      }
    })

    if (fileList.length > 0) {
      $form
        .fileupload({
          url: $form.attr('action'),
          singleFileUploads: false
        })
        .on('fileuploaddone', function (e, data) {
          data = data.result

          $modal.xeModal('hide')
          window.XE.toast(data.type, data.message)
        })
        .fileupload('send', { fileInput: $('input:file', this) })
    } else {
      XE.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        cache: false,
        data: $form.serialize(),
        dataType: 'json',
        success: function (data) {
          $modal.xeModal('hide')
          window.XE.toast(data.type, data.message)
        },

        error: function (data) {
          window.XE.toast(data.type, data.message)
        }
      })
    }
  })

  function modalPage (url, callback) {
    var $modal = $('#skinModal')
    XE.ajax({
      url: url,
      type: 'get',
      dataType: 'json',
      success: function (data) {
        $modal.find('.modal-content').empty().html(data.view)
        $modal.xeModal()
        if (callback) {
          callback(data)
        }
      }
    })
  }
})
