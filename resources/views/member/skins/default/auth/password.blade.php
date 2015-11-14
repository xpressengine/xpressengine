@if(Session::get('status') !== 'passwords.reset')
    <!-- 비밀번호 찾기 3step-->
<div class="member find_pass">
    <h1>비밀번호 변경</h1>

    <p class="sub_txt">암호를 재설정합니다. 새로운 암호를 입력해주세요.</p>

    <form role="form" method="POST" action="{{ route('auth.password') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <fieldset>
            <legend>비밀번호</legend>
            <div class="auth_group {{--wrong--}}">
                <label for="email" class="blind">이메일 주소</label>
                <input type="text" id="email" class="inpt_txt" placeholder="이메일 주소" name="email" value="{{ $email or old('email') }}">
                {{--<em class="txt_message">이메일을 입력하세요.</em>--}}
            </div>
            <div class="auth_group {{--wrong--}}">
                <label for="pwd" class="blind">비밀번호</label>
                <input type="password" id="pwd" class="inpt_txt" placeholder="비밀번호" name="password">
                <button class="btn_eye on" style="display:none"><i class="xi-eye"></i><i class="xi-eye-slash"></i>
                </button>
            </div>
            <div class="auth_group {{--wrong--}}">
                <label for="pwd2" class="blind">비밀번호 다시 입력</label>
                <input type="password" id="pwd2" class="inpt_txt" placeholder="비밀번호 다시 입력" name="password_confirmation">
                <button class="btn_eye on"><i class="xi-eye"></i><i class="xi-eye-slash"></i></button>
                {{--<em class="txt_message">비밀번호가 일치하지 않습니다.</em>--}}
                <em class="txt_message normal">비밀번호는 6자리 이상이며 영문, 숫자, 특수문자를 포함하여야 합니다.</em>
            </div>
            <button type="submit" class="btn btn_blue">비밀번호 변경</button>
        </fieldset>
    </form>
</div>
<!-- // 비밀번호 찾기 3step-->

@else

<!-- 비밀번호 찾기 4step-->
<div class="member find_pass">
    <h1>비밀번호 변경이 완료되었습니다.</h1>
    {{--<div class="info">
        <p>보안상의 목적으로 해당 변경에 대한 확인용 이메일이 귀하의 계정으로 전송되었습니다.</p>
    </div>--}}
    <a href="{{ route('login') }}" class="btn btn_txt v2">로그인으로 돌아기기</a>
</div>
<!-- // 비밀번호 찾기 4step-->

@endif
