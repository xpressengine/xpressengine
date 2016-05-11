$(document).ready(function(){
  var xe_select = $(".xe-select-box select");
  xe_select.change(function () {
      var select_name = $(this).children("option:selected").text();
      $(this).siblings("label").text(select_name);
  });

  $(document).on('click', function(event) {
      var $target = $(event.target);
      $selectLabel = $target.parents('.xe-select-label');

      if ($selectLabel.length !== 0) {

          var $labellist = $($target).next('.label-list');

          if ($labellist.is(':visible')) {
              $selectLabel.removeClass('open');
          } else {
              $('.xe-select-label.open').removeClass('open');
              $selectLabel.addClass('open');
          }
      } else {
          $('.xe-select-label').removeClass('open')
      }
  });

});
