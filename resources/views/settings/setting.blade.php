@section('page_title')
    <h2>{{ xe_trans('xe::defaultSettings') }}</h2>
@endsection

@section('page_description')
    <small>{!! xe_trans('xe::siteDefaultSettingsDescription') !!}</small>
@endsection

<div class="panel-group">
    <input type="hidden" id="defaultSettingMainTitle" value="{{ $langs['mainTitle'] }}">
    <input type="hidden" id="defaultSettingSubTitle" value="{{ $langs['subTitle'] }}">
    <input type="hidden" id="defaultSettingDescription" value="{{ $langs['description'] }}">

    <form role="form" action="{{ route('settings.setting.update') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
        <div class="panel">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{xe_trans('xe::site')}} {{xe_trans('xe::defaultSettings')}}</h3>
                    <p>{{ xe_trans('xe::siteSettingDefaultSettingDescription') }}</p>
                </div>
            </div>

            <div class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ xe_trans('xe::site')}} {{ xe_trans('xe::name') }}</label> <small>{{ xe_trans('xe::inputSiteNameDescription') }}</small>
                                {!! uio('langText', ['langKey'=>$siteConfig->get('site_title', null), 'name'=>'site_title']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group __preview-input __preview-site-address">
                                <label>{{ xe_trans('xe::site')}} {{ xe_trans('xe::address') }}</label> <small>{{ xe_trans('xe::siteAddressDescription') }}</small>
                                {!! uio('formText', ['id' => 'site_address', 'name'=>'site_address', 'value' => $currentSite['host']]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>{{ xe_trans('xe::favicon') }}</label> <small>{{ xe_trans('xe::siteSettingFaviconDescription') }}</small>
                            {!! uio('formFile', ['name' => 'favicon', 'value' => $siteConfig->get('favicon'), 'width' => 80, 'height' => 80, 'types' => ['ico','png'], 'fileuploadOptions' => [ 'maxFileSize' => 10000000 ] ]) !!}
                        </div>
                        <div class="col-sm-6">
                            <label>{{ xe_trans('xe::favicon') }} {{ xe_trans('xe::preview') }}</label> <small>{{ xe_trans('xe::siteSettingFaviconPreviewDescription') }}</small>
                            <div class="basic-setting-preview-favicon">
                                <div class="basic-setting-preview-favicon__background-image"></div>
                                <div class="basic-setting-preview-favicon__image basic-setting-preview-favicon__image--thumbnail __basic-setting-preview-favicon__image--thumbnail" style="background-image: url( {{ app('xe.site')->getSiteConfig()->get('favicon.path') }} )"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::detail') }} {{ xe_trans('xe::settings') }}</h3>
                    <p>{!! xe_trans('xe::siteSettingDetailSettingDescription') !!}</p>
                </div>
            </div>

            <div class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group __preview-input __preview-browser-title">
                                <label>{{ xe_trans('xe::browserTitle') }}</label> <small>{{ xe_trans('xe::siteSettingBrowserTitleDescription') }}</small>
                                {!! uio('langText', ['langKey'=> $seoSetting->get('mainTitle'), 'name'=>'mainTitle']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group __preview-input __preview-browser-subtitle">
                                <label>{{ xe_trans('xe::browserSubTitle') }}</label> <small>{{ xe_trans('xe::siteSettingBrowserSubTitleDescription') }}</small>
                                {!! uio('langText', ['langKey'=> $seoSetting->get('subTitle'), 'name'=>'subTitle']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group __preview-input __preview-description">
                                <label>{{ xe_trans('xe::description') }}</label> <small>{{ xe_trans('xe::siteSettingSiteDescription') }}</small>
                                {!! uio('langText', ['langKey'=> $seoSetting->get('description'), 'name'=>'description']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group __preview-input __preview-description">
                                <label>{{ xe_trans('xe::keyword') }}</label> <small>{{ xe_trans('xe::siteSettingKeywordDescription') }}</small>
                                {!! uio('langText', ['langKey'=> $seoSetting->get('keywords'), 'name'=>'keywords']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group __preview-image">
                                <label>{{ xe_trans('xe::siteImage') }}</label> <small>{{ xe_trans('xe::siteSettingImageDescription') }}</small>
                                <div class="list-group-item">
                                    <input type="file" name="siteImage">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="basic-setting-preview">
                                <span class="basic-setting-preview__title">{{ xe_trans('xe::siteSettingSEOPreview') }}</span>
                                <div class="basic-setting-preview-inner basic-setting-preview-google-inner">
                                    <div class="basic-setting-preview-google">
                                        <p class="basic-setting-preview-google__title"><span class="__basic-setting-preview__title--site-main"></span> - <span class="__basic-setting-preview__title--site-sub"></span></p>
                                        <p class="basic-setting-preview-google__url __basic-setting-preview__url"></p>
                                        <p class="basic-setting-preview-google__description __basic-setting-preview__description"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 basic-setting-preview-box">
                            <div class="basic-setting-preview">
                                <span class="basic-setting-preview__title">{{ xe_trans('xe::siteSettingSNSPreview') }}</span>
                                <div class="basic-setting-preview-inner">
                                    <div class="basic-setting-preview-facebook">
                                        <p class="basic-setting-preview-facebook__alert-text __basic-setting-preview-facebook__alert-text" style="display: none">{{ xe_trans('xe::siteSettingBrowserNotSupport') }}</p>
                                        <div class="basic-setting-preview-facebook__image __basic-setting-preview-facebook__image" @if ($seoSetting->getSiteImage() !== null) style="background-image: url( {{ $seoSetting->getSiteImage()->url() }} )" @endif></div>
                                        <div class="basic-setting-preview-facebook__content">
                                            <p class="basic-setting-preview-facebook__url __basic-setting-preview__url"></p>
                                            <p class="basic-setting-preview-facebook__title"><span class="__basic-setting-preview__title--site-main"></span> - <span class="__basic-setting-preview__title--site-sub"></span></p>
                                            <p class="basic-setting-preview-facebook__description __basic-setting-preview__description"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::siteSettingMailingDefaultSetting') }}</h3>
                </div>
            </div>

            <div class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>{{xe_trans('xe::mailSenderName')}}</label> <small>{{ xe_trans('xe::siteSettingWebmasterNameDescription') }}</small>
                                    <input type="text" name="webmasterName" class="form-control" value="{{ $userConfig->get('webmasterName') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{xe_trans('xe::mailSenderAddress')}}</label> <small>{{ xe_trans('xe::siteSettingWebmasterEmailAddressDescription') }}</small>
                                <input type="email" name="webmasterEmail" class="form-control" value="{{ $userConfig->get('webmasterEmail') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::pluginInstallSetting') }}</h3>
                </div>
            </div>

            <div class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>XE Store Token</label> <small>{{ xe_trans('xe::siteSettingInputTokenDescription') }}</small>
                                <input type="text" class="form-control" name="site_token" value="{{ $pluginConfig->get('site_token') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ xe_trans('xe::site')}} {{ xe_trans('xe::composerHomeDir') }}</label> <small>{{ xe_trans('xe::descComposerHomeDir') }}</small>
                                <input type="text" class="form-control" name="composer_home" value="{{ $pluginConfig->get('composer_home') ?: (getenv('COMPOSER_HOME') ?: (getenv('HOME') ? rtrim(getenv('HOME'), '/') . '/.composer' : '')) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <h3>{{xe_trans('xe::userDefaultSetting')}}</h3>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label for="item-url">{{xe_trans('xe::useLoginCaptcha')}}</label>
                    <div class="list-group-item">
                        <div class="radio">
                            <label>
                                <input type="radio" name="useCaptcha" value="true" @if($registerConfig->get('useCaptcha')) checked="checked" @endif @if ($captchaManager->available() != true) disabled @endif> {{xe_trans('xe::use')}}
                            </label>
                            <label>
                                <input type="radio" name="useCaptcha" value="false" @if(!$registerConfig->get('useCaptcha')) checked="checked" @endif @if ($captchaManager->available() != true) disabled @endif> {{xe_trans('xe::disuse')}}
                            </label>
                        </div>
                    </div>
                    @if($captchaManager->available() !== true)
                        <div class="alert alert-warning" role="alert" style="margin-top:10px;">
                            {!! xe_trans('xe::masAlertCaptchaAtLogin') !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="panel-heading">
            <div class="pull-right">
                <div class="row">
                    <button type="submit" class="xe-btn xe-btn-positive">{{ xe_trans('xe::save') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
