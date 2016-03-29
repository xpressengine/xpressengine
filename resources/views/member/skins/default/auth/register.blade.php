<!--회원가입하기 기본폼 -->
<div class="member">
    <h1>회원 가입하기</h1>
    <form action="{{ route('auth.register') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <legend>회원가입</legend>
            <div class="auth_group {{--wrong--}}">
                <label for="email" class="blind">이메일 주소</label>
                <input type="text" id="email" class="inpt_txt" placeholder="이메일 주소" name="email" value="{{ old('email') }}">
                {{--<em class="txt_message">잘못된 이메일 형식입니다.</em>--}}
            </div>
            <div class="auth_group {{--wrong--}}">
                <label for="name" class="blind">사용자 이름</label>
                <input type="text" id="name" class="inpt_txt" placeholder="사용자 이름" name="displayName" value="{{ old('displayName') }}">
                {{--<em class="txt_message">사용자 이름을 사용할 수 없습니다.</em>--}}
                {{--<!-- <em class="txt_message">사용할 수 있는 사용자 이름입니다.</em> -->--}}
            </div>
            <div class="auth_group">
                <label for="pwd" class="blind">비밀번호</label>
                <input type="password" id="pwd" class="inpt_txt" placeholder="비밀번호" name="password">
                <em class="txt_message">{{ $passwordLevel['description'] }}</em>
                {{--<!-- <em class="txt_message">올바른 비밀번호가 아닙니다.</em> -->--}}
            </div>
            <div class="auth_group {{--success--}}">
                <label for="pwd2" class="blind">비밀번호 다시 입력</label>
                <input type="password" id="pwd2" class="inpt_txt" placeholder="비밀번호 다시 입력" name="password_confirmation">
                <!-- 버튼 on 클래스로 아이콘 스타일 제어 -->
                {{--<button type="button" class="btn_eye on"><i class="xi-eye"></i><i class="xi-eye-slash"></i></button>--}}
                {{--<em class="txt_message">비밀번호 확인</em>--}}
                <!-- <em class="txt_message">비밀번호가 일치하지 않습니다.</em> -->
            </div>

            {{-- 추가정보 --}}
            @foreach($fieldTypes as $fieldType)
            <div class="control-group">
                {!! $fieldType->getSkin()->create(Input::all()) !!}
            </div>
            @endforeach

            <div class="inpt_group">
                <input type="checkbox" id="chk3" name="agree">
                <label for="chk3" ><a href="#">이용 약관</a> 및 <a href="#">개인정보 보호정책</a>을 읽었으며 이에 동의합니다.</label>
                <!--[D] 동의 및 체크 시 아래 메시지 노출-->
                <div class="auth_noti txt_red">
                    <p>계속하려면 이용 약관 및 개인정보 보호정책을 읽었으며 이에 동의한다는 의사 표시로 확인란을 선택해야 합니다.</p>
                </div>
            </div>
            @if($config['useCaptcha'] === true)
            {!! uio('captcha') !!}
            @endif
            <button type="submit" class="btn btn_blue">가입하기</button>
        </fieldset>
    </form>
    <p class="auth_txt">이미 계정이 있습니까? <a href="{{ route('login') }}">로그인</a></p>
</div>
<!--// 회원가입하기 기본폼 -->
