@inject('passwordValidator', 'xe.password.validator')
{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::js('assets/core/user/user_register.js')->load() }}

<h1>{{ xe_trans('xe::privateInfoAndOptionSettings') }}</h1>
<p>{{xe_trans('xe::privateInfoAndOptionSettingsDescription')}}</p>
<div class="setting-card">

    <h2>{{ xe_trans('xe::default') }} {{ xe_trans('xe::information') }}</h2>
    <div class="__xe_setting __xe_settingEmail" data-origin-email="{{ $user->email }}">
        <div class="setting-group">
            <!--[D] a 링크 클릭 시 뒤에 오는 setting-detail block 처리,같은 카드 내 block처리된 부분도 none 처리   -->
            <a href="#" class="__xe_editBtn">
                <div class="setting-left">
                    <!--[D] 변경내용 저장 후 변경 값으로 저장  -->
                    <p>{{ xe_trans('xe::emailAddress') }}</p><em class="text-gray">{{ $user->email }}</em>
                </div>
            </a>
        </div>
        <div class="setting-detail" style="display: none;">
            <div class="setting-detail-content">
                <p>{{ xe_trans('xe::account') }} {{ xe_trans('xe::email') }}</p>
                <em class="text-gray2">{{ xe_trans('xe::canSetupEmails') }}</em>

                <div class="__xe_mailList">
                    @foreach($user->emails as $mail)
                        <div class="xe-form-inline __xe_mailItem" data-email="{{ $mail->address }}">
                            <label class="xe-label">
                                <input type="radio" id="__xe_chk_mail_{{ $mail->id }}" name="email" value="{{ $mail->address }}" {{ $user->email === $mail->address ? 'checked' : '' }} >
                                <span class="xe-input-helper"></span>
                            <!--[D] 체크 시 inpt_chk에  on 클래스 추가-->
                                <span class="xe-label-text">{{ $mail->address }}</span>
                            </label>
                            @if($user->email !== $mail->address)
                            <span class="dot"> · </span>
                            <button class="xe-btn xe-btn-link __xe_wantDeleteBtn">{{ xe_trans('xe::delete') }}</button>
                            <span class="__xe_confirmDelete" style="display: none">
                                <span>{{ xe_trans('xe::confirmDelete') }}</span>
                                <button class="xe-btn xe-btn-link __xe_deleteConfirmBtn" data-email="{{ $mail->address }}">{{ xe_trans('xe::confirm') }}</button>
                                <button class="xe-btn xe-btn-link __xe_deleteCancelBtn">{{ xe_trans('xe::cancel') }}</button>
                            </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if($pending = $user->getPendingEmail())

                <!--메일추가 이후 화면,<p>메일 추가하기</p> 텍스트는 유지 됨-->
            <div class="setting-detail-content __xe_confirmEmailBox">
                <p>{{ xe_trans('xe::pendingEmail') }}</p>
                <em class="text-gray3">{!! xe_trans('xe::checkEmailForConfirmCode', ['email' => $pending->address]) !!}</em><br>

                <div class="xe-form-inline">
                    <div class="xe-input-group">
                        <input type="text" class="__xe_confirmCodeInput xe-form-control">
                        <span class="xe-input-group-btn">
                            <button class="__xe_confirmCodeBtn xe-btn xe-btn-secondary" type="button">{{ xe_trans('xe::confirmation') }}</button>
                        </span>
                    </div>
                    <button class="btn xe-btn xe-btn-link __xe_resendConfirmBtn" data-email="{{ $pending->address }}">{{ xe_trans('xe::resendEmail') }}</button>
                    <button class="btn xe-btn xe-btn-link __xe_deletePendingBtn" data-email="{{ $pending->address }}">{{ xe_trans('xe::delete') }}</button>
                </div>
                <em class="text-message">&nbsp;</em>
            </div>

            @else

            <div class="setting-detail-content __xe_addEmailBox">
                <p>{{ xe_trans('xe::addMail') }}</p>
                <div class="xe-form-inline">
                    <div class="xe-form-group">
                        <input type="text" class="xe-form-control __xe_addInput">
                    </div>
                    <button class="__xe_addBtn xe-btn xe-btn-primary-outline">{{ xe_trans('xe::add') }}</button>
                </div>
                <em class="text-message __xe_message">&nbsp;</em>
            </div>

            @endif

            <div class="xe-btn-group-all">
                <button class="__xe_saveBtn xe-btn xe-btn-primary">{{ xe_trans('xe::applyModified') }}</button>
                <button class="__xe_cancelBtn xe-btn xe-btn-secondary">{{ xe_trans('xe::cancel') }}</button>
            </div>
        </div>
    </div>

    <div class="setting-group">
        <div class="setting-detail">
            <div class="setting-detail-content">
                <p>{{ xe_trans('xe::id') }}</p>
                <em class="text-gray2" style="margin-bottom: 0px;">{{ $user->login_id }}</em>
            </div>
        </div>
    </div>

    <div class="__xe_setting __xe_settingDisplayName" data-origin-name="{{ $user->getDisplayName() }}" data-init-name="{{ old('name', $user->getDisplayName()) }}">
        <div class="setting-group">
            <a href="#" class="__xe_editBtn">
                <div class="setting-left">
                    <p>{{ xe_trans('xe::userName') }}</p>
                    <em class="__xe_displayName text-gray">{{ $user->getDisplayName() }}</em>
                </div>
            </a>
        </div>
        <div class="setting-detail" style="display: none;">
            <div class="setting-detail-content">
                <p>{{ xe_trans('xe::changeUserName') }}</p>
                <em class="text-gray2">{{ xe_trans('xe::canChangeUserName') }}</em>
                <input type="text" class="__xe_nameInput xe-form-control" name="name" value="{{ $user->getDisplayName() }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <em class="__xe_message text-message"></em>
            </div>
            <div class="xe-btn-group-all">
                <button class="__xe_saveBtn xe-btn xe-btn-primary">{{ xe_trans('xe::applyModified') }}</button>
                <button class="__xe_cancelBtn xe-btn xe-btn-secondary">{{ xe_trans('xe::cancel') }}</button>
            </div>
        </div>
    </div>

    <div class="__xe_setting __xe_settingPassword">
        <div class="setting-group">
            <a href="#" class="__xe_editBtn">
                <div class="setting-left">
                    <p>{{ xe_trans('xe::password') }}</p>
                    <em class="text-gray">
                        @if($user->password)
                            {!! xe_trans('xe::changedAt', ['time' => '<span title="'.$user->password_updated_at->format('Y-m-d H:i:s').'" data-xe-timeago="'.$user->password_updated_at.'">"'.$user->password_updated_at->format('Y-m-d H:i:s').'"</span>' ]) !!}.
                        @else
                            {{ xe_trans('xe::passwordNotRegisterd') }}
                        @endif
                    </em>
                </div>
            </a>
        </div>
        <div class="setting-detail" style="display: none;">
            <div class="setting-detail-content">
                <p>{{ xe_trans('xe::changePassword') }}</p>
                <em class="text-gray2">{{ $passwordValidator->getMessage() }}</em>
                @if($user->password)
                    <div class="password-content __xe_currentPassword">
                        <p class="txt_pw">{{ xe_trans('xe::currentPassword') }}</p>
                        <input type="password" class="xe-form-control" name="current_password">
                        <em class="text-message">&nbsp;</em>
                    </div>
                @endif
                <div class="password-content xu-form-group __xe_newPassword">
                    <p class="txt_pw">{{ xe_trans('xe::newPassword') }}</p>
                    <input type="password" class="xe-form-control" name="password">
                    <em class="text-message">&nbsp;</em>
                </div>
                <div class="password-content xu-form-group __xe_passwordConfirm">
                    <p class="txt_pw">{{ xe_trans('xe::newPasswordConfirm') }}</p>
                    <input type="password" class="xe-form-control" name="password_confirmation">
                    <p class="text-message">&nbsp;</p>
                </div>
            </div>
            <div class="xe-btn-group-all">
                <button class="__xe_saveBtn xe-btn xe-btn-primary">{{ xe_trans('xe::applyModified') }}</button>
                <button class="__xe_cancelBtn xe-btn xe-btn-secondary">{{ xe_trans('xe::cancel') }}</button>
            </div>
        </div>
    </div>

