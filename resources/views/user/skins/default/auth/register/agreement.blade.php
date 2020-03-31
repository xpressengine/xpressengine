{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::js('assets/core/user/user_register.js')->load() }}

<div class="user user--signup user--terms">
    <h2 class="user__title">{{ xe_trans('xe::signUp') }}</h2>
    <p class="user__text">{!! nl2br(app('xe.config')->getVal('user.register.register_guide')) !!}</p>
    <form method="post" action="{{ route('auth.register.term_agree') }}">
        {!! csrf_field() !!}

        <fieldset class="__xe-register-aggrements">
            <legend>약관 동의</legend>
            <div class="user-terms">
                <label class="xu-label-checkradio">
                    <input type="checkbox" name="agree" class="__xe-register-aggrement-all">
                    <span class="xu-label-checkradio__helper"></span>
                    <span class="xu-label-checkradio__text">{{ xe_trans('xe::msgAgreeAllTerms') }}</span>
                </label>

                @foreach ($terms as $term)
                    <div class="terms-box xu-form-group">
                        <label class="xu-label-checkradio">
                            <input type="checkbox" name="{{ $term->id }}" value="on" @if (old($term->id) == 'on') checked @endif class="__xe-register-aggrement--{{ $term->isRequire() ? 'require' : 'optional' }}" @if($term->isRequire()) data-valid="required" required @endif>
                            <span class="xu-label-checkradio__helper"></span>
                            <span class="xu-label-checkradio__text">{{ xe_trans($term->title) }}
                                @if ($term->isRequire() === true)
                                    <span class="xu-label-checkradio__empase">({{ xe_trans('xe::require') }})</span>
                                @else
                                    <span class="xu-label-checkradio__empase">({{ xe_trans('xe::optional') }})</span>
                                @endif
                            </span>
                        </label>
                        <div class="terms-content">
                            {!! nl2br(xe_trans($term->content)) !!}
                        </div>
                    </div>
                @endforeach

                <div class="button-box button-box--type2">
                    <a href="{{ url('/') }}" class="xu-button xu-button--default xu-button--large user__button-default">
                        <span class="xu-button__text">{{ xe_trans('xe::cancel') }}</span>
                    </a>

                    <button type="submit" class="xu-button xu-button--primary xu-button--block xu-button--large">
                        <span class="xu-button__text">{{ xe_trans('xe::confirm') }}</span>
                    </button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<style>
        .xu-label-checkradio input[type="checkbox"], .xu-label-checkradio input[type="radio"] {
            opacity: 0;
            width: unset;
            height: unset;
            left: unset;
        }
    </style>
