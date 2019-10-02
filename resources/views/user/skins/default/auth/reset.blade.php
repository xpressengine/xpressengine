{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}

<div class="user user--signup-complete">
    @if(Session::get('status') !== 'passwords.sent')
        <h2 class="user__title">{{ xe_trans('xe::forgotPassword') }}</h2>
        <p class="user__text">{{ xe_trans('xe::forgotPasswordDescription') }}</p>

        <form role="form" method="post" action="{{ route('auth.reset') }}">
            {{  csrf_field() }}
            <div class="xu-form-group">
                <div class="xu-form-group__box">
                    <label class="xu-form-group__label">{{ xe_trans('xe::email') }}</label>
                    <input type="text" name="email" class="xu-form-group__control" placeholder="{{ xe_trans('xe::enterEmail') }}">
                </div>
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" class="xu-button xu-button--primary">
                    <span class="xu-button__text">{{ xe_trans('xe::next') }}</span>
                </button>
                <a href="{{ route('login') }}" class="xu-button xu-button--link">{{ xe_trans('xe::login') }}</a>
            </div>
        </form>
    @else
    <!-- 비밀번호 찾기 2step-->
    <div class="user find-password">
        <h2 class="user__title">{{xe_trans('xe::msgEmailSendComplete')}}</h2>
        <p class="user__text">{!! xe_trans('xe::checkFindPasswordEmailDescription', ['email' => sprintf('<em>%s</em>', $email)]) !!}</p>
        <em class="info-title">{{ xe_trans('xe::checkSentEmail') }}</em>
        <a href="{{ route('login') }}" class="xu-button xu-button--link">{{ xe_trans('xe::login') }}</a>
    </div>
    <!-- // 비밀번호 찾기 2step-->

    @endif
</div>
