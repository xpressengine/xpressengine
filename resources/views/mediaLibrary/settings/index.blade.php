@section('page_title')
    <h2>{{xe_trans('xe::mediaLibrary')}} {{xe_trans('xe::settings')}}</h2>
@endsection
<form method="post" action="{{route('settings.mediaLibrary.storeFileSetting')}}" class="plugin-install-form">
    {!! csrf_field() !!}
<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">


                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::imageSizeSetting')}}</h3>
                            <small>{{xe_trans('xe::imageSizeSettingDescription')}}</small>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>Small ({{xe_trans('xe::thumbnail')}}) {{xe_trans('xe::width')}}</label>
                                        <input type="text" name="dimensions_s_width" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['S']['width']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>Small ({{xe_trans('xe::thumbnail')}}) {{xe_trans('xe::height')}}</label>
                                        <input type="text" name="dimensions_s_height" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['S']['height']}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>Medium {{xe_trans('xe::max')}} {{xe_trans('xe::width')}}</label>
                                        <input type="text" name="dimensions_m_width" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['M']['width']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>Medium {{xe_trans('xe::max')}} {{xe_trans('xe::height')}}</label>
                                        <input type="text" name="dimensions_m_height" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['M']['height']}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>Large {{xe_trans('xe::max')}} {{xe_trans('xe::width')}}</label>
                                        <input type="text" name="dimensions_l_width" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['L']['width']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>Large {{xe_trans('xe::max')}} {{xe_trans('xe::height')}}</label>
                                        <input type="text" name="dimensions_l_height" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['L']['height']}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>{{xe_trans('xe::maxSizeImageWidth')}}</label>
                                        <input type="text" name="dimensions_max_width" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['MAX']['width']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>{{xe_trans('xe::maxSizeImageHeight')}}</label>
                                        <input type="text" name="dimensions_max_height" class="form-control" value="{{config('xe.media.thumbnail.dimensions')['MAX']['height']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::uploadFileSetting')}}</h3>
                            <small>{{xe_trans('xe::uploadFileSettingDescription')}}</small>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>{{xe_trans('xe::uploadMaxSize')}}(MB)</label>
                                        <input type="text" name="max_size" class="form-control" value="{{config('xe.media.mediaLibrary.max_size')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="clearfix">
                                        <label>{{xe_trans('xe::restrictFile')}} <small>{{xe_trans('xe::restrictFileDescription')}}</small></label>
                                        <input type="text" name="disallow_extensions" class="form-control" value="{{config('xe.media.mediaLibrary.disallow_extensions')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="panel-footer">
                <div class="pull-right">
                    <button type="submit" class="xe-btn xe-btn-positive">{{xe_trans('xe::save')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
