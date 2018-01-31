@if($terms->count() > 0)
<label class="xe-label">
    <input type="checkbox" name="agree" data-valid-name="{{xe_trans('xe::siteTermsUse')}}">
    <span class="xe-input-helper"></span>
    <span class="xe-label-text">
        {!!
            xe_trans('xe::msgAcceptTerms', ['terms' => call_user_func(function ($terms) {
                $tags = [];
                foreach ($terms as $term) {
                    $tags[] = '<a href="'.route('auth.terms', $term->id).'" class="__xe_terms">'.xe_trans($term->title).'</a>';
                }

                return implode(', ', $tags);
            }, $terms)])
        !!}
    </span>
</label>
@endif
