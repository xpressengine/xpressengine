    <div class="user">
        <h1>{{ xe_trans('xe::adminAuth') }}</h1>
        <div class="info">
            <em class="info-title">{{ xe_trans('xe::msgAdminAuth') }}</em><br>
            <p>{{ xe_trans('xe::msgAdminAuthDetail') }}</p>
        </div>
        <form action="{{ route('auth.admin') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="redirectUrl" value="{{ $redirectUrl or '' }}">
            <fieldset>
                <legend>{{ xe_trans('xe::authenticate') }}</legend>
                <div class="auth-group">
                    <label for="pwd" class="xe-sr-only">{{xe_trans('xe::password')}}</label>
                    <input name="password" type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::password')}}">
                </div>
                <button type="submit" class="xe-btn xe-btn-primary xe-btn-block">{{xe_trans('xe::login')}}</button>
            </fieldset>
        </form>
    </div>
    <!-- //로그인 폼  -->
