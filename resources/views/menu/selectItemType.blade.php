@section('page_title', "<h2><a href='".route('settings.menu.index')."'><i class='xi-arrow-left'></i></a>".xe_trans('xe::selectItemType')."</h2>")
@section('page_description', '<p class="sub-text">'.xe_trans('xe::selectItemTypeDescription').'</p>')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.create.item', [$menuId]) }}" method="get">
        <input type="hidden" name="parent" value="{{$parent}}"/>
        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="text-title">{{xe_trans('xe::selectItemTypeDescription')}}</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row_cont v2">
                        <p class="text-title">{{xe_trans('xe::menuItemType')}}<i class="xi-information-circle"></i></p>
                        {!! uio('uiobject/xpressengine@typeSelect') !!}
                    </div>
                </div>
            </div>
            <div class="btn_group_all">
                <button class="xe-btn xe-btn-blue">{{xe_trans('xe::next')}}</button>
                <a href="{{route('settings.menu.index')}}" class="xe-btn xe-btn-gray">{{xe_trans('xe::cancel')}}</a>
            </div>
        </div>
    </form>
@endsection
