@section('page_title', "<h2><a href='".route('settings.menu.index')."'><i class='xi-arrow-left'></i></a>".xe_trans('xe::newItem')."</h2>")

@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.store.item', $menu->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
    <input type="hidden" name="selectedType" value="{{ $selectedType }}"/>
    <input type="hidden" name="siteKey" value="{{ $siteKey }}"/>
    <input type="hidden" name="menuId" value="{{ $menu->id}}"/>
    <div class="col-md-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::newItemDescription')}}</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                </div>
            </div>

            <div class="panel-body" id="collapseOne">
                <div class="form-group">
                    <label for="item-active">Item Activated<br><small>{{xe_trans('xe::itemActivatedDescription')}}</small></label>

                    <div class="xe-btn-toggle pull-right">
                        <label>
                            <span class="sr-only"><span class="sr-only">{{xe_trans('xe::activation')}}</span></span>
                            <input type="checkbox" checked="checked" value="1" id="item-active" name="itemActivated">
                            <span class="toggle"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="item-url">
                        Item Url
                    </label>

                    @if($menuType::isRouteAble())
                    <em class="txt_blue">/</em>
                    @endif
                    <input type="text" id="item-url" name="itemUrl" class="form-control" value="{{Request::old('itemUrl')}}"/>
                </div>
                <div class="form-group">
                    <label for="item-title">Item Title</label>
                    <input type="hidden" name="itemOrdering" value="0" readonly/>
                    <div class="row">
                        <div class="col-sm-4">
                            <select name="parent" class="form-control">
                                <option value="{{$menu->id}}" @if($parent == $menu->id) selected @endif>
                                    {{$menu->title}}
                                </option>
                                @include('menu.partial.itemOption', ['items' => $menu->items, 'maxDepth' => $maxDepth])
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <div class="inpt_bd">
                                {!! uio('langText', ['id' => 'itemTitle', 'langKey'=> '', 'name'=>'itemTitle']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="item-description">Item Description</label>
                    <textarea name="itemDescription" id="item-description" class="form-control" rows="3"placeholder="{{xe_trans('xe::itemDescriptionPlaceHolder')}}"></textarea>
                </div>
                <div class="form-group">
                    <label for="item-target">Item Target<br><small>{{xe_trans('xe::itemTargetDescription')}}</small></label>

                        <select name="itemTarget" class="form-control">
                            <option value="_self" selected>
                                {{xe_trans('xe::itemTargetOption_sameFrame')}}
                            </option>
                            <option value="_blank">
                                {{xe_trans('xe::itemTargetOption_newWindow')}}
                            </option>
                            <option value="_parent">
                                {{xe_trans('xe::itemTargetOption_parentFrame')}}
                            </option>
                            <option value="_top">
                                {{xe_trans('xe::itemTargetOption_topFrame')}}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            Link image
                            <small>{{ xe_trans('xe::linkImageDescription') }}</small>
                        </label>

                        <div class="well">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>PC - {{ xe_trans('xe::default') }}</label>
                                    {!! uio('uiobject/xpressengine@formImage', ['name' => 'basicImage']) !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>PC - {{ xe_trans('xe::hover') }}</label>
                                    {!! uio('uiobject/xpressengine@formImage', ['name' => 'hoverImage']) !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>PC - {{ xe_trans('xe::selected') }}</label>
                                    {!! uio('uiobject/xpressengine@formImage', ['name' => 'selectedImage']) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Mobile - {{ xe_trans('xe::default') }}</label>
                                    {!! uio('uiobject/xpressengine@formImage', ['name' => 'mBasicImage']) !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>Mobile - {{ xe_trans('xe::hover') }}</label>
                                    {!! uio('uiobject/xpressengine@formImage', ['name' => 'mHoverImage']) !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>Mobile - {{ xe_trans('xe::selected') }}</label>
                                    {!! uio('uiobject/xpressengine@formImage', ['name' => 'mSelectedImage']) !!}
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
                    <h3 class="panel-title">Theme<small>{{xe_trans('xe::menuThemeDescription')}}</small></h3>
                </div>
                <div class="pull-right">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                </div>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-heading">
                    <div class="pull-left">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="parentTheme" id="parentTheme" value="1" checked>
                                {{xe_trans('xe::menuThemeInheritMode')}}
                            </label>
                        </div>
                    </div>
                </div>
                <div id="themeSelect" style="display:none">
                    {!! uio('themeSelect', ['selectedTheme' => ['desktop' => $menuConfig->get('desktopTheme'), 'mobile' => $menuConfig->get('mobileTheme')]]) !!}
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a href="{{ route('settings.menu.select.types')}}" class="btn btn-default">{{xe_trans('xe::cancel')}}</a>
            <button type="submit" class="btn btn-primary">{{xe_trans('xe::submit')}}</button>
        </div>
    </div>

    {!! uio('menuType', $menuTypeArgs) !!}

</form>
<script>
    $('#parentTheme').change(function () {
        $('#themeSelect').toggle();
    });
</script>
@endsection
