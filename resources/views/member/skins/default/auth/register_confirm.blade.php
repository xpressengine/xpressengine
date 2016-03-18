<div class="member find-password">
    <h1>이메일 인증</h1>

    <p class="sub-text">회원가입을 완료하려면 이메일 인증을 해야 합니다. <em>{{ Input::get('email') }}</em>을 확인하신후, 인증 코드를 입력해주세요.</p>

    <form action="{{ route('auth.confirm') }}" method="get">
        <fieldset>
            <legend>이메일 인증</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="email" class="sr-only">이메일 주소</label>
                <input type="text" id="email" class="xe-input-text" placeholder="이메일 주소" name="email" value="{{ Input::get('email') }}" readonly>
            </div>
            <div class="auth-group {{--wrong--}}">
                <label for="code" class="sr-only">인증 코드</label>
                <input type="text" id="code" class="xe-input-text" placeholder="인증 코드" name="code">
                <button class="btn-eye on" style="display:none"><i class="xi-eye"></i><i class="xi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="xe-btn xe-btn-blue">인증 요청</button>
        </fieldset>
    </form>
</div>



