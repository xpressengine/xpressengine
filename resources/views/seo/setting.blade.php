@section('page_title')
    <h2>SEO</h2>
@endsection

@section('page_description')
    Search Engine Optimization setting
@endsection
<style>
    .inpt_url em {margin-right:10px;font-size:20px}
    .inpt_url .inpt_txt {width:90%}
</style>

<div class="panel">
    <div class="panel-heading">
<div class="row">
    <div class="col-sm-12">

        <form method="post" action="{{ route('manage.seo.update') }}" enctype="multipart/form-data" data-rule="seoSetting">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="admin_card">
                <div class="card_tit">
                    <div class="row">
                        <p class="txt_tit">{{ xe_trans('xe::defaultSettings') }}</p>
                    </div>
                </div>
                <div class="card_cont">
                    <div class="row">
                        <div class="col-sm-12 inpt_bd">
                            <p class="txt_tit">{{ xe_trans('xe::siteImage') }} (1200x600, 600x315, 200x200)</p>
                            <input type="file" class="inpt_txt" name="siteImage">
                            @if($setting->getSiteImage())
                                <br />
                                {!! $setting->getSiteImage()->render(['responsive' => true]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin_card">
                <div class="card_tit">
                    <div class="row">
                        <p class="txt_tit">{{ xe_trans('xe::titleOptimization') }}</p>
                    </div>
                </div>
                <div class="card_cont">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="txt_tit">{{ xe_trans('xe::browserTitle') }}</p>
                            {!! uio('langText', ['langKey'=> $setting->get('mainTitle'), 'name'=>'mainTitle']) !!}

                        </div>
                        <div class="col-md-6">
                            <p class="txt_tit">{{ xe_trans('xe::browserSubTitle') }}</p>
                            {!! uio('langText', ['langKey'=> $setting->get('subTitle'), 'name'=>'subTitle']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin_card">
                <div class="card_tit">
                    <div class="row">
                        <p class="txt_tit">Meta Tag</p>
                    </div>
                </div>
                <div class="card_cont">
                    <div class="row">
                        <div class="col-md-12 inpt_bd">
                            <p class="txt_tit">{{ xe_trans('xe::siteKeyword') }}</p>
                            <input type="text" class="inpt_txt" name="keywords" value="{{ $setting->get('keywords') ?: Input::old('keywords') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="txt_tit">{{ xe_trans('xe::description') }}</p>
                            {!! uio('langText', ['langKey'=> $setting->get('description'), 'name'=>'description']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin_card">
                <div class="card_tit">
                    <div class="row">
                        <p class="txt_tit">{{ xe_trans('xe::etc') }}</p>
                    </div>
                </div>
                <div class="card_cont">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="txt_tit">Twitter Username</p>
                            <div class="inpt_url">
                                <em class="txt_blue">@</em><input type="text" class="inpt_txt" name="twitterUsername" placeholder="username" value="{{ $setting->get('twitterUsername') ?: Input::old('twitterUsername') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn_group_all">
                <button class="btn_setting blue">{{ xe_trans('xe::submit') }}</button>
            </div>

        </form>
    </div>
</div>

    </div>
</div>
{!! uio('uiobject/xpressengine@chakIt', 'Settings:SEO설정') !!}