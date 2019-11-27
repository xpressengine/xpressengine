@inject('passwordValidator', 'xe.password.validator')

{{-- email --}}
<div class="xu-form-group xu-form-group--large">
    <label class="xu-form-group__label" for="f-email">{{ xe_trans('xe::email') }}<em class="xu-form-group__label-required">*</em></label>
    <div class="xu-form-group__box">
        <input type="text" id="f-email" class="xe-form-control xu-form-group__control" placeholder="{{ xe_trans('xe::enterEmail') }}" name="email" value="{{ old('email') }}" required data-valid-name="{{ xe_trans('xe::email') }}">
    </div>
</div>
<div class="xu-form-group xu-form-group--large auth-group">
    <label for="f-name" class="xu-form-group__label">{{xe_trans('xe::name')}}</label>
    <input type="text" id="f-name" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::name')}}" name="display_name" value="{{ old('display_name') }}" data-valid-name="{{xe_trans('xe::name')}}">
</div>
<div class="xu-form-group xu-form-group--large auth-group">
    <label for="f-pwd" class="xu-form-group__label">{{xe_trans('xe::password')}}</label>
    <input type="password" id="f-pwd" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::password')}}" name="password" onfocus="$('.__xe_password-description').slideDown();" data-valid-name="{{xe_trans('xe::password')}}">
    <em style="display: none;" class="text-message __xe_password-description">{{ $passwordValidator->getMessage() }}</em>
</div>
<div class="xu-form-group xu-form-group--large auth-group">
    <label for="f-pwd2" class="xu-form-group__label">{{xe_trans('xe::passwordConfirm')}}<em class="xu-form-group__label-required">*</em></label>
    <input type="password" id="f-pwd2" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::passwordConfirm')}}" name="password_confirmation">
</div>

<script>
    $(function () {
        $('.__xe-toggle-password').on('click', function () {
            var $self = $(this)
            var $prev = $self.prev()
            if ($prev.attr('type') === 'password') {
                $prev.attr('type', 'text')
                $self.find('i').addClass('xi-eye-off').removeClass('xi-eye')
            } else {
                $prev.attr('type', 'password')
                $self.find('i').addClass('xi-eye').removeClass('xi-eye-off')
            }
        })
    })
</script>