</div>

@if($fieldTypes)
<div class="setting-card">
    <h2>{{ xe_trans('xe::customItems') }}</h2>
    @foreach($fieldTypes as $id => $fieldType)

        <div class="__xe_setting __xe_settingAddition __xe_settingAddition-{{ $id }}">
            <div class="setting-group">
                @include($_skin::view('show-field', compact('id', 'fieldType', 'user')))
            </div>
            <div class="setting-detail" style="display: none;">
            </div>
        </div>

    @endforeach
</div>
@endif

<div class="setting-card">
    <h2>{{ xe_trans('xe::deleteAccount') }}</h2>
    <div class="__xe_setting __xe_settingLeave">
        <div class="setting-group setting-account">
            <div class="setting-group-content">
                <div class="setting-left">
                    <p>{{ xe_trans('xe::confirmNeedAccountDeletion') }}</p>
                    <em class="text-gray">{{ xe_trans('xe::warningAboutAccountDeletion') }}</em>
                </div>
                <div class="setting-right">
                    <button class="__xe_editBtn xe-btn xe-btn-link text-blue">{{ xe_trans('xe::deleteOk') }}</button>
                </div>
            </div>
        </div>
        <div class="setting-detail" style="display: none;">
            <form method="post" class="__xe_form" action="{{ route('user.settings.leave') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="setting-detail-content">
                    <p>{{xe_trans('xe::accountDeleteCaution')}}</p>
                    <em class="text-gray">{{xe_trans('xe::accountDeleteCautionDescription')}}</em>
                    <ul class="acount-list">
                        <li>{{xe_trans('xe::accountDeleteCaution1')}}</li>
                    </ul>
                    <label class="xe-label">
                        <input type="checkbox" id="__xe_chkLeave" name="confirm_leave" value="Y">
                        <span class="xe-input-helper"></span>
                        <span class="xe-label-text">{{xe_trans('xe::agreeAccountDeleteCaution')}}</span>
                        <em class="text-message __xe_message">&nbsp;</em>
                    </label>
                </div>
                <div class="xe-btn-group-all">
                    <button class="__xe_saveBtn xe-btn xe-btn-primary">{{ xe_trans('xe::confirm') }}</button>
                    <button class="__xe_cancelBtn xe-btn xe-btn-secondary">{{ xe_trans('xe::cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function($) {

        window.openSetting = function(data) {
            var id = data.data.id;
            $('.__xe_settingAddition-'+id+' .setting-group').hide();
            $('.__xe_settingAddition-'+id+' .setting-detail').show();
        }

        window.closeSetting = function(data) {
            var id = data.field;
            var url = data.showUrl;
            XE.page(url, '.__xe_settingAddition-'+id+' .setting-group', {}, function(){
                $('.__xe_settingAddition-'+id+' .setting-group').show();
                $('.__xe_settingAddition-'+id+' .setting-detail').hide();
            })
        }

        $('.__xe_settingAddition').on('click', '.__xe_setting-close', function(){
            var id = $(this).data('field');
            var url = $(this).parents('form').attr('action');
            closeSetting({field: id, showUrl: url});
        });
    });
</script>
