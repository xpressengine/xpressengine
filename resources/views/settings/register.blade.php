<?php
use Xpressengine\User\Models\User;
use Xpressengine\User\UserRegisterHandler;
?>

@section('page_title')
    <h2>{{ xe_trans('xe::registerSettings') }}</h2>
@endsection

@section('page_description')
    <small>{!! xe_trans('xe::registerSettingsDescription') !!}</small>
@endsection

<div class="panel-group">
    <form method="post" action="{{route('settings.register.postSetting')}}">
        {!! csrf_field() !!}
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">가입설정</h3>
                </div>
            </div>

            <div class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            가입설정
                        </div>

                        <div class="col-sm-8">
                            <input type="checkbox" name="joinable" value="true" @if ($config->get('joinable') == true) checked @endif> 로그인/회원 가입 사용
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            가입절차
                        </div>
                        <div class="col-sm-8">
                            <input type="radio" name="register_process"
                                   value="{{User::STATUS_ACTIVATED}}"
                                   @if ($config->get('register_process') == User::STATUS_ACTIVATED) checked @endif>자동가입
                            <input type="radio" name="register_process"
                                   value="{{User::STATUS_PENDING_ADMIN}}"
                                   @if ($config->get('register_process') == User::STATUS_PENDING_ADMIN) checked @endif>관리자 승인 후 가입
                            <input type="radio" name="register_process"
                                   value="{{User::STATUS_PENDING_EMAIL}}"
                                   @if ($config->get('register_process') == User::STATUS_PENDING_EMAIL) checked @endif>이메일 인증 후 가입
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            약관동의
                        </div>
                        <div class="col-sm-8">
                            <input type="radio" name="term_agree_type" value="{{UserRegisterHandler::TERM_AGREE_PRE}}"
                                   @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_PRE) checked @endif> 가입시 약관 동의 단계 거치기(권장)
                            <input type="radio" name="term_agree_type" value="{{UserRegisterHandler::TERM_AGREE_WITH}}"
                                   @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_WITH) checked @endif> 약관 동의 단계 대신 회원정보 입력 하단에 약관동의 문구 표시
                            <input type="radio" name="term_agree_type" value="{{UserRegisterHandler::TERM_AGREE_NOT}}"
                                   @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_NOT) checked @endif> 약관 동의를 사용하지 않음
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            가입안내
                        </div>
                        <div class="col-sm-8">
                            <textarea name="register_guide">{{$config->get('register_guide')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pull-right">
            <button type="submit" class="xe-btn xe-btn-positive">{{xe_trans('xe::save')}}</button>
        </div>
    </form>
</div>
