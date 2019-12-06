{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::js('assets/core/user/user_register.js')->load() }}

@if($terms->count() > 0)
    <div class="terms-box __xe-register-aggrements">
        <label class="xu-label-checkradio">
            <input type="checkbox" name="agree" class="__xe-register-aggrement-all">
            <span class="xu-label-checkradio__helper"></span>
            <span class="xu-label-checkradio__text">{{ xe_trans('xe::msgAgreeAllTerms') }}</span>
        </label>
        <ul class="terms-list xu-form-group">
            @foreach ($terms as $term)
                <li>
                    <label class="xu-label-checkradio">
                        <input type="checkbox" name="user_agree_terms[]" value="{{ $term->id }}" class="__xe-register-aggrement--{{ $term->isRequire() ? 'require' : 'optional' }}" @if($term->isRequire()) data-valid="required" required @endif>
                        <span class="xu-label-checkradio__helper"></span>
                        <span class="xu-label-checkradio__text">{{ xe_trans($term->title) }}
                            @if ($term->isRequire() === true)
                                <span class="xu-label-checkradio__empase">({{ xe_trans('xe::require') }})</span>
                            @else
                                <span class="xu-label-checkradio__empase">({{ xe_trans('xe::optional') }})</span>
                            @endif
                    </span>
                    </label>
                    <a href="{{ route('auth.terms', $term->id) }}" class="terms-list__term-button __xe_terms">{{ xe_trans('xe::viewContents') }}</a>
                </li>
            @endforeach
        </ul>
    </div>
{{
XeFrontend::html('auth.register.terms')->content("
<script>
    $(function($) {
        $('.__xe_terms').click(function (e) {
            e.preventDefault();

            XE.pageModal($(this).attr('href'));
        });
    });
</script>
")->load()
}}

<style>
    .xu-label-checkradio input[type="checkbox"], .xu-label-checkradio input[type="radio"] {
        opacity: 0;
        width: unset;
        height: unset;
        left: unset;
    }
</style>
@endif
