{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::js('assets/core/user/user_register.js')->load() }}

@expose_trans('xe::validatorMin')
@expose_trans('xe::passwordIncludeNumber')
@expose_trans('xe::passwordIncludeCharacter')
@expose_trans('xe::passwordIncludeSpecialCharacter')
@expose_trans('xe::enterPasswordConfirmation')

<div class="user user--reset-password">
    @if(Session::get('status') !== 'passwords.reset')
        <!-- 비밀번호 찾기 3step -->
        <!-- 비밀번호 변경 -->
        <h2 class="user__title">{{ xe_trans('xe::changePassword') }}</h2>
        <p class="user__text">{{ xe_trans('xe::changePasswordDescription') }}</p>

        <form role="form" method="post" action="{{ route('auth.password') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="xu-form-group">
                <label class="xu-form-group__label">{{ xe_trans('xe::email') }}</label>
                <input type="text" class="xu-form-group__control" placeholder="{{ xe_trans('xe::enterEmail') }}" name="email" value="{{ $email or old('email') }}" data-valid-name="{{ xe_trans('xe::email') }}">
            </div>

            <div class="xu-form-group">
                <label class="xu-form-group__label">{{ xe_trans('xe::password') }}</label>
                <div class="xu-form-group__box xu-form-group__box--icon-right">
                    <input type="password" class="xu-form-group__control" placeholder="{{ xe_trans('xe::password' )}}" name="password"  data-valid-name="{{ xe_trans('xe::password') }}">
                </div>
            </div>

            <div class="xu-form-group">
                <label class="xu-form-group__label">{{ xe_trans('xe::passwordConfirm') }}</label>
                <div class="xu-form-group__box xu-form-group__box--icon-right">
                    <input type="password" class="xu-form-group__control" placeholder="{{ xe_trans('xe::passwordConfirm' )}}" name="password_confirmation"  data-valid-name="{{ xe_trans('xe::passwordConfirm') }}">
                </div>
            </div>

            <button type="submit" class="xe-btn xe-btn-primary">{{ xe_trans('xe::changePassword') }}</button>
        </form>
    @else
        <!-- 비밀번호 찾기 4step-->
        <h2 class="user__title">{{ xe_trans('xe::passwordChangeComplete') }}</h2>
        <a href="{{ route('login') }}" class="xu-button xu-button--primary">{{ xe_trans('xe::login') }}</a>
    @endif
</div>
