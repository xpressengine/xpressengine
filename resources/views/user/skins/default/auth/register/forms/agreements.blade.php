@if($terms->count() > 0)
    <div class="terms-box">
        <label class="xu-label-checkradio">
            <input type="checkbox">
            <span class="xu-label-checkradio__helper"></span>
            <span class="xu-label-checkradio__text">{{ xe_trans('xe::msgAgreeAllTerms') }}</span>
        </label>
        <ul class="terms-list">
            @foreach ($terms as $term)
                <li>
                    <label class="xu-label-checkradio">
                        <input type="checkbox" name="user_agree_terms[]" value="{{ $term->id }}">
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
@endif
