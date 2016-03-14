<div class="member find_pass">
    <h1>이메일 인증</h1>

    <p class="sub_txt">회원가입을 완료하려면 이메일 인증을 해야 합니다. <em>{{ Input::get('email') }}</em>을 확인하신후, 인증 코드를 입력해주세요.</p>

    <form action="{{ route('auth.confirm') }}" method="get">
        <fieldset>
            <legend>이메일 인증</legend>
            <div class="auth_group {{--wrong--}}">
                <label for="email" class="sr-only">이메일 주소</label>
                <input type="text" id="email" class="inpt_txt" placeholder="이메일 주소" name="email" value="{{ Input::get('email') }}" readonly>
            </div>
            <div class="auth_group {{--wrong--}}">
                <label for="code" class="sr-only">인증 코드</label>
                <input type="text" id="code" class="inpt_txt" placeholder="인증 코드" name="code">
                <button class="btn_eye on" style="display:none"><i class="xi-eye"></i><i class="xi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="btn btn_blue">인증 요청</button>
        </fieldset>
    </form>
</div>



