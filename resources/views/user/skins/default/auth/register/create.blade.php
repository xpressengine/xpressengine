{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::js('assets/core/user/user_register.js')->load() }}

<!-- 회원가입 폼  -->
<!-- [D] 회원가입 폼 영역은 가로 길이 때문에 class="user--signup" 추가 -->
<div class="user user--signup">
    <h2 class="user__title">{{ xe_trans('xe::signUp') }}</h2>
    <p class="user__text">{!! nl2br($config->get('register_guide')) !!}</p>

    <form action="{{ route('auth.register') }}" method="post" data-rule="join" data-rule-alert-type="form">
        {{ csrf_field() }}
        <fieldset>
            <legend>{{ xe_trans('xe::signUp') }}</legend>

            <div class="user-signup">
                @foreach ($parts as $part)
                    {{ $part->render() }}
                @endforeach
            </div>

            <button type="submit" class="xu-button xu-button--primary xu-button--block xu-button--large user-signup__button-signup">
                <span class="xu-button__text">{{ xe_trans('xe::signUp') }}</span>
            </button>
        </fieldset>
    </form>
</div>
<!-- //로그인 폼  -->
