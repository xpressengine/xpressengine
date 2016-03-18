@include('menu.partial.itemPageHeader')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.update.item', [$menu->id, $item->id])}}" method="post">
        <input type="hidden" name="_method" value="put"/>
        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
        <input type="hidden" name="itemOrdering" value="{{ $item->ordering }}"/>

        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="text-title">{{xe_trans('xe::editItemDescription')}}</p>
                        <div class="right_btn">
                            <button class="btn-close ico_gray pull-left"><i class="xi-angle-down"></i><i
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
                                @if($item->id == $homeId)
                                    <input type="checkbox" name="dummyActivated" value="1" checked disabled/>
                                    <input type="hidden" name="itemActivated" value="1"/>
                                @else
                                    <input type="checkbox" name="itemActivated"
                                           {{ ($item->activated === 1)?"checked":'' }} value="1"/>
                                @endif
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
                                    @if( $menuType !== null && $menuType::isRouteAble())
                                        <em class="txt_blue">/</em>
                                    @endif
                                    <input type="text" name="itemUrl" class="xe-input-text" value="{{ $item->url }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con">
                        <p class="text-title">Item Title<i class="xi-information-circle"></i></p>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="inpt_bd">
                                    {!! uio('langText', ['id' => 'itemTitle', 'langKey'=> $item->title, 'name'=>'itemTitle']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con">
                        <p class="text-title">Item Description<i class="xi-information-circle"></i></p>

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="inpt_bd">
                                <textarea name="itemDescription" class="form-control" rows="3"
                                          placeholder="{{xe_trans('xe::itemDescriptionPlaceHolder')}}">{{ $item->description }}</textarea>

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
                                    <option value="_self" {{ ($item->target === "_self")? "selected":"" }}>
                                        {{xe_trans('xe::itemTargetOption_sameFrame')}}
                                    </option>
                                    <option value="_black" {{ ($item->target === "_black")? "selected":"" }}>
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
                        </div>
                    </div>
                    <hr>
                    <div class="row_con v2">
                        <p class="text-title">theme<i class="xi-information-circle"></i></p>

                        <p class="sub-text">테마를 미리 보고 클릭하여 선택할 수 있습니다.</p>
                        <div class="xe-input-group">
                            <input type="checkbox" name="parentTheme" id="parentTheme" value="1"
                                   @if($parentThemeMode) checked @endif>
                            <label for="parentTheme" class="inpt_chk">{{xe_trans('xe::menuThemeInheritMode')}}</label>
                        </div>
                        <div id="themeSelect" @if($parentThemeMode) style="display:none" @endif>
                            {!! uio('themeSelect', ['selectedTheme' => ['desktop' => $itemConfig->get('desktopTheme'), 'mobile' => $itemConfig->get('mobileTheme')]]) !!}
                        </div>
                    </div>
                </div>
            </div>
            @if($menuType !== null)
                {!! uio('menuType', ['menuType' => $menuType, 'action' => 'editMenuForm', 'param' => $item->id ]) !!}
            @else
                @include('menu.partial.typeLoadError', ['item' => $item])
            @endif
            <div class="btn_group_all">
                <button class="xe-btn xe-btn-blue">{{xe_trans('xe::save')}}</button>
                <a href="{{route('settings.menu.index')}}" class="xe-btn xe-btn-gray">{{xe_trans('xe::cancel')}}</a>
            </div>
        </div>
    </form>
    <script>
        $('#parentTheme').change(function () {
            $('#themeSelect').toggle();
        });
    </script>
@endsection
