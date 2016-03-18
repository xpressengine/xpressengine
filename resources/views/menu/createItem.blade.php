@section('page_head')
    <h2><a href="{{route('settings.menu.select.types', $menu->id)}}"><i
                    class="xi-arrow-left"></i></a>{{xe_trans('xe::newItem')}}</h2>
<div class="tit_btn_area">
    <button type="button" class="btn_lst_toggle visible-xs pull-right"><i class="xi-ellipsis-v"></i></button>
    <ul class="btn_lst">
    </ul>
</div>
<div class="tit_bottom">
    <ul class="locate">
        <li><a href="{{ route('settings.menu.edit.menu', $menu->id) }}">{{$menu->title}}</a><i
                    class="xi-angle-right"></i></li>
    </ul>
</div>
@endsection
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.store.item', $menu->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
        <input type="hidden" name="selectedType" value="{{ $selectedType }}"/>
        <input type="hidden" name="siteKey" value="{{ $siteKey }}"/>
        <input type="hidden" name="menuId" value="{{ $menu->id}}"/>
        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="text-title">{{xe_trans('xe::newItemDescription')}}</p>
                        <div class="right_btn">
                            <button type="button" class="btn-close ico_gray pull-left"><i class="xi-angle-down"></i><i
                                        class="xi-angle-up"></i></button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row_con v2">
                        <p class="text-title">Item Activated<i class="xi-information-circle"></i></p>

                        <p class="sub-text">{{xe_trans('xe::itemActivatedDescription')}}</p>

                        <div class="xe-toggle-button btn_right">
                            <label>
                                <span class="sr-only"></span>
                                <input type="checkbox" name="itemActivated" value="1" checked>
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="row_con">
                        <p class="text-title">Item Url</p>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="inpt_url">
                                    @if($menuType::isRouteAble())
                                        <em class="txt_blue">/</em>
                                    @endif
                                    <input type="text" name="itemUrl" class="xe-input-text" value="{{Request::old('itemUrl')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con">
                        <p class="text-title">Item Title<i class="xi-information-circle"></i></p>
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
                            <div class="col-sm-5">
                                <div class="inpt_bd">
                                    {!! uio('langText', ['id' => 'itemTitle', 'langKey'=> '', 'name'=>'itemTitle']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con">
                        <p class="text-title">Item Description<i class="xi-information-circle"></i></p>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="inpt_bd">
                                    <textarea name="itemDescription" class="form-control" rows="3"
                                              placeholder="{{xe_trans('xe::itemDescriptionPlaceHolder')}}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row_con">
                        <p class="text-title">Item Target<i class="xi-information-circle"></i></p>

                        <p class="sub-text">{{xe_trans('xe::itemTargetDescription')}}</p>

                        <div class="row">
                            <div class="col-sm-5">
                                <select name="itemTarget" class="form-control">
                                    <option value="_self" selected>
                                        {{xe_trans('xe::itemTargetOption_sameFrame')}}
                                    </option>
                                    <option value="_black">
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
                        </div>
                    </div>
                    <hr>
                    <div class="row_con v2">
                        <p class="text-title">theme<i class="xi-information-circle"></i></p>

                        <p class="sub-text">{{xe_trans('xe::menuThemeDescription')}}</p>
                        <div class="xe-input-group">
                            <input type="checkbox" name="parentTheme" id="parentTheme" value="1">
                            <label for="parentTheme" class="inpt_chk">{{xe_trans('xe::menuThemeInheritMode')}}</label>
                        </div>
                        <div id="themeSelect">
                        {!! uio('themeSelect', ['selectedTheme' => ['desktop' => $menuConfig->get('desktopTheme'), 'mobile' => $menuConfig->get('mobileTheme')]]) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! uio('menuType', $menuTypeArgs) !!}
            <div class="btn_group_all">
                <button type="submit" class="xe-btn xe-btn-blue">{{xe_trans('xe::submit')}}</button>
                <a href="{{ route('settings.menu.select.types')}}" class="xe-btn xe-btn-gray">{{xe_trans('xe::cancel')}}</a>
            </div>
        </div>
    </form>
    <script>
        $('#parentTheme').change(function () {
            $('#themeSelect').toggle();
        });
    </script>
@endsection
