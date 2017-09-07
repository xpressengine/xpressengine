<!--회원가입하기 기본폼 -->
<div class="member">
    <h1>{{xe_trans('xe::doSignUp')}}</h1>
    <form action="{{ route('auth.register') }}" method="post" data-rule="join" data-rule-alert-type="toast">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if($register_token)
        <input type="hidden" name="register_token" value="{{ $register_token->id }}">
        @endif
        <fieldset>
            <legend>{{xe_trans('xe::signUp')}}</legend>

            @foreach($forms as $form)
                @if($form['activated'] || array_get($form, 'forced') === true)
                {!! $form['render']($register_token) !!}
                @endif
            @endforeach

            <button type="submit" class="xe-btn xe-btn-primary xe-btn-block">{{xe_trans('xe::signUp')}}</button>
        </fieldset>
    </form>
    <p class="auth-text">{{xe_trans('xe::alreadyHaveAccount')}} <a href="{{ route('login') }}">{{xe_trans('xe::login')}}</a></p>
</div>
<!--// 회원가입하기 기본폼 -->
