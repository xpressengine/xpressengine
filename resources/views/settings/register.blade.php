<?php
use Xpressengine\User\Models\User;
use Xpressengine\User\UserRegisterHandler;
?>
{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::css('assets/core/settings/css/admin.css')->load() }}

@section('page_title')
<h2>{{ xe_trans('xe::registerSettings') }}</h2>
@endsection

@section('page_description')
<small>{!! xe_trans('xe::registerSettingsDescription') !!}</small>
@endsection

<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="setting-area-group">
                <form method="post" action="{{route('settings.register.postSetting')}}">
                    {!! csrf_field() !!}
                    <!-- 각 세팅 박스 -->
                    <section class="setting-area">
                        <div class="setting-area__header">
                            <h3 class="setting-area__header-title">{{ xe_trans('xe::joinSettings') }}</h3>
                        </div>

                        <div class="setting-area__body">
                            {{-- 가입 설정 --}}
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">가입설정</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <label class="xu-label-checkradio">
                                            <input type="checkbox" name="joinable" @if ($config->get('joinable') == true) checked @endif>
                                            <span class="xu-label-checkradio__helper"></span>
                                            <span class="xu-label-checkradio__text">{{xe_trans('xe::permitSignUp')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- 가입 승인 절차 --}}
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">가입절차</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process"
                                                value="{{ User::STATUS_ACTIVATED }}"
                                                @if ($config->get('register_process') == User::STATUS_ACTIVATED) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">자동가입</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process"
                                                value="{{ User::STATUS_PENDING_ADMIN }}"
                                                @if ($config->get('register_process') == User::STATUS_PENDING_ADMIN) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">관리자 승인 후 가입</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process"
                                                value="{{ User::STATUS_PENDING_EMAIL }}"
                                                @if ($config->get('register_process') == User::STATUS_PENDING_EMAIL) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">이메일 인증 후 가입</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 약관 동의 --}}
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">약관동의</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type"
                                                value="{{UserRegisterHandler::TERM_AGREE_PRE}}"
                                                @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_PRE) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">가입시 약관 동의 단계 거치기(권장)</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type"
                                                value="{{UserRegisterHandler::TERM_AGREE_WITH}}"
                                                @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_WITH) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">약관 동의 단계 대신 회원정보 입력 하단에 약관동의 문구 표시</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type"
                                                value="{{UserRegisterHandler::TERM_AGREE_NOT}}"
                                                @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_NOT) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">약관 동의를 사용하지 않음</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 가입 안내문 --}}
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">가입안내</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="xu-form-group" style="margin-bottom: 8px;">
                                            <div class="xu-form-group__box" style="width: 100%;">
                                                <textarea name="register_guide" class="xu-form-group__control" cols="33" rows="3" placeholder="예 : 아래 항목을 빠짐없이 입력해 주세요.">{{ $config->get('register_guide') }}</textarea>
                                            </div>
                                        </div>
                                        <p class="setting-box__text-info">회원가입시 정보입력 단계 상단에 표시될 내용입니다. (여러줄 입력 가능)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 기본 필드 & 확장 필드 --}}
                    <section class="setting-area">
                        <div class="setting-area__header">
                            <h3 class="setting-area__header-title">가입폼 관리</h3>
                        </div>

                        <div class="setting-area__body">
                            <div class="table-scroll">
                                {{-- 기본 필드 설정 --}}
                                <table class="admin-table admin-table__signup">
                                    <colgroup>
                                        <col class="col1" />
                                        <col class="col2" />
                                        <col class="col3" />
                                        <col class="col4" />
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>항목</th>
                                            <th class="text-align--center">사용</th>
                                            <th class="text-align--center">필수</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 이메일 --}}
                                        <tr>
                                            <td>{{ xe_trans('xe::email') }}</td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" checked>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" checked>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>

                                        {{-- 아이디 --}}
                                        <tr>
                                            <td>{{ xe_trans('xe::id') }}</td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" checked>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" checked>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>

                                        {{-- display name --}}
                                        <tr>
                                            <td>
                                                {{ xe_trans($config->get('display_name_caption')) }}
                                                <button type="button" class="xu-button xu-button--default __btn-setting-display-name" style="margin-left: 12px;">수정</button>

                                                <div class="__area-setting-display-name" style="display: none; padding: 18px 0;">
                                                    {!! uio('langText', ['langKey' => $config->get('display_name_caption'), 'name' => 'display_name_caption']) !!}

                                                    <label class="xu-label-checkradio">
                                                        <input type="checkbox" name="display_name_unique" @if ($config->get('display_name_unique') === true) checked @endif>
                                                        <span class="xu-label-checkradio__helper"></span>
                                                        <span class="xu-label-checkradio__text">중복 가입 방지</span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="use_display_name" @if ($config->get('use_display_name') === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox"  @if ($config->get('use_display_name') === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>

                                        {{-- password --}}
                                        <tr>
                                            <td>
                                                {{ xe_trans('xe::password') }}
                                                <button type="button" class="xu-button xu-button--default __btn-setting-password" style="margin-left: 12px;">정책수정</button>

                                                <div class="__area-setting-password" style="display: none; padding: 18px 0;">
                                                    최소 비밀번호 글자 수
                                                    <div class="xu-form-group" style="display: inline-block;">
                                                        <div class="xu-form-group__box" style="width: 80px;">
                                                            <input type="text" class="xu-form-group__control" name="password_rules[min]" value="{{ $passwordMinLength }}">
                                                        </div>
                                                    </div>
                                                    <div style="margin-top: 16px;">
                                                        <div>
                                                            <label class="xu-label-checkradio">
                                                                <input type="checkbox" name="password_rules[numeric]" @if (in_array('numeric', $passwordRules)) checked @endif>
                                                                <span class="xu-label-checkradio__helper"></span>
                                                                <span class="xu-label-checkradio__text">비밀번호에 숫자 포함</span>
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="xu-label-checkradio">
                                                                <input type="checkbox" name="password_rules[alpha]" @if (in_array('alpha', $passwordRules)) checked @endif>
                                                                <span class="xu-label-checkradio__helper"></span>
                                                                <span class="xu-label-checkradio__text">비밀번호에 문자 포함</span>
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="xu-label-checkradio">
                                                                <input type="checkbox" name="password_rules[special_char]" @if (in_array('special_char', $passwordRules)) checked @endif>
                                                                <span class="xu-label-checkradio__helper"></span>
                                                                <span class="xu-label-checkradio__text">비밀번호에 특수문자 포함</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" checked>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" checked>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- 사용자 정의 항목 -->
                            @include('user.settings.setting.dynamicFields')

                            <div class="setting-area__body">
                                @include('user.settings.setting.forms')
                            </div>
                        </div>
                    </section>
                    {{-- END:기본 필드 & 확장 필드 --}}


                    <!-- 전체 페이지 버튼 영역 -->
                    <div class="setting-button-box" style="text-align: right;">
                        <button type="submit" class="xu-button xu-button--primary xu-button--large">{{ xe_trans('xe::save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.container-fluid .container-fluid').parent('.container-fluid').removeClass('container-fluid')

        // --disabled 체크박스의 해제 제한
        $('.admin-table__signup').on('click change', '.xu-label-checkradio--disabled input:checkbox', function () {
            return false
        })

        // 이름, 패스워드 정책 수정 영역
        var $areaSettingDisplayName = $('.__area-setting-display-name')
        var $areaSettingPassword = $('.__area-setting-password')
        $('.__btn-setting-display-name').on('click', function () {
            $areaSettingDisplayName.toggle()
        })
        $('.__btn-setting-password').on('click', function () {
            $areaSettingPassword.toggle()
        })

        // 이메일|아이디 이벤트
        var $registerTypes = $('.__user-register-id-type')
        $registerTypes.on('change', toggleRegisterType)

        // 이메일, 아이디 항목 변경 시 토글
        function toggleRegisterType (e) {
            var $this = $(this)
            var type = $this.val()

            $registerTypes.each(function () {
                var $field = $(this)
                var fieldValue = $field.val()
                var $row = $(this).closest('tr')

                if ($this.is(this)) {
                    $row.find('[type=checkbox]')
                        .prop('checked', true)
                        .closest('.xu-label-checkradio')
                        .addClass('xu-label-checkradio--disabled')
                } else if( fieldValue === 'user_id') {
                    $row.find('[type=checkbox]')
                        .closest('.xu-label-checkradio')
                        .removeClass('xu-label-checkradio--disabled')
                }
            })
        }
    })
</script>
