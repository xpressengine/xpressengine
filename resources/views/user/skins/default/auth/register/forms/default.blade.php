<h4>{{xe_trans('xe::enterDefaultInfo')}}</h4>
<div class="auth-group">
    <label for="email" class="xe-sr-only">{{xe_trans('xe::email')}}</label>
    <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::email')}}" name="email" value="{{ old('email') }}" data-valid-name="{{xe_trans('xe::email')}}">
</div>
<div class="auth-group">
    <label for="name" class="xe-sr-only">{{xe_trans('xe::name')}}</label>
    <input type="text" id="name" class="xe-form-control" placeholder="{{xe_trans('xe::name')}}" name="display_name" value="{{ old('display_name') }}" data-valid-name="{{xe_trans('xe::name')}}">
</div>
<div class="auth-group">
    <label for="pwd" class="xe-sr-only">{{xe_trans('xe::password')}}</label>
    <input type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::password')}}" name="password" onfocus="$('.__xe_password-description').slideDown();" data-valid-name="{{xe_trans('xe::password')}}">
    <em style="display: none;" class="text-message __xe_password-description">{{ xe_trans($passwordLevel['description']) }}</em>
</div>
<div class="auth-group">
    <label for="pwd2" class="xe-sr-only">{{xe_trans('xe::passwordConfirm')}}</label>
    <input type="password" id="pwd2" class="xe-form-control" placeholder="{{xe_trans('xe::passwordConfirm')}}" name="password_confirmation">
</div>
