<div class="theme-selector __xe_theme-selector">
    <input type="hidden" name="{{ $prefix . 'desktop' }}" value="{{ $selectedThemeId['desktop'] }}">
    <input type="hidden" name="{{ $prefix . 'mobile' }}" value="{{ $selectedThemeId['mobile'] }}">
    <ul class="theme-select-list">
        @if ($blankTheme != null)
            <li class="theme-item blank-theme-item">
                <strong class="blank-theme-item__text ellipsis">{{ $blankTheme->getTitle() }}</strong>
                
                @if($configs = app('xe.theme')->getThemeConfigList($blankTheme->getId()))
                    @foreach($configs as $configId => $config)
                        <div class="skin-select-btn">
                            <button type="button" class="__xe_desktop-theme-btn btn btn-default btn-sm @if($selectedThemeId['desktop'] === $configId) on @endif " data-config-id="{{ $configId }}"><i class="xi-tv visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Desktop</span></button>
                        </div>
                        <div class="skin-select-btn">
                            <button type="button" class="__xe_mobile-theme-btn btn btn-default btn-sm @if($selectedThemeId['mobile'] === $configId) on @endif " data-config-id="{{ $configId }}"><i class="xi-mobile visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Mobile</span></button>
                        </div>
                    @endforeach
                @endif
                
            </li>
        @endif

        @foreach($themes as $id => $theme)
            <li class="theme-item">
                <div class="theme-desc">
                    <img src="{{ asset($theme->getScreenshot() ? : 'assets/core/common/img/default_image_196x140.jpg') }}" alt="screenshot" class="hidden-xs" width="98" height="70">
                    <strong class="ellipsis">{{ $theme->getTitle() }}</strong>
                    <p>{{ $theme->getDescription() }}</p>
                </div>
                <ul>
                    @if($configs = app('xe.theme')->getThemeConfigList($theme->getId()))
                        @foreach($configs as $configId => $config)
                            <li class=" @if($selectedThemeId['desktop'] === $configId) on @endif ">
                                <div class="skin-select-btn">
                                    <button type="button" class="__xe_desktop-theme-btn btn btn-default btn-sm @if($selectedThemeId['desktop'] === $configId) on @endif " data-config-id="{{ $configId }}"><i class="xi-tv visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Desktop</span></button>
                                </div>
                                <div class="skin-select-btn">
                                    <button type="button" class="__xe_mobile-theme-btn btn btn-default btn-sm @if($selectedThemeId['mobile'] === $configId) on @endif " data-config-id="{{ $configId }}"><i class="xi-mobile visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Mobile</span></button>
                                </div>
                                <strong class="ellipsis">{{ $config->get('_configTitle', xe_trans('xe::default')) }}</strong>
                                <div class="btn-right">
                                    @if($theme->hasSetting())
                                        <a href="{{ route('settings.theme.config', ['theme' => $configId]) }}" class="btn btn-link"><i class="xi-cog"></i><span class="hidden-xs">{{xe_trans('xe::modify')}}</span></a>
                                    @endif
{{--                                    <a href="{{ route('settings.theme.set_preview', ['configId' => $configId]) }}" target="_blank" class="btn btn-link"><i class="xi-search"></i><span class="hidden-xs">{{xe_trans('xe::preview')}}</span></a>--}}
                                    <a href="#" target="_blank" class="btn btn-link __xe_theme_config_delete" onclick="return false;" data-id="{{$configId}}" data-url="{{route('settings.theme.config')}}"><i class="xi-trash"></i><span class="hidden-xs">{{xe_trans('xe::delete')}}</span></a>
                                </div>
                            </li>
                        @endforeach
                        @if($theme->hasSetting())
                            <li class="theme-new-config-area">
                                <button onclick="$('#addConfig [name=theme]').val('{{ $theme->getId() }}')" type="button" data-toggle="modal" data-target="#addConfig" class="btn btn-default">{{xe_trans('xe::addNewInstance')}}</button>
                            </li>
                        @endif
                    @endif
                </ul>
            </li>
        @endforeach
    </ul>
</div>

{{ XeFrontend::html('theme.config')->content('
<div id="addConfig" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form action="'.route('settings.theme.config').'" method="POST" onsubmit="$(\'.__xe_submit_btn\').button(\'loading\')">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">'.xe_trans('xe::addNewThemeInstance').'</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="theme" value="">
                    '. csrf_field() .'
                    '. uio('formText', ['label'=>xe_trans('xe::themeInstanceName'), 'name'=>'title']) .'
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">'.xe_trans('xe::cancel').'</button>
                    <button type="submit" class="btn btn-primary __xe_submit_btn" data-loading-text="추가중..">'.xe_trans('xe::add').'</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
')->load() }}
{{ XeFrontend::html('theme.selector')->content("
<script>
    jQuery(function ($) {
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

{{ expose_trans('xe::confirmThemeDelete') }}

<script>
    $('.__xe_theme_config_delete').click(function () {
        if (confirm(window.XE.Lang.trans('xe::confirmThemeDelete')) == false) {
            return;
        }

        var url = $(this).data('url')
        var themeId = $(this).data('id')

        window.XE.delete(url, {
            theme: themeId
        }).then(function () {
            $('[data-id="' + themeId + '"]').closest('li').remove()
        })
    })
</script>
