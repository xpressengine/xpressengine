@if(Session::get('status') !== 'passwords.reset')
    <!-- 비밀번호 찾기 3step-->
<div class="member find-password">
    <h1>{{xe_trans('xe::changePassword')}}</h1>

    <p class="sub-text">{{xe_trans('xe::changePasswordDescription')}}</p>

    <form role="form" method="POST" action="{{ route('auth.password') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <fieldset>
            <legend>{{xe_trans('xe::password')}}</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="email" class="sr-only">{{xe_trans('xe::email')}}</label>
                <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::email')}}" name="email" value="{{ $email or old('email') }}">
                {{--<em class="text-message">이메일을 입력하세요.</em>--}}
            </div>
            <div class="auth-group {{--wrong--}}">
                <label for="pwd" class="sr-only">{{xe_trans('xe::password')}}</label>
                <input type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::password')}}" name="password">
                <button class="btn-eye on" style="display:none"><i class="xi-eye"></i><i class="xi-eye-off"></i>
                </button>
            </div>
            <div class="auth-group {{--wrong--}}">
                <label for="pwd2" class="sr-only">{{xe_trans('xe::passwordConfirm')}}</label>
                <input type="password" id="pwd2" class="xe-form-control" placeholder="{{xe_trans('xe::passwordConfirm')}}" name="password_confirmation">
                <button class="btn-eye on"><i class="xi-eye"></i><i class="xi-eye-off"></i></button>
                {{--<em class="text-message">비밀번호가 일치하지 않습니다.</em>--}}
                <em class="text-message normal">{{xe_trans('xe::passwordStrengthNormalDescription')}}</em>
            </div>
            <button type="submit" class="xe-btn xe-btn-primary">{{xe_trans('xe::changePassword')}}</button>
        </fieldset>
    </form>
</div>
<!-- // 비밀번호 찾기 3step-->

@else

<!-- 비밀번호 찾기 4step-->
<div class="member find-password">
    <h1>{{xe_trans('xe::passwordChangeComplete')}}</h1>
    {{--<div class="info">
        <p>보안상의 목적으로 해당 변경에 대한 확인용 이메일이 귀하의 계정으로 전송되었습니다.</p>
    </div>--}}
    <a href="{{ route('login') }}" class="btn xe-btn-text v2">{{xe_trans('xe::login')}}</a>
</div>
<!-- // 비밀번호 찾기 4step-->

@endif
