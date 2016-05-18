@if(Session::get('status') !== 'passwords.sent')
    <!-- 비밀번호 찾기 1step, 비밀번호 찾기 시 find-password 클래스 추가 인풋간 간격 넓어짐(제외가능)-->
<div class="member find-password">
    <h1>비밀번호를 잊으셨습니까?</h1>

    <p class="sub-text">계정에 등록된 이메일 주소를 입력하세요. 비밀번호를 재설정할 수 있는 링크를 이메일로 보내드립니다.</p>

    <form role="form" method="post" action="{{ route('auth.reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <legend>비밀번호 찾기</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="email" class="sr-only">이메일 주소</label>
                <input type="text" id="email" class="xe-form-control" placeholder="이메일 주소" name="email" value="{{ old('email') }}">
                {{--<em class="text-message">이메일을 입력하세요.</em>--}}
            </div>
            <button class="xe-btn xe-btn-primary">다음</button>
        </fieldset>
    </form>
    <a href="{{ route('login') }}" class="xe-btn xe-btn-link v2">로그인으로 돌아가기</a>
</div>
<!-- // 비밀번호 찾기 1step-->

@else

<!-- 비밀번호 찾기 2step-->
<div class="member find-password">
    <h1>이메일이 전송되었습니다.</h1>
    <div class="info">
        <p><em>{{ $email }}</em>으로 암호를 새로 만드는 방법에 대한 지침이 포함된 메일이 전송되었습니다.</p>
        <em class="info-title">이메일을 확인해주시기 바랍니다.</em>
        {{--<em class="info-title">이메일을 수신하지 못했습니까?</em><br>
        <p>accounts-noreply@xpressengine.com으로부터 수신된 메시지에 대해 스팸 또는 벌크 폴더를 확인하십시오.</p>--}}
    </div>
    <a href="{{ route('login') }}" class="btn xe-btn-text v2">로그인으로 돌아기기</a>
</div>
<!-- // 비밀번호 찾기 2step-->

@endif
