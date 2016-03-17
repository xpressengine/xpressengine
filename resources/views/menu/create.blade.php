@section('page_title', "<h2><a href='".route('settings.menu.index')."'><i class='xi-arrow-left'></i></a>".xe_trans('xe::newMenu')."</h2>")
@section('page_description', '<p class="sub_txt">'.xe_trans('xe::newMenuDescription').'</p>')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.store.menu') }}" method="post">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <input type="hidden" name="siteKey" value="{{ $siteKey }}">
        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                <div class="row">
                    <p class="text-title">{{xe_trans('xe::createMenuTitle')}}</p>
                </div>
                </div>
                <div class="panel-body">
                    <div class="row_con v2">
                    <p class="text-title">Menu Title<i class="xi-information-circle"></i></p>

                        <p class="sub_txt">{{xe_trans('xe::menuTitleDescription')}}</p>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="inpt_bd">
                                    <input type="text" class="xe-input-text" name="menuTitle"
                                           value="{{Input::old('menuTitle')}}"
                                           placeholder="{{xe_trans('xe::menuTitlePlaceHolder')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con">
                    <p class="text-title">Menu Description<i class="xi-information-circle"></i></p>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="inpt_bd">
                                    <textarea name="menuDescription" class="form-control" rows="3"
                                              placeholder="{{xe_trans('xe::menuDescriptionPlaceHolder')}}">{{Input::old('menuDescription')}}</textarea>
                                </div>
                        </div>
                    </div>
                </div>
                    <div class="row_con v2">
                    <p class="text-title">Default Menu Theme<i class="xi-information-circle"></i></p>

                        <p class="sub_txt">{{xe_trans('xe::menuThemeDescription')}}</p>

                        <div class="right_btn">
                            <button class="btn_clse ico_gray pull-left card_close"><i class="xi-angle-down"></i><i
                                        class="xi-angle-up"></i></button>
                        </div>
                        {!! uio('themeSelect') !!}
                </div>

                </div>
            </div>
            <div class="btn_group_all">
                <button class="xe-button xe-button-blue">{{xe_trans('xe::submit')}}</button>
                <a href="{{ route('settings.menu.index')}}" class="xe-button xe-button-gray">{{xe_trans('xe::cancel')}}</a>
            </div>
        </div>

    </form>
@endsection
