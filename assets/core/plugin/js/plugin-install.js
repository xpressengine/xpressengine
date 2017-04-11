$(document).ready(function () {

  $(document).on('submit', 'form[data-submit=xe-plugin-items]', function (e) {
    e.preventDefault();

    var $this = $(this);

    // XE.ajax({
    //   url: $this.attr('action'),
    //   type: $this.attr('method'),
    //   data: $this.serialize(),
    //   dataType: 'json',
    //   success: function (data, textStatus, jqXHR) {
    //     XE.page();
    //   },
    // });

    XE.page($this.attr('action'), '.__xe_plugin_items', {
        data: $this.serialize(),
    })

  });

  $(document).on('click', '.__xe_plugin_items_link a', function (e) {
    e.preventDefault();

    XE.page(this.href, '.__xe_plugin_items');

  })
});
