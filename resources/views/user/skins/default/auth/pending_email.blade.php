{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}

<div class="theme_container">
    <div class="user user--signup-complete">
        <h2 class="user__title">{{ xe_trans('xe::sendConfirmMail') }}</h2>
        <p class="user__text">{{ xe_trans('xe::sendedRegisterConfirmMail') }} <br>{{ xe_trans('xe::checkYourEmail') }}</p>
        <p class="user__text-resend">{{ xe_trans('xe::dontReceiveEmail') }}</p>
        <form method="post" action="{{ route('auth.send_approve_email') }}">
            {!! csrf_field() !!}
            <input type="hidden" name="email" value="{{ $user->email }}">

            <div class="button-box">
                <button type="submit" class="xu-button xu-button--default xu-button--large user__button-default" style="width: 150px">
                    <span class="xu-button__text">{{ xe_trans('xe::resendEmail') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
