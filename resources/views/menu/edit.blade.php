@section('page_title', xe_trans('xe::editMenu'))
@include('menu.partial.menuPageHeader')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.update.menu',$menu->id)}}" method="post">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <input type="hidden" name="_method" value="put">

        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="txt_tit">{{xe_trans('xe::editMenuDescription')}}</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row_con v2">
                        <p class="txt_tit">Menu Title<i class="xi-information-circle"></i></p>

                        <p class="sub_txt">{{xe_trans('xe::menuTitleDescription')}}</p>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="inpt_bd">
                                    <input type="text" class="inpt_txt" name="menuTitle" value="{{ $menu->title }}"
                                           placeholder="{{xe_trans('xe::menuTitlePlaceHolder')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con">
                        <p class="txt_tit">Menu Description<i class="xi-information-circle"></i></p>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="inpt_bd">
                                    <textarea name="menuDescription" class="form-control" rows="3"
                                              placeholder="{{xe_trans('xe::menuDescriptionPlaceHolder')}}">{{ $menu->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_con v2">
                        <p class="txt_tit">Default Menu Theme<i class="xi-information-circle"></i></p>

                        <p class="sub_txt">{{xe_trans('xe::menuThemeDescription')}}</p>

                        {!! uio('themeSelect', ['selectedTheme' => ['desktop' => $config->get('desktopTheme'), 'mobile' => $config->get('mobileTheme')]]) !!}
                    </div>

                </div>
            </div>
            <div class="btn_group_all">
                <button type="submit" class="btn btn_blue">{{xe_trans('xe::update')}}</button>
            </div>
        </div>
    </form>
@endsection
