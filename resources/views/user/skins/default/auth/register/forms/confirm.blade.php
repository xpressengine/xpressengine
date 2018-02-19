<input type="hidden" name="register_token" value="{{ $token->id }}">
<h4>{{ xe_trans('xe::inputEmailConfirmCode') }}</h4>
<div>
    <div class="auth-group">
        <p>{{ xe_trans('xe::inputEmailConfirmCodeDescription', ['email' => $token->email]) }}</p>
        <label for="code" class="xe-sr-only">{{xe_trans('xe::confirmCode')}}</label>
        <input type="text" id="code" class="xe-form-control" placeholder="{{xe_trans('xe::confirmCode')}}" name="code" value="{{ $code ?: '' }}">
    </div>
</div>
<hr>

{{
XeFrontend::html('email.setter')->content("
<script>
    $('input[name=email]').attr('readonly','readonly').val('{$token->email}');
</script>
")->load()
}}