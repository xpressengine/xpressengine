{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}

<div class="theme_container">
    <div class="user user--signup-complete">
        <h2 class="user__title">{{ xe_trans('xe::waitingApproval') }}</h2>
        <p class="user__text">{{ xe_trans('xe::beforeAdminApproval') }}<br> {{ xe_trans('xe::needAdminApprovalCanLogin') }}</p>
        <div class="button-box">
            <a href="{{ url('/') }}" class="xu-button xu-button--primary xu-button--large" style="width: 150px">
                <span class="xu-button__text">{{ xe_trans('xe::goToHome') }}</span>
            </a>
        </div>
    </div>
</div>
