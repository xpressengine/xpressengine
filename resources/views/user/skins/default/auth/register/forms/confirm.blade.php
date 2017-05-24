@if($code !== null)
    <input type="hidden" name="code" value="{{ $code }}">
@else
<h4>{{ xe_trans('xe::inputEmailConfirmCode') }}</h4>
<div>
    <form action="{{ route('auth.register.confirm') }}" method="post" data-submit="xe-ajax" data-callback="confirmCode">
        <div class="auth-group">
            <p>{{ xe_trans('xe::inputEmailConfirmCodeDescription', ['email' => $token->email]) }}</p>
            <input type="hidden" name="email" value="{{ $token->email }}">
            <label for="code" class="xe-sr-only">{{xe_trans('xe::confirmCode')}}</label>
            <input type="text" id="code" class="xe-form-control" placeholder="{{xe_trans('xe::confirmCode')}}" name="code">
        </div>
    </form>
</div>
<hr>
@endif
