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
                    <input type="checkbox" class="__xe-register-aggrement-all">
                    <span class="xu-label-checkradio__helper"></span>
                    <span class="xu-label-checkradio__text">{{ xe_trans('xe::msgAgreeAllTerms') }}</span>
                </label>

                @foreach ($terms as $term)
                    <div class="terms-box">
                        <label class="xu-label-checkradio">
                            <input type="checkbox" name="{{ $term->id }}" value="on" @if (old($term->id) == 'on') checked @endif class="__xe-register-aggrement--{{ $term->isRequire() ? 'require' : 'optional' }}">
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
                        <span class="xu-button__text">취소</span>
                    </a>

                    {{--TODO 모든 약관을 동의 했을 때 활성화 스크립트 적용 필요--}}
                    <button type="submit" class="xu-button xu-button--primary xu-button--block xu-button--large">
                        <span class="xu-button__text">확인</span>
                    </button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
