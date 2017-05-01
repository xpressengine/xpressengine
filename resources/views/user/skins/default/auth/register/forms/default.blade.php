<h4>기본 정보 입력</h4>

<div class="auth-group {{--wrong--}}">
    <label for="email" class="sr-only">{{xe_trans('xe::email')}}</label>
    @if($email = data_get($data, 'email'))
    <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::enterEmail')}}" name="email" value="{{ $email }}" readonly>
    @else
    <input type="text" id="email" class="xe-form-control" placeholder="{{xe_trans('xe::enterEmail')}}" name="email" value="{{ old('email') }}">
    @endif

    {{--<em class="text-message">잘못된 이메일 형식입니다.</em>--}}
</div>
<div class="auth-group {{--wrong--}}">
    <label for="name" class="sr-only">{{xe_trans('xe::name')}}</label>
    <input type="text" id="name" class="xe-form-control" placeholder="{{xe_trans('xe::enterName')}}" name="displayName" value="{{ old('displayName') }}">
    {{--<em class="text-message">사용자 이름을 사용할 수 없습니다.</em>--}}
    {{--<!-- <em class="text-message">사용할 수 있는 사용자 이름입니다.</em> -->--}}
</div>
<div class="auth-group">
    <label for="pwd" class="sr-only">{{xe_trans('xe::password')}}</label>
    <input type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::enterPassword')}}" name="password">
    <em class="text-message">{{ xe_trans($passwordLevel['description']) }}</em>
    {{--<!-- <em class="text-message">올바른 비밀번호가 아닙니다.</em> -->--}}
</div>
<div class="auth-group {{--success--}}">
    <label for="pwd2" class="sr-only">{{xe_trans('xe::passwordConfirm')}}</label>
    <input type="password" id="pwd2" class="xe-form-control" placeholder="{{xe_trans('xe::passwordConfirm')}}" name="password_confirmation">
    <!-- 버튼 on 클래스로 아이콘 스타일 제어 -->
{{--<button type="button" class="btn-eye on"><i class="xi-eye"></i><i class="xi-eye-slash"></i></button>--}}
{{--<em class="text-message">비밀번호 확인</em>--}}
<!-- <em class="text-message">비밀번호가 일치하지 않습니다.</em> -->
</div>
