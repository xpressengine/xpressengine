<div class="member find-password">
    <h1>{{xe_trans('xe::emailConfirm')}}</h1>

    <p class="sub-text">{!! xe_trans('xe::emailConfirmDescription', ['email' => sprintf('<em>%s</em>', Input::get('email'))]) !!}</p>

    <form action="{{ route('auth.confirm') }}" method="get">
        <fieldset>
            <legend>{{xe_trans('xe::emailConfirm')}}</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="email" class="sr-only">{{xe_trans('xe::email')}}</label>
                <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::email')}}" name="email" value="{{ Input::get('email') }}" readonly>
            </div>
            <div class="auth-group {{--wrong--}}">
                <label for="code" class="sr-only">{{xe_trans('xe::confirmCode')}}</label>
                <input type="text" id="code" class="xe-form-control" placeholder="{{xe_trans('xe::confirmCode')}}" name="code">
                <button class="btn-eye on" style="display:none"><i class="xi-eye"></i><i class="xi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="xe-btn xe-btn-primary">{{xe_trans('xe::send')}}</button>
        </fieldset>
    </form>
</div>



