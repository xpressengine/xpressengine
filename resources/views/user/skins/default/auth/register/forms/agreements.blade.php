<div class="xe-input-group">
    <label class="xe-label">
        <input type="checkbox" name="agree">
        <span class="xe-input-helper"></span>
        <span class="xe-label-text">
            {!! xe_trans('xe::agreeSiteTermsUseAndSitePrivacyPolicy', ['termLink' => '#', 'policyLink' => '#']) !!}
        </span>
    </label>
    <!--[D] 동의 및 체크 시 아래 메시지 노출-->
    <div class="auth-noti txt_red">
        <p>{!! xe_trans('xe::agreeSiteTermsUseAndSitePrivacyPolicyDescription') !!}</p>
    </div>
</div>
