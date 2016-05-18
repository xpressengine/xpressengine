<h1>{{ xe_trans('xe::privateInfoAndOptionSettings') }}</h1>
<p>개인정보를 관리할 수 있습니다. 이메일 주소, 닉네임, 외부로그인 등을 설정하여 계정에 저장할 데이터를 관리하고 개인정보를 보호할 수 있습니다.</p>
<div class="setting-card">
    <h2>{{ xe_trans('xe::defaultSettings') }}</h2>

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
                        <div class="xe-form-group __xe_mailItem" data-email="{{ $mail->address }}">
                            <input type="radio" id="__xe_chk_mail_{{ $mail->id }}" name="email" value="{{ $mail->address }}" {{ $user->email === $mail->address ? 'checked' : '' }} >
                            <!--[D] 체크 시 inpt_chk에  on 클래스 추가-->
                            <label for="__xe_chk_mail_{{ $mail->id }}"><span>{{ $mail->address }}</span></label>
                            @if($user->email !== $mail->address)
                                <span class="dot"> · </span>
                                <button class="xe-btn-text __xe_wantDeleteBtn">{{ xe_trans('xe::delete') }}</button>
                                <span class="__xe_confirmDelete" style="display: none">
                            <span>{{ xe_trans('xe::confirmDelete') }}</span>
                            <button class="xe-btn-text __xe_deleteConfirmBtn" data-email="{{ $mail->address }}">{{ xe_trans('xe::confirm') }}</button>
                            <button class="xe-btn-text __xe_deleteCancelBtn">{{ xe_trans('xe::cancel') }}</button>
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
                <div class="form_group">
                    <input type="text" class="__xe_confirmCodeInput xe-form-control v2">
                    <button class="__xe_confirmCodeBtn xe-btn xe-btn-secondary">{{ xe_trans('xe::confirmation') }}</button>
                </div>
                <div class="btn_group text-group">
                    <button class="btn xe-btn-text __xe_resendConfirmBtn" data-email="{{ $pending->address }}">{{ xe_trans('xe::resendEmail') }}</button>
                    <button class="btn xe-btn-text __xe_deletePendingBtn" data-email="{{ $pending->address }}">{{ xe_trans('xe::delete') }}</button>
                </div>
                <em class="text-message">&nbsp;</em>
            </div>

            @else

                <!--[D] 잘못표기 시 클래스 wrong 추가-->
            <div class="setting-detail-content __xe_addEmailBox">
                <p>{{ xe_trans('xe::addMail') }}</p>
                <input type="text" class="xe-form-control __xe_addInput">
                <div class="btn_group">
                    <button class="__xe_addBtn xe-btn xe-btn-primary-outline">{{ xe_trans('xe::save') }}</button>
                    <button class="__xe_addCancelBtn xe-btn">{{ xe_trans('xe::cancel') }}</button>
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

    <div class="__xe_setting __xe_settingDisplayName" data-origin-name="{{ $user->getDisplayName() }}" data-init-name="{{ old('name', $user->getDisplayName()) }}">
        <div class="setting-group">
            <a href="#" class="__xe_editBtn">
                <div class="setting-left">
                    <p>{{ xe_trans('xe::memberName') }}</p>
                    <em class="__xe_displayName text-gray">{{ $user->getDisplayName() }}</em>
                </div>
            </a>
        </div>
        <div class="setting-detail" style="display: none;">
            <div class="setting-detail-content">
                <p>{{ xe_trans('xe::changeMemberName') }}</p>
                <em class="text-gray2">{{ xe_trans('xe::canChangeMemberName') }}</em>
                <input type="text" class="__xe_nameInput xe-form-control" name="name" value="{{ $user->getDisplayName() }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <em class="__xe_message text-message">{{ xe_trans('xe::isYourCurrentName') }}</em>
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
                            {!! xe_trans('xe::changedAt', ['time' => '<span title="'.$user->passwordUpdatedAt->format('Y-m-d H:i:s').'" data-xe-timeago="'.$user->passwordUpdatedAt.'">"'.$user->passwordUpdatedAt->format('Y-m-d H:i:s').'"</span>' ]) !!}.
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
                <em class="text-gray2">{{ $passwordLevel['description'] }}</em>
                <div class="password-content __xe_currentPassword" @if(!$user->password) style="display: none;" @endif>
                    <p class="txt_pw">{{ xe_trans('xe::currentPassword') }}</p>
                    <input type="password" class="xe-form-control" name="current_password">
                    <em class="text-message">&nbsp;</em>
                </div>
                <div class="password-content __xe_newPassword">
                    <p class="txt_pw">{{ xe_trans('xe::newPassword') }}</p>
                    <input type="password" class="xe-form-control" name="password">
                    <em class="text-message">&nbsp;</em>
                    <em class="__xe_secure text-message" style="display: none;">{{ xe_trans('xe::passwordStrength') }}: <span class="__xe_low txt_red">{{ xe_trans('xe::weak') }}</span> <span class="__xe_normal">{{ xe_trans('xe::normal') }}</span> <span class="__xe_high txt_blue">{{ xe_trans('xe::strong') }}</span></em>
                </div>
                <div class="password-content __xe_passwordConfirm">
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
                    <button class="__xe_editBtn xe-btn-text txt_blue">{{ xe_trans('xe::deleteOk') }}</button>
                </div>
            </div>
        </div>
        <div class="setting-detail" style="display: none;">
            <form method="post" class="__xe_form" action="{{ route('member.settings.leave') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="setting-detail-content">
                    <p>계정 삭제가 의미하는 내용</p>
                    <em class="text-gray">계정을 삭제하기 전에 아래의 약관을 읽어 보시기 바랍니다.</em>
                    <ul class="acount-list">
                        <li>계정 삭제 작업은 영구적이며 되돌릴 수 없습니다. 삭제하는 즉시 귀하의 계정에 액세스할 수 없게 됩니다. </li>
                        <li>귀하의 모든 콘텐츠가 삭제됩니다.</li>
                        <li>댓글, 메시지, 토론 게시글 등을 포함한 모든 정보가 삭제됩니다.</li>
                        <li>아무도 다시는 귀하의 계정정보나 게시글에 액세스할 수 없게 됩니다.</li>
                    </ul>
                    <div class="xe-form-group">
                        <input type="checkbox" id="__xe_chkLeave" name="confirm_leave" value="Y">
                        <label for="__xe_chkLeave" class=""><span>약관에 동의하며 내 계정을 영구적으로 삭제하겠습니다.</span></label>
                        <em class="text-message __xe_message">&nbsp;</em>
                    </div>
                </div>
                <div class="xe-btn-group-all">
                    <button class="__xe_saveBtn xe-btn xe-btn-primary">{{ xe_trans('xe::applyModified') }}</button>
                    <button class="__xe_cancelBtn xe-btn xe-btn-secondary">{{ xe_trans('xe::cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
