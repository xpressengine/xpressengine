// 컴포넌트 기본 동작 스크립트 (임시)
$(function () {
  // 드롭다운 버튼 클릭 시 동작 (dropdown)
  $('body').bind('click', function (e) {
    var $target = $(e.target)

    // 드롭다운 버튼 영역 - 드롭다운 클릭하는 영역에 data-toggle="xu-dropdown" 값 적용 되어있음 (컴포넌트 버튼은 class="xu-button--selected" 적용 필요)
    var dataToggle = $target.closest('[data-toggle]')
    if (dataToggle.length > 0) {
      if(dataToggle.siblings('.xu-dropdown-menu').hasClass('xu-dropdown-menu--show')) {
        // 이미 선택된 버튼을 다시 클릭 했을 때
        $('[data-toggle]').removeClass('xu-button--selected')
        $('[data-toggle]').siblings().removeClass('xu-dropdown-menu--show')
      } else {
        // 이미 선택 후 다른 버튼을 클릭 했을 때
        $('[data-toggle]').removeClass('xu-button--selected')
        $('[data-toggle]').siblings().removeClass('xu-dropdown-menu--show')

        // 버튼이라면 class="xu-button--selected" 컨트롤
        if(dataToggle.attr('data-toggle') == 'xu-dropdown') {
          if(dataToggle.hasClass('xu-button')) {
            dataToggle.addClass('xu-button--selected')
          }
          dataToggle.siblings('.xu-dropdown-menu').addClass('xu-dropdown-menu--show')
        }
      }
    } else {
      $('[data-toggle]').removeClass('xu-button--selected')
      $('[data-toggle]').siblings().removeClass('xu-dropdown-menu--show')
    }
  })

  // 버튼 Radio button group (라디오 버튼 클릭시 버튼 변경만 적용)
  $('.xu-button-group--radio .xu-button').click(function() {
    $(this).closest('.xu-button-group--radio').find('.xu-button').removeClass('xu-button--selected')
    $(this).addClass('xu-button--selected')
  })

  // 패스워드 보기, 안보기 버튼 기능
  passwordViewButton()
});

// 패스워드 보기, 안보기 버튼 기능
function passwordViewButton () {
  $('[data-password]').on('click', function() {
    var inputPassword = $(this).siblings('input')
    var passwordIcon = $(this).find('i').attr('class');
    var strType = '';

    if($(this).attr('data-password') == 'xu-password') {
      strType = 'text';
    } else if($(this).attr('data-password') == 'xu-text'){
      strType = 'password';
    }

    if(passwordIcon == 'xi-eye') {
      $(this).find('i').removeClass().addClass('xi-eye-off');
    } else {
      $(this).find('i').removeClass().addClass('xi-eye');
    }

    inputPassword.attr('type', strType)
    $(this).attr('data-password', 'xu-' + strType)
  })
}
