<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
            <form role="form" action="{{ route('settings.setting.update') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">사이트 기본 설정</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">메뉴닫기</span></a>
                    </div>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">

                        {{-- 샤이트 제목 --}}
                        <label>{{ xe_trans('xe::site')}} {{ xe_trans('xe::title') }}</label>
                        {!! uio('langText', ['placeholder'=>xe_trans('xe::inputBrowserTitle'), 'langKey'=>array_get($config, 'site_title', null), 'name'=>'site_title']) !!}

                        {{-- 파비콘 --}}
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

                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="xi-download"></i>저장</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div class="panel">
            <form role="form" action="{{ route('settings.setting.theme') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">기본 테마 지정<small>테마를 미리 보고 클릭하여 선택할 수 있습니다.</small></h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">메뉴닫기</span></a>
                    </div>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="form-group">
                            {!! uio('themeSelect', ['selectedTheme' => $selectedTheme]) !!}
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="xi-download"></i>저장</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

