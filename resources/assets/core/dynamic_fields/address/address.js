/* global $, daum */
function foldDaumPostcode (fieldId) {
  $('#' + fieldId + '-daumPostcodeWrap').hide()
}

function execDaumPostcode (fieldId) {
  // 현재 scroll 위치를 저장해놓는다.
  var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop)
  daum.postcode.load(function () {
    new daum.Postcode({
      oncomplete: function (data) {
      // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

        // 각 주소의 노출 규칙에 따라 주소를 조합한다.
        // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
        var fullAddr = data.address // 최종 주소 변수
        var extraAddr = '' // 조합형 주소 변수

        // 기본 주소가 도로명 타입일때 조합한다.
        if (data.addressType === 'R') {
        // 법정동명이 있을 경우 추가한다.
          if (data.bname !== '') {
            extraAddr += data.bname
          }
          // 건물명이 있을 경우 추가한다.
          if (data.buildingName !== '') {
            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName)
          }
          // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
          fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '')
        }

        // 우편번호와 주소 정보를 해당 필드에 넣는다.
        $('[name="' + fieldId + '_postcode"]').val(data.zonecode)
        $('[name="' + fieldId + '_address1"]').val(fullAddr)

        // iframe을 넣은 element를 안보이게 한다.
        // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
        $('#' + fieldId + '-daumPostcodeWrap').hide()

        // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
        document.body.scrollTop = currentScroll
      },
      // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
      onresize: function (size) {
        $('#' + fieldId + '-daumPostcodeWrap').css('height', size.height + 'px')
      },
      width: '100%',
      height: '100%'
    }).embed($('#' + fieldId + '-daumPostcodeWrap')[0])

    // iframe을 넣은 element를 보이게 한다.
    $('#' + fieldId + '-daumPostcodeWrap').show()
  })
}
