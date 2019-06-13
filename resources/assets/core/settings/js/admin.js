import 'bootstrap'
import $ from 'jquery'

$(document).ready(function () {
  var $sidebar = $('.settings-nav-sidebar')
  var $dim = $('.dim')

  /* 사이드바 */
  $sidebar.on('setting.sidebar.open', function () {
    $sidebar.addClass('open')
    $dim.show()
    $('body').css('overflow', 'hidden')
    $('html').css('position', 'fixed')
  }).on('setting.sidebar.close', function () {
    $sidebar.removeClass('open')
    $dim.hide()
    $('body').css('overflow', '')
    $('html').css('position', '')
  }).on('setting.sidebar.toggle', function () {
    if ($(window).innerWidth() < 1068) {
      $('body').removeClass('sidebar-collapse')
      if ($sidebar.hasClass('open')) {
        $sidebar.trigger('setting.sidebar.close')
      } else {
        $sidebar.trigger('setting.sidebar.open')
      }
    } else {
      $('body').toggleClass('sidebar-collapse')
    }
  })

  $dim.on('click', function () {
    $sidebar.trigger('setting.sidebar.close')
  })

  $('.btn-slide').on('click', function () {
    $sidebar.trigger('setting.sidebar.toggle')
  })

  /* 사이드바 메뉴 */
  $(document).on('click', '.snb-list li', function (event) {
    var $target = $(event.target)
    var $subdepth = $target.closest('.sub-depth')
    var $ul

    if ($.inArray('__xe_collapseMenu', $target[0].classList) > -1) {
      $ul = $target.siblings('.sub-depth-list')
    } else {
      $ul = $target.parent().siblings('.sub-depth-list')
    }

    if ($ul.length === 0) {
      return true
    }

    if ($ul.is(':visible')) {
      $ul.find('.sub-depth-list').slideUp('fast')
      $ul.find('.sub-depth').removeClass('open')

      $ul.slideUp('fast')
      $subdepth.removeClass('open')
    } else {
      var $parent = $subdepth.parent()

      // $parent.find('.sub-depth.open>.sub-depth-list').slideUp('fast');
      $parent.find('.sub-depth.open').removeClass('open')

      $ul.slideDown('fast')
      $subdepth.addClass('open')
    }

    return false
  })

  /* notice 닫기 버튼 */
  $('.notice__button-close').click(function () {
    $(this).parent('.notice').remove()
  })

  // // 이미지 업로드 미리보기 적용 (IE10 이상)
  // 이미지 업로드 미리보기 적용 (IE10 이상)
  if ('FileReader' in window) {
    function readURL (input) {
      if (input.files && input.files[0]) {
        // 읽기
        var reader = new FileReader()

        var inputFileName = $(input).attr('name')
        // 로드 한 후
        reader.onload = function (e) {
          if (inputFileName == 'siteImage') {
            $('.__basic-setting-preview-facebook__image').css('background-image', 'url(' + e.target.result + ')')
          } else if (inputFileName == 'favicon') {
            $('.__basic-setting-preview-favicon__image--thumbnail').css('background-image', 'url(' + e.target.result + ')')
          }
        }
        reader.readAsDataURL(input.files[0])
      }
    }

    $('input[name*="siteImage"], input[name*="favicon"]').change(function () {
      readURL(this)
    })
  } else {
    // FileReader 를 지원하지 않는 브라우저에서 이미지 제거하고 알림 문구 노출
    // $('.__basic-setting-preview-facebook__image').css('background-image','none');
    $('.__basic-setting-preview-facebook__alert-text').css('display', 'block')
  }

  // 브라우저 제목, 부제목, 설명, 사이트 url input 영역 keyup 이벤트로 실시간 데이터 적용
  var inputValueSiteAddress = $('.__preview-site-address .form-control').val()
  var inputValueBrowserTitle = XE.Lang.trans('xe::browserTitle') // 기본값 : 브라우저의 제목
  var inputValueBrowserSubTitle = XE.Lang.trans('xe::browserSubTitle') // 기본값 : 브라우저의 부제목
  var inputValueDescription = XE.Lang.trans('xe::siteSettingSEOInputDescription') // 기본값 : 사이트 설명을 입력해주세요.
  $(document).on('keyup', '.__preview-input .text > .input-group input, #site_address', function (e) {
    var previewInputClass = $(this).parents('.__preview-input')
    var inputValue = e.target.value
    if (previewInputClass.hasClass('__preview-site-address')) {
      // 사이트 url
      if (inputValue == '') {
        inputValue = inputValueSiteAddress
      }
      $('.__basic-setting-preview__url').text(inputValue)
    } else if (previewInputClass.hasClass('__preview-browser-title')) {
      // 브라우저 제목
      if (inputValue == '') {
        inputValue = inputValueBrowserTitle
      }
      $('.__basic-setting-preview__title--site-main').text(inputValue)
    } else if (previewInputClass.hasClass('__preview-browser-subtitle')) {
      // 브라우저 부제목
      if (inputValue == '') {
        inputValue = inputValueBrowserSubTitle
      }
      $('.__basic-setting-preview__title--site-sub').text(inputValue)
    } else if (previewInputClass.hasClass('__preview-description')) {
      // 브라우저 설명
      if (inputValue == '') {
        inputValue = inputValueDescription
      }
      $('.__basic-setting-preview__description').text(inputValue)
    }
  })

  previewDataSettingInit(inputValueSiteAddress, inputValueBrowserTitle, inputValueBrowserSubTitle, inputValueDescription)

  // 처음 화면 뜰 때 미리보기 기본세팅
  function previewDataSettingInit (pInputValueSiteAddress, pInputValueBrowserTitle, pInputValueBrowserSubTitle, pInputValueDescription) {
    var mainTitleValue = $('#defaultSettingMainTitle').val() // 브라우저 제목
    var subTitleValue = $('#defaultSettingSubTitle').val() // 브라우저 부제목
    var descriptionValue = $('#defaultSettingDescription').val() // 설명

    $('.__basic-setting-preview__url').text(pInputValueSiteAddress)
    $('.__basic-setting-preview__title--site-main').text(mainTitleValue == '' ? pInputValueBrowserTitle : mainTitleValue)
    $('.__basic-setting-preview__title--site-sub').text(subTitleValue == '' ? pInputValueBrowserSubTitle : subTitleValue)
    $('.__basic-setting-preview__description').text(descriptionValue == '' ? pInputValueDescription : descriptionValue)
  }
})
