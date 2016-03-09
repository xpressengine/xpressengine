{{ XeFrontend::css('/assets/core/lang/flag.css')->load() }}
{{ XeFrontend::css('/assets/core/common/css/dropdown.css')->load() }}

<div class="dropup v2">
    <button class="btn btn-default" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
        <i class="south {{ XeLang::getLocale() }} flag" data-locale="{{ XeLang::getLocale() }}"></i>{{ XeLang::getLocaleText(XeLang::getLocale()) }}</button>
    <div class="dropdown-menu">
        <ul>
            @foreach ( XeLang::getLocales() as $locale )
                <li @if(XeLang::getLocale() == $locale) class="on" @endif>
                    <a href="/locale/{{ $locale }}"><i class="south {{ $locale }} flag" data-locale="{{ $locale }}"></i>{{ XeLang::getLocaleText($locale) }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script type="text/javascript">
    (function (XE, $) {
        $('[data-locale]').each(function () {
            var code = XE.Lang.getLangCode($(this).data('locale')),
                arr = code.split('-'),
                keyword = arr[1].toLowerCase();

            $(this).addClass(keyword);
        });
    })(XE, XE.jQuery);
</script>
