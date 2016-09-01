{{ XeFrontend::css('/assets/core/xe-ui-component/xe-ui-component.css')->load() }}

<div class="xe-dropup">
    <button class="xe-btn" type="button" id="dropdownMenu1" data-toggle="xe-dropdown" aria-expanded="true">
        <i class="south {{ XeLang::getLocale() }} flag" data-locale="{{ XeLang::getLocale() }}"></i>{{ XeLang::getLocaleText(XeLang::getLocale()) }}</button>
    <div class="xe-dropdown-menu">
        <ul>
            @foreach ( XeLang::getLocales() as $locale )
                <li @if(XeLang::getLocale() == $locale) class="on" @endif>
                    <a href="{{ locale_url($locale) }}"><i class="south {{ $locale }} flag" data-locale="{{ $locale }}"></i>{{ XeLang::getLocaleText($locale) }}</a>
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
    })(XE, jQuery);
</script>
