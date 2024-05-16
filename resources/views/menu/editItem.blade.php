@section('page_title')
    <h2><a href="{{ route('settings.menu.index') }}"><i class='xi-arrow-left'></i></a>{{ xe_trans('xe::editItem') }}</h2>
@endsection
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.update.item', [$menu->id, $item->id])}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put"/>
    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
    <input type="hidden" name="itemOrdering" value="{{ $item->ordering }}"/>

    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::editItemDescription')}}</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>

                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-heading">
                        <div class="pull-left">
                            @include('menu.partial.itemControlPanel')
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="item-active">{{ xe_trans('xe::menu') }} {{ xe_trans('xe::activation') }}<br>
                                <small>{{xe_trans('xe::itemActivatedDescription')}}</small>
                            </label>

                            <div class="xe-btn-toggle pull-right">
                                <label>
                                    <span class="sr-only"><span class="sr-only">{{xe_trans('xe::activation')}}</span></span>
                                    @if($item->id == $homeId)
                                        <input type="hidden" name="itemActivated" value="1" />
                                        <input type="checkbox" checked disabled />
                                    @else
                                    <input type="checkbox" id="item-active" name="itemActivated" {{ ($item->activated === 1)?"checked":'' }} value="1"/>
                                    @endif
                                    <span class="toggle"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-url">URL</label>
                            <div class="input-group">
                                @if( $menuType !== null && $menuType::isRouteAble())
                                <span class="input-group-addon" id="basic-addon1">/</span>
                                @endif
                                <input type="text" id="item-url" name="itemUrl" class="form-control" value="{{ $item->url }}" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-title">{{ xe_trans('xe::menuTitle') }}</label>
                            <div class="input-group">
                                {!! uio('langText', ['id' => 'item-title', 'langKey'=> $item->title_lang_key, 'name'=>'itemTitle', 'aria-describedby' => 'basic-addon2']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="item-description">{{ xe_trans('xe::page') }} {{ xe_trans('xe::description') }}</label>

                            {!! uio('langTextArea', ['id' => 'item-description', 'langKey'=> $item->description_lang_key, 'name'=>'itemDescription', 'aria-describedby' => 'basic-addon2']) !!}
                        </div>

                        <div class="form-group">
                            <label for="item-target">{{ xe_trans('xe::link') }} {{ xe_trans('xe::option') }}<br>
                                <small>{{xe_trans('xe::itemTargetDescription')}}</small>
                            </label>
                            <select name="itemTarget" class="form-control">
                                <option value="_self" {{ ($item->target === "_self")? "selected":"" }}>
                                    {{xe_trans('xe::itemTargetOption_sameFrame')}}
                                </option>
                                <option value="_blank" {{ ($item->target === "_blank")? "selected":"" }}>
                                    {{xe_trans('xe::itemTargetOption_newWindow')}}
                                </option>
                                <option value="_parent" {{ ($item->target === "_parent")? "selected":"" }}>
                                    {{xe_trans('xe::itemTargetOption_parentFrame')}}
                                </option>
                                <option value="_top" {{ ($item->target === "_top")? "selected":"" }}>
                                    {{xe_trans('xe::itemTargetOption_topFrame')}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ xe_trans('xe::menuImage') }}<br>
                                <small>{{xe_trans('xe::menuImageSpecDescription')}}</small>
                            </label>
                            {!! uio('uiobject/xpressengine@formImage', ['name' => 'menuImage', 'image' => $item->menuImage]) !!}
                        </div>

                        <div class="form-group">
                            <label>
                                {{ xe_trans('xe::menu') }} {{ xe_trans('xe::image') }}
                                <small>{{ xe_trans('xe::menuImageDescription') }}</small>
                            </label>

                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>
                                            PC - {{ xe_trans('xe::default') }}
                                        </label>
                                        {!! uio('uiobject/xpressengine@formImage', ['name' => 'basicImage', 'image' => $item->basicImage]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            PC - {{ xe_trans('xe::hover') }}
                                        </label>
                                        {!! uio('uiobject/xpressengine@formImage', ['name' => 'hoverImage', 'image' => $item->hoverImage]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            PC - {{ xe_trans('xe::selected') }}
                                        </label>
                                        {!! uio('uiobject/xpressengine@formImage', ['name' => 'selectedImage', 'image' => $item->selectedImage]) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>
                                            Mobile - {{ xe_trans('xe::default') }}
                                        </label>
                                        {!! uio('uiobject/xpressengine@formImage', ['name' => 'mBasicImage', 'image' => $item->mBasicImage]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            Mobile - {{ xe_trans('xe::hover') }}
                                        </label>
                                        {!! uio('uiobject/xpressengine@formImage', ['name' => 'mHoverImage', 'image' => $item->mHoverImage]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            Mobile - {{ xe_trans('xe::selected') }}
                                        </label>
                                        {!! uio('uiobject/xpressengine@formImage', ['name' => 'mSelectedImage', 'image' => $item->mSelectedImage]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($menuType !== null && $menuType::isRouteAble())
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::theme')}}<small>{{xe_trans('xe::menuThemeDescription')}}</small></h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>

                <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="parentTheme" id="parentTheme" value="1" @if($parentThemeMode) checked @endif>
                                    <label for="parentTheme" class="inpt_chk">{{xe_trans('xe::menuThemeInheritMode')}}</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="themeSelect" @if($parentThemeMode) style="display:none" @endif>
                        {!! uio('themeSelect', ['selectedTheme' => ['desktop' => $itemConfig->get('desktopTheme'), 'mobile' => $itemConfig->get('mobileTheme')]]) !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($menuType !== null)
            {!! uio('menuType', ['menuType' => $menuType, 'action' => 'editMenuForm', 'param' => $item->id ]) !!}
        @else
            @include('menu.partial.typeLoadError', ['item' => $item])
        @endif

        <div class="pull-right">
            <a href="{{route('settings.menu.index')}}" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</a>
            <button class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
        </div>
    </div>
</form>
<script>
    jQuery(function($) {
        $('#parentTheme').change(function () {
            $('#themeSelect').toggle();
        });
    });
</script>
@endsection
