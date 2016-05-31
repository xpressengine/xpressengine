<div class="theme-selector __xe_theme-selector">
    <input type="hidden" name="{{ $prefix . 'desktop' }}" value="{{ $selectedThemeId['desktop'] }}">
    <input type="hidden" name="{{ $prefix . 'mobile' }}" value="{{ $selectedThemeId['mobile'] }}">
    <ul class="theme-select-list">
        @foreach($themes as $id => $theme)
            <li>
                <div class="theme-desc">
                    <img src="{{ asset($theme->getScreenshot() ? : 'assets/core/common/img/default_image_196x140.jpg') }}" alt="screenshot" class="hidden-xs" width="98" height="70">
                    <strong class="ellipsis">{{ $theme->getTitle() }}</strong>
                    <p>{{ $theme->getDescription() }}</p>
                    <div class="btn-right hidden-sm">
                        <a href="#" class="btn btn-default">새 설정 추가</a>
                        <a href="{{ route('settings.theme.edit', ['theme'=>$theme->getId()]) }}" target="_blank" class="btn btn-primary">편집</a>
                    </div>
                </div>
                <ul>
                @if($configs = app('xe.theme')->getThemeConfigList($theme->getId()))
                    @foreach($configs as $configId => $config)
                        <!--[D] 테마 선택 시  li에 .on 추가-->
                            <li class=" @if($selectedThemeId['desktop'] === $configId) on @endif ">
                                <div class="skin-select-btn">
                                    <!--[D] 테마 선택 시  btn 클래스에 .on 추가-->
                                    <button type="button" class="__xe_desktop-theme-btn btn btn-default btn-sm @if($selectedThemeId['desktop'] === $configId) on @endif " data-config-id="{{ $configId }}"><i class="xi-tv visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Desktop</span></button>
                                </div>
                                <div class="skin-select-btn">
                                    <button type="button" class="__xe_mobile-theme-btn btn btn-default btn-sm @if($selectedThemeId['mobile'] === $configId) on @endif " data-config-id="{{ $configId }}"><i class="xi-mobile visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Mobile</span></button>
                                </div>
                                <strong class="ellipsis">{{ $config->get('_configTitle', '기본') }}</strong>
                                <div class="btn-right">
                                    <a href="{{ route('settings.theme.setting', ['theme'=>$configId]) }}" target="_blank" class="btn btn-link"><i class="xi-cog"></i><span class="hidden-xs">수정</span></a>
                                    <a href="{{ url($previewLink.'preview_theme='.$configId) }}" target="_blank" class="btn btn-link"><i class="xi-magnifier"></i><span class="hidden-xs">미리보기</span></a>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        @endforeach
    </ul>
</div>

{{ XeFrontend::html('skin-section')->content("
<script>
    $(document).ready(function () {
        function deselectTheme(type) {
            if(type == 'mobile') {
                $('.__xe_theme-selector .__xe_mobile-theme-btn').removeClass('on');
            } else {
                $('.__xe_theme-selector .__xe_desktop-theme-btn').removeClass('on');
            }
        }
        $('.theme-select-list .__xe_desktop-theme-btn').click(function(){
            var configId = $(this).data('configId');
            $('.__xe_theme-selector [name=".$prefix."desktop]').val(configId);
            deselectTheme('desktop');
            $(this).addClass('on');
        });
        $('.theme-select-list .__xe_mobile-theme-btn').click(function(){
            var configId = $(this).data('configId');
            $('.__xe_theme-selector [name=".$prefix."mobile]').val(configId);
            deselectTheme('mobile');
            $(this).addClass('on');
        });
    });
</script>
")->load() }}
