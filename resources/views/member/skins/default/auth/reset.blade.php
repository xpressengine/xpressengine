@if(Session::get('status') !== 'passwords.sent')
    <!-- 비밀번호 찾기 1step, 비밀번호 찾기 시 find-password 클래스 추가 인풋간 간격 넓어짐(제외가능)-->
<div class="member find-password">
    <h1>{{xe_trans('xe::forgotPassword')}}</h1>

    <p class="sub-text">{{xe_trans('xe::forgotPasswordDescription')}}</p>

    <form role="form" method="post" action="{{ route('auth.reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <legend>{{xe_trans('xe::findPassword')}}</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="email" class="sr-only">{{xe_trans('xe::email')}}</label>
                <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::email')}}" name="email" value="{{ old('email') }}">
                {{--<em class="text-message">이메일을 입력하세요.</em>--}}
            </div>
            <button class="xe-btn xe-btn-primary">{{xe_trans('xe::next')}}</button>
        </fieldset>
    </form>
    <a href="{{ route('login') }}" class="xe-btn xe-btn-link v2">{{xe_trans('xe::login')}}</a>
</div>
<!-- // 비밀번호 찾기 1step-->

@else

<!-- 비밀번호 찾기 2step-->
<div class="member find-password">
    <h1>{{xe_trans('xe::msgEmailSendComplete')}}</h1>
    <div class="info">
        <p>{!! xe_trans('xe::checkFindPasswordEmailDescription', ['email' => sprintf('<em>%s</em>', $email)]) !!}</p>
        <em class="info-title">{{xe_trans('xe::checkSentEmail')}}</em>
        {{--<em class="info-title">이메일을 수신하지 못했습니까?</em><br>
        <p>accounts-noreply@xpressengine.com으로부터 수신된 메시지에 대해 스팸 또는 벌크 폴더를 확인하십시오.</p>--}}
    </div>
    <a href="{{ route('login') }}" class="btn xe-btn-text v2">{{xe_trans('xe::login')}}</a>
</div>
<!-- // 비밀번호 찾기 2step-->

@endif
