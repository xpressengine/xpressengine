<?php
use Xpressengine\User\Models\User;
use Xpressengine\User\UserRegisterHandler;
?>
{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::css('assets/core/settings/css/admin.css')->load() }}
{{ XeFrontend::js('assets/core/settings/js/register.js')->appendTo('head')->load() }}

@expose_trans('xe::passwordIncludeNumber')
@expose_trans('xe::passwordIncludeCharacter')
@expose_trans('xe::passwordIncludeSpecialCharacter')

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
                                        <h4 class="setting-box__sub-title">{{ xe_trans('xe::registerSettings') }}</h4>
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
                                        <h4 class="setting-box__sub-title">{{ xe_trans('xe::registerProcess') }}
                                            <button type="button" class="setting-box__sub-title-more-info-button" data-toggle="popover" data-popover-content="#popoverSingupProcess" data-placement="bottom">
                                                <i class="xi-help-o"></i>
                                            </button>
                                            <div id="popoverSingupProcess" style="display: none;">
                                                <div class="popover-body">
                                                    <div class="setting-box__popover-content">
                                                        <ul class="setting-box__popover-content-list">
                                                            <li>
                                                                <strong class="setting-box__popover-title">{{ xe_trans('xe::authRegister') }}</strong>
                                                                <p class="setting-box__popover-text">{{ xe_trans('xe::autoRegisterDescription') }}</p>
                                                            </li>
                                                            <li>
                                                                <strong class="setting-box__popover-title">{{ xe_trans('xe::pending_admin_description') }}</strong>
                                                                <p class="setting-box__popover-text">{{ xe_trans('xe::pendingAdminDescription') }}</p>
                                                            </li>
                                                            <li>
                                                                <strong class="setting-box__popover-title">{{ xe_trans('xe::pending_email_description') }}</strong>
                                                                <p class="setting-box__popover-text">{{ xe_trans('xe::pendingEmailDescription') }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process"
                                                value="{{ User::STATUS_ACTIVATED }}"
                                                @if ($config->get('register_process') == User::STATUS_ACTIVATED) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::authRegister') }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process"
                                                value="{{ User::STATUS_PENDING_ADMIN }}"
                                                @if ($config->get('register_process') == User::STATUS_PENDING_ADMIN) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::pending_admin_description') }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process"
                                                value="{{ User::STATUS_PENDING_EMAIL }}"
                                                @if ($config->get('register_process') == User::STATUS_PENDING_EMAIL) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::pending_email_description') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 약관 동의 --}}
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">{{ xe_trans('xe::termAgreeProcess') }}</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type"
                                                value="{{UserRegisterHandler::TERM_AGREE_PRE}}"
                                                @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_PRE) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::termAgreeTypePre') }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type"
                                                value="{{UserRegisterHandler::TERM_AGREE_WITH}}"
                                                @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_WITH) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::termAgreeTypeWith') }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type"
                                                value="{{UserRegisterHandler::TERM_AGREE_NOT}}"
                                                @if ($config->get('term_agree_type') == UserRegisterHandler::TERM_AGREE_NOT) checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::disableTermAgree') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 가입 안내문 --}}
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">{{ xe_trans('xe::registerGuide') }}</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="xu-form-group" style="margin-bottom: 8px;">
                                            <div class="xu-form-group__box" style="width: 100%;">
                                                <textarea name="register_guide" class="xu-form-group__control" cols="33" rows="3" placeholder="{{ xe_trans('xe::registerGuideExample') }}">{{ $config->get('register_guide') }}</textarea>
                                            </div>
                                        </div>
                                        <p class="setting-box__text-info">{{ xe_trans('xe::registerGuideDescription') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 기본 필드 & 확장 필드 --}}
                    <section class="setting-area">
                        <div class="setting-area__header">
                            <h3 class="setting-area__header-title">{{ xe_trans('xe::manegeRegisterForm') }}</h3>
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
                                            <th>{{ xe_trans('xe::item') }}</th>
                                            <th class="text-align--center">{{ xe_trans('xe::use') }}</th>
                                            <th class="text-align--center">{{ xe_trans('xe::require') }}</th>
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

                                        {{-- 아이디 (login_id) --}}
                                        <tr class="__regsetting-loginid-wrap">
                                            <td>{{ xe_trans('xe::id') }}</td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input name="use_login_id" type="checkbox" @if (app('xe.user')->isUseLoginId() === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input name="require_login_id" type="checkbox" @if (app('xe.user')->isUseLoginId() === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>

                                        {{-- display name --}}
                                        <tr class="__regsetting-displayname-wrap">
                                            <td>
                                                <div>
                                                    <div class="__regsetting-displayname">
                                                        <span class="__regsetting-display-caption">{{ xe_trans($config->get('display_name_caption')) }}</span>
                                                        <button type="button" class="xu-button xu-button--default __regsetting-displayname-editbtn" style="margin-left: 12px;">{{ xe_trans('xe::modify') }}</button>
                                                    </div>

                                                    <div class="__regsetting-displayname-editform" style="display: none;">
                                                        <div class="__area-setting-display-name" style="padding: 18px 0;">
                                                            <div style="width: 200px;">
                                                                {!! uio('langText', ['langKey' => $config->get('display_name_caption'), 'name' => 'display_name_caption']) !!}
                                                            </div>

                                                            <label class="xu-label-checkradio">
                                                                <input type="checkbox" name="display_name_unique" @if ($config->get('display_name_unique') === true) checked data-origin-checked="true" @endif>
                                                                <span class="xu-label-checkradio__helper"></span>
                                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::displayNameUnique') }}</span>
                                                            </label>

                                                            <div style="margin-top: 16px;">
                                                                <button type="button" class="xu-button xu-button--primary __regsetting-displayname-midify">{{ xe_trans('xe::confirm') }}</button>
                                                                <button type="button" class="xu-button xu-button--subtle __regsetting-displayname-reset">{{ xe_trans('xe::cancel') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                    <input type="checkbox" name="require_display_name" @if ($config->get('use_display_name') === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>

                                        {{-- password --}}
                                        <tr>
                                            <td>
                                                {{ xe_trans('xe::password') }}
                                                <button type="button" class="xu-button xu-button--default __btn-setting-password" style="margin-left: 12px;">{{ xe_trans('xe::policy') }} {{ xe_trans('xe::modify') }}</button>

                                                <div class="__area-setting-password" style="display: none; padding: 18px 0;">
                                                    {{ xe_trans('xe::minimumPasswordLength') }}
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
                                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::passwordIncludeNumber') }}</span>
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="xu-label-checkradio">
                                                                <input type="checkbox" name="password_rules[alpha]" @if (in_array('alpha', $passwordRules)) checked @endif>
                                                                <span class="xu-label-checkradio__helper"></span>
                                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::passwordIncludeCharacter') }}</span>
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="xu-label-checkradio">
                                                                <input type="checkbox" name="password_rules[special_char]" @if (in_array('special_char', $passwordRules)) checked @endif>
                                                                <span class="xu-label-checkradio__helper"></span>
                                                                <span class="xu-label-checkradio__text">{{ xe_trans('xe::passwordIncludeSpecialCharacter') }}</span>
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
                                        {{-- password_confirm --}}
                                        <tr class="__regsetting-passwordconfirm-wrap">
                                            <td>
                                                {{ xe_trans('xe::passwordConfirm') }}
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input name="use_password_confirm" type="checkbox" @if ($config->get('use_password_confirm') === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input name="require_password_confirm" type="checkbox" @if ($config->get('use_password_confirm') === true) checked @endif>
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- 사용자 정의 항목 -->
                            @include('user.settings.setting.dynamicFields')
                        </div>
                    </section>
                    {{-- END:기본 필드 & 확장 필드 --}}

                    <section class="setting-area">
                        <div class="setting-area__header">
                            <h3 class="setting-area__header-title">{{ xe_trans('xe::advancedSetting') }}</h3>
                        </div>
                        <div class="setting-area__body">
                            @include('user.settings.setting.forms')
                        </div>
                    </section>

                    <!-- 전체 페이지 버튼 영역 -->
                    <div class="setting-button-box" style="text-align: right;">
                        <button type="submit" class="xu-button xu-button--primary xu-button--large">{{ xe_trans('xe::save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="xe-modal __xe-udfield-modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="xe-modal">&times;</button>
                <h4 class="modal-title">{{xe_trans('xe::customItems')}}</h4>
            </div>
            <div class="modal-body">
                <p><!-- form --></p>
            </div>
            <div class="xe-modal-footer">
                <button type="button" class="xe-btn xe-btn-secondary __xe-udfield-modal-close" data-dismiss="xe-modal">{{xe_trans('xe::cancel')}}</button>
                <button type="button" class="xe-btn xe-btn-primary __xe-udfield-modal-submit">{{xe_trans('xe::save')}}</button>
            </div>
        </div>
    </div>
</div>

<form class="__xe-udfield-form" action="{{ route('manage.dynamicField.store') }}" style="display:none" data-rule="dynamicFieldSection">
    <input type="hidden" name="group" value="user" />
    <div class="step">
        <div class="form-group">
            <label for="">{{xe_trans('xe::type')}}</label>
            <select name="typeId" class="form-control __xe_type_id">
                <option value="">{{xe_trans('xe::select')}}</option>
                @foreach($fieldTypes as $fieldType)
                <option value="{{ $fieldType::getId() }}">{{ $fieldType->name() }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">{{xe_trans('xe::id')}}</label>
            <small>{{xe_trans('xe::dynamicFieldIdDescription')}}</small>
            <input type="text" name="id" class="form-control">
        </div>
    </div>
    <div class="step">
        <div class="form-group">
            <label for="">{{xe_trans('xe::label')}}</label>
            <small>{{xe_trans('xe::dynamicFieldLabelDescription')}}</small>
            <div class="dynamic-lang-editor-box" data-name="label" data-lang-key="" data-valid-name="Label"></div>
        </div>
        <div class="form-group">
            <label for="">{{xe_trans('xe::dynamicFieldLabelDetailTitle')}}</label>
            <small>{{xe_trans('xe::dynamicFieldLabelDetailDescription')}}</small>
            <div class="dynamic-lang-editor-box" data-name="placeholder" data-lang-key="" data-valid-name="placeholder"></div>
        </div>
        <div class="form-group">
            <input type="hidden" name="use" value="true" />
            <input type="hidden" name="required" value="true" />
            <input type="hidden" name="sortable" value="true" />
            <input type="hidden" name="searchable" value="true" />
            <div class="checkbox mg-reset mg-bottom">
                <label>
                    <input type="checkbox" class="__xe_checkbox-config" data-name="use" checked="checked"/>
                    {{xe_trans('xe::use')}}
                </label>
                <small>{{xe_trans('xe::dynamicFieldUseDescription')}}</small>
            </div>
            <div class="checkbox mg-reset mg-bottom">
                <label>
                    <input type="checkbox" class="__xe_checkbox-config" data-name="required" checked="checked"/>
                    {{xe_trans('xe::inputRequired')}}
                </label>
                <small>{{xe_trans('xe::dynamicFieldRequiredDescription')}}</small>
            </div>
            <div class="checkbox mg-reset mg-bottom">
                <label>
                    <input type="checkbox" class="__xe_checkbox-config" data-name="searchable" checked="checked"/>
                    {{xe_trans('xe::searchable')}}
                </label>
                <small>{{xe_trans('xe::dynamicFieldSearchableDescription')}}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="">Skin</label>
            <select name="skinId" class="form-control __xe_skin_id" disabled="disabled">
                <option value="">Select Type for getting skin options</option>
            </select>
        </div>
    </div>
    <div class="step __xe_additional_configure">
    </div>
</form>

@expose_route('manage.dynamicField.index')
@expose_route('manage.dynamicField.store')
@expose_route('manage.dynamicField.update')
@expose_route('manage.dynamicField.getEditInfo')
@expose_route('manage.dynamicField.destroy')
@expose_route('manage.dynamicField.getSkinOption')
@expose_route('manage.dynamicField.getAdditionalConfigure')

<script>
    // var dynamicFieldData = {
    //     group: "user",
    //     databaseName: "mysql"
    // };

    // 누적된 룰을 제거하고, 새로운 룰만 추가
    XE.Validator.$$on('setRules', function (eventName, ruleName, rules, additional, origin, reassign) {
        if (ruleName === 'dynamicFieldSection') {
            reassign($.extend({}, origin, additional))
        }
    })

    $(function () {
        $('#__xe_container_DF_setting_user').userRegisterDynamicFiled({
            group: 'user',
            databaseType: 'mysql'
        })

        XE.Validator.put('df_id', function ($dst, parameters) {
            var value = $dst.val();

            var pattern = /^[a-zA-Z]+([a-zA-Z0-9_]+)?[a-zA-Z0-9]+$/;
            if (value && !value.match(pattern)) {
                XE.Validator.error($dst, XE.Lang.trans('xe::validation.df_id', {attribute: $dst.data('valid-name') || $dst.attr('name')}));
                return false;
            }

            return true;
        });

        $("[data-toggle=popover]").popover({
            html : true,
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
            },
            title: function() {
                var titleResult = '';
                var title = $(this).attr("data-popover-content");
                var titleLength = $(title).children(".popover-heading").length;

                if(titleLength > 0) {
                    titleResult = $(title).children(".popover-heading").html();
                } else {
                    titleResult = '';
                }

                return titleResult;
            }
        });
    });
</script>
