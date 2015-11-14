{{ App::setLocale('en') }}

<h4>uio 버전</h4>
<div class="form-group">
    <label>input</label>
    {!! uio('langText', ['placeholder'=>'다국어 input', 'langKey'=> '', 'name'=>'site_title']) !!}
</div>
<div class="form-group">
    <label>textarea</label>
    {!! uio('langTextArea', ['placeholder'=>'다국어 textarea', 'langKey'=> '', 'name'=>'site_title']) !!}
</div>


<h4>다국어 편집 UI</h4>
@include('lang.editorbox')<br/>
@include('lang.editorbox', ['data' => $lang1])<br/>
@include('lang.editorbox', ['data' => $lang2])<br/>

<h4>백엔드 다국어</h4>
{{ XeLang::trans('lang::message', ['name' => 'Junho']) }}<br/>
{{ XeLang::transChoice('lang::bananas', 1) }}<br/>
{{ XeLang::transChoice('lang::bananas', 2) }} => 영어는 2이상이면 복수로 선택<br/>
{{ XeLang::transChoice('lang::apples', 0) }} => 0<br/>
{{ XeLang::transChoice('lang::apples', 1) }} => 1<br/>
{{ XeLang::transChoice('lang::apples', 19) }} => 19<br/>
{{ XeLang::transChoice('lang::apples', 20) }} => 20<br/>

{{ App::setLocale('ko') }}
{{ XeLang::trans('lang::message', ['name' => '준호']) }}<br/>
{{ XeLang::transChoice('lang::bananas', 1) }}<br/>
{{ XeLang::transChoice('lang::bananas', 2) }} => 복수지만 locale이 ko라서 첫번째 문장이 선택됨<br/>
{{ XeLang::transChoice('lang::apples', 0) }} => 0<br/>
{{ XeLang::transChoice('lang::apples', 1) }} => 1<br/>
{{ XeLang::transChoice('lang::apples', 19) }} => 19<br/>
{{ XeLang::transChoice('lang::apples', 20) }} => 20<br/>
{{ App::setLocale('en') }}
<br/>

<h4>프론트엔드 다국어</h4>
<span>
<?php
    FrontEnd::translation('lang::message');
    Frontend::translation('lang::bananas');
    Frontend::translation('lang::next');
    Frontend::translation(['lang::week.mon', 'lang::week.tue']);
    Frontend::translation('lang::nothing');
    ?>
    <script>
        document.write(XE.Lang.trans('lang::message', {'name': '준호'}) + "<br/>");
        document.write(XE.Lang.transChoice('lang::bananas', 1) + "<br/>");
        document.write(XE.Lang.transChoice('lang::bananas', 2) + "<br/>");
        document.write(XE.Lang.trans('lang::next') + "<br/>");
        document.write(XE.Lang.trans('lang::previous') + " => 존재하는 key이지만 load를 안한경우<br/>");
        document.write(XE.Lang.trans('lang::week.mon') + "<br/>");
        document.write(XE.Lang.trans('lang::week.tue') + "<br/>");
        document.write(XE.Lang.trans('lang::nothing') + " => 존재하지 않는 key는 head의 다국어 script에 set 되지도 않게 함<br/>");
    </script>
</span>
