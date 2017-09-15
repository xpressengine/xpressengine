@section('page_title')
    <h2>SEO</h2>
@endsection

@section('page_description')
    Search Engine Optimization setting
@endsection

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <form method="post" action="{{ route('manage.seo.update') }}" enctype="multipart/form-data" data-rule="seoSetting">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{ xe_trans('xe::defaultSettings') }}</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>{{ xe_trans('xe::siteImage') }} <small>1200x630, 600x315, 200x200</small></label>
                            <div class="list-group-item">
                                <input type="file" name="siteImage">
                                @if($setting->getSiteImage())
                                    <br />
                                    {!! $setting->getSiteImage()->render(['responsive' => true]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{ xe_trans('xe::browserTitle') }}</label>
                                    {!! uio('langText', ['langKey'=> $setting->get('mainTitle'), 'name'=>'mainTitle']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{ xe_trans('xe::browserSubTitle') }}</label>
                                    {!! uio('langText', ['langKey'=> $setting->get('subTitle'), 'name'=>'subTitle']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ xe_trans('xe::metaTag') }} <small>{{ xe_trans('xe::inputSiteKeyword') }}</small></label>
                            <input type="text" class="form-control" name="keywords" value="{{ $setting->get('keywords') ?: Request::old('keywords') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ xe_trans('xe::description') }} <small>{{ xe_trans('xe::inputSiteDescription') }}</small></label>
                            {!! uio('langText', ['langKey'=> $setting->get('description'), 'name'=>'description']) !!}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{ xe_trans('xe::contents') }} {{ xe_trans('xe::owner') }} {{ xe_trans('xe::info') }} <small>{{ xe_trans('xe::inputSourceAddress', ['name' => 'twitter']) }}</small></label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">@</span>
                                        <input type="text" id="item-url" name="twitterUsername" class="form-control" aria-describedby="basic-addon1" placeholder="Twitter Username" value="{{ $setting->get('twitterUsername') ?: Request::old('twitterUsername') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            {{--<button type="button" class="btn btn-default btn-lg">취소</button>--}}
                            <button type="submit" class="btn btn-primary btn-lg">{{ xe_trans('xe::save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

