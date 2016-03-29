<div class="row">
    <div class="col-md-12">
        <form role="form" action="{{ route('settings.setting.update') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
        <div class="panel admin_card">
            <div class="panel-body card_cont">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label>{{ xe_trans('xe::site')}} {{ xe_trans('xe::title') }}</label>
                    {!! uio('langText', ['placeholder'=>xe_trans('xe::inputBrowserTitle'), 'langKey'=>array_get($config, 'site_title', null), 'name'=>'site_title']) !!}
                </div>

                {!! uio('formFile', ['name' => 'favicon', 'label' => xe_trans('xe::favicon'), 'file' => array_get($config,'favicon'), 'width' => 80, 'height' => 80, 'types' => 'ico', 'fileuploadOptions' => [ 'maxFileSize' => 10000000 ] ]) !!}

                <div class="form-group">
                    <label for="__xe_index_instance">{{ xe_trans('xe::selectHomeMenu') }}</label>
                    <select class="form-control" name="indexInstance" id="indexInstance">
                        @foreach($menus as $menu)
                            @foreach($menu->items as $item)
                                <option value="{{$item->id}}" {{ ($item->id == $indexInstance)?"selected":"" }}>{{xe_trans($item->title)}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="__xe_theme-list">{{ xe_trans('xe::selectMainTheme') }}</label>
                    {!! uio('themeSelect', ['selectedTheme' => $selectedTheme]) !!}
                </div>

            </div>
        </div>
        <div class="btn_group_all">
            <button type="submit" class="xe-btn xe-btn-blue">{{ xe_trans('xe::applyModified') }}</button>
        </div>

        </form>


    </div>
</div>
