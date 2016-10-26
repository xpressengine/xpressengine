<div class="xe-modal-header">
    <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
    <strong class="xe-modal-title">{{ xe_trans('xe::siteTermsUse') }}</strong>
</div>
<div class="xe-modal-body">
    <p>
        {!! $agreement !!}
    </p>
</div>
<div class="xe-modal-footer">
    <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::confirm') }}</button>
</div>
