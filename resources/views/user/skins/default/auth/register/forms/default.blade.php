{{-- deprecated since 3.0.8 instead use new_default.blade.php --}}

@inject('passwordValidator', 'xe.password.validator')

{{-- email --}}
<div class="xu-form-group xu-form-group--large">
    <label class="xu-form-group__label" for="f-email">{{ xe_trans('xe::email') }}</label>
    <div class="xu-form-group__box">
        <input type="text" id="f-email" class="xe-form-control xu-form-group__control" placeholder="{{ xe_trans('xe::enterEmail') }}" name="email" value="{{ old('email') }}" required data-valid-name="{{ xe_trans('xe::email') }}">
    </div>
</div>

{{-- name --}}
<div class="xu-form-group xu-form-group--large">
    <label class="xu-form-group__label" for="f-name">{{ xe_trans('xe::name') }}</label>
    <div class="xu-form-group__box">
        <input type="text" id="f-name" class="xu-form-group__control" placeholder="{{ xe_trans('xe::enterName') }}" name="display_name" value="{{ old('display_name') }}" required data-valid-name="{{ xe_trans('xe::name') }}">
    </div>
</div>

{{-- password --}}
<div class="xu-form-group xu-form-group--large">
    <label class="xu-form-group__label" for="f-password">{{ xe_trans('xe::password') }}</label>
        <div class="xu-form-group__box xu-form-group__box--icon-right">
            <input type="password" id="f-password" class="xu-form-group__control" placeholder="{{ xe_trans('xe::enterPassword') }}" name="password" required data-valid-name="{{xe_trans('xe::password')}}">
            <button type="button" class="xu-form-group__icon __xe-toggle-password">
                <i class="xi-eye"></i>
            </button>
    </div>
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
