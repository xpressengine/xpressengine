<html>
<!--
http://yobi.xehub.io:8888/xeui/xe3/issue/22

-->
<head>
    <!-- LangEditorBox.css -->
    <link rel="stylesheet" type="text/css" href="/assets/vendor/lang/LangEditorBox.css">

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <!--
        expanding.js는 textarea에서 줄바꿈이 생길때 textarea를 줄에 맞춰 늘려주기 위해 설치한 jquery plugin입니다. 다음 url을 참고해주세요.
        제작자가 작성한 문서 ==> http://alistapart.com/article/expanding-text-areas-made-elegant
        위 문서에서 가리키고있는 github ==> https://github.com/bgrins/ExpandingTextareas
    -->
    <script src="/assets/vendor/expanding/expanding.js"></script>
    <script>

        // 다국어 editor는 동적으로 생기는 경우가 있어서 on 핸들러로 future 엘리먼트에 대한 이벤트 처리를 했습니다.
        $(document).on('focus', '.lang-editor .main input, textarea', function() {

            // a)
            var el = $(this).closest('.lang-editor').find('.sub'),
                    currHeight = el.height(),
                    autoHeight = el.css('height', 'auto').height();
            el.height(currHeight).animate({height: autoHeight}, 200);

            // b) textarea가 자동으로 expand 되도록 하기 위한 처리
            $(".lang-editor textarea").expanding();

        });

    </script>
</head>
<body>

<!-- 예제(1) textarea -->
<div class="lang-editor">
    <!-- 여기서 .textarea는 안에 들어있는 text영역이 input text 인지 textarea 인지를 표현합니다. -->
    <div class="textarea">

        <!-- 최초 보여지는 다국어 영역을 .main 클래스로 만들었습니다. 시스템적인 의미는 "현재 선택된 메인 언어" 입니다. -->
        <ul class="main">
            <li class="item">

                <!-- 잘라진 언어별 국기 이미지를 바로 사용하는데 만들어주신 http://yobi.xehub.io:8888/xeui/xe3/issue/21 가 적용되면 좋겠습니다~ -->
                <div class="img"><img src="/assets/vendor/lang/flags/flag.en.gif" /></div>
                <div class="txt">
                    <textarea>en</textarea>
                </div>

            </li>
        </ul>

        <!-- 최초 접혀있는 다국어 영역을 sub로 묶었습니다 -->
        <ul class="sub">
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.ko.gif" /></div>
                <div class="txt">
                    <textarea>ko</textarea>
                </div>
            </li>
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.cn.gif" /></div>
                <div class="txt">
                    <textarea>cn</textarea>
                </div>
            </li>
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.jp.gif" /></div>
                <div class="txt">
                    <textarea>jp</textarea>
                </div>
            </li>
        </ul>

    </div>
</div>

<br><hr/><br>

<!--
예제(2) input text:
* 구조는 예제(1)과 비슷합니다.
  * class="text" 부분이 예제(1)에서 class="textarea"와 차이나는 정도만 참고해주세요.
  * 물론 <textarea /> 대신 <input /> 이 사용된 차이도 있습니다.
-->
<div class="lang-editor">
    <div class="text">
        <ul class="main">
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.en.gif" /></div>
                <div class="txt">
                    <input type="text" value="en" />
                </div>
            </li>
        </ul>
        <ul class="sub">
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.ko.gif" /></div>
                <div class="txt">
                    <input type="text" value="ko" />
                </div>
            </li>
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.cn.gif" /></div>
                <div class="txt">
                    <input type="text" value="cn" />
                </div>
            </li>
            <li class="item">
                <div class="img"><img src="/assets/vendor/lang/flags/flag.jp.gif" /></div>
                <div class="txt">
                    <input type="text" value="jp" />
                </div>
            </li>
        </ul>
    </div>
</div>
</body>

<!--
감사합니다!!

구준호 드림.
-->

</html>