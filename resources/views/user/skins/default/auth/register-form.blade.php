<!--회원가입하기 기본폼 -->
<div class="member">
    <h1>{{xe_trans('xe::signUp')}}</h1>
    <form action="{{ route('auth.register') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <legend>{{xe_trans('xe::signUp')}}</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="email" class="sr-only">{{xe_trans('xe::email')}}</label>
                <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::enterEmail')}}" name="email" value="{{ old('email') }}">
                {{--<em class="text-message">잘못된 이메일 형식입니다.</em>--}}
            </div>
            <div class="auth-group {{--wrong--}}">
                <label for="name" class="sr-only">{{xe_trans('xe::name')}}</label>
                <input type="text" id="name" class="xe-form-control" placeholder="{{xe_trans('xe::enterName')}}" name="displayName" value="{{ old('displayName') }}">
                {{--<em class="text-message">사용자 이름을 사용할 수 없습니다.</em>--}}
                {{--<!-- <em class="text-message">사용할 수 있는 사용자 이름입니다.</em> -->--}}
            </div>
            <div class="auth-group">
                <label for="pwd" class="sr-only">{{xe_trans('xe::password')}}</label>
                <input type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::enterPassword')}}" name="password">
                <em class="text-message">{{ xe_trans($passwordLevel['description']) }}</em>
                {{--<!-- <em class="text-message">올바른 비밀번호가 아닙니다.</em> -->--}}
            </div>
            <div class="auth-group {{--success--}}">
                <label for="pwd2" class="sr-only">{{xe_trans('xe::passwordConfirm')}}</label>
                <input type="password" id="pwd2" class="xe-form-control" placeholder="{{xe_trans('xe::passwordConfirm')}}" name="password_confirmation">
                <!-- 버튼 on 클래스로 아이콘 스타일 제어 -->
                {{--<button type="button" class="btn-eye on"><i class="xi-eye"></i><i class="xi-eye-slash"></i></button>--}}
                {{--<em class="text-message">비밀번호 확인</em>--}}
                <!-- <em class="text-message">비밀번호가 일치하지 않습니다.</em> -->
            </div>

            {{-- 추가정보 --}}
            @foreach($fieldTypes as $fieldType)
            <div class="control-group">
                {!! $fieldType->getSkin()->create(Input::all()) !!}
            </div>
            @endforeach

            <div class="xe-form-group">
                <input type="checkbox" id="chk3" name="agree">
                <label for="chk3" >{!! xe_trans('xe::agreeSiteTermsUseAndSitePrivacyPolicy', ['termLink' => '#', 'policyLink' => '#']) !!}</label>
                <!--[D] 동의 및 체크 시 아래 메시지 노출-->
                <div class="auth-noti txt_red">
                    <p>{!! xe_trans('xe::agreeSiteTermsUseAndSitePrivacyPolicyDescription') !!}</p>
                </div>
            </div>
            @if($config['useCaptcha'] === true)
            {!! uio('captcha') !!}
            @endif
            <button type="submit" class="xe-btn xe-btn-primary">{{xe_trans('xe::signUp')}}</button>
        </fieldset>
    </form>
    <p class="auth-text">{{xe_trans('xe::alreadyHaveAccount')}} <a href="{{ route('login') }}">{{xe_trans('xe::login')}}</a></p>
</div>
<!--// 회원가입하기 기본폼 -->

{!! app('xe.frontend')->html('auth.register')->content("
    <script>
        $(function($) {
            $('.__xe_btn_privacy').click(function(){
                XE.pageModal('".route('auth.privacy')."');
                return false;
            })
            $('.__xe_btn_agreement').click(function(){
                XE.pageModal('".route('auth.agreement')."');
                return false;
            })
        });
    </script>
")->load() !!}
