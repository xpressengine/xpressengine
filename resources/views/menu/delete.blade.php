@section('page_title', xe_trans('xe::deleteMenu'))
@include('menu.partial.menuPageHeader')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.delete.menu', $menu->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
        <input type="hidden" name="_method" value="delete"/>
        <input type="hidden" name="menuId" value="{{ $menu->id }}"/>

        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="txt_tit">{{xe_trans('xe::deleteMenuConfig', ['title' => $menu->title])}} </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row_con v2">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="inpt_bd">
                                    @if($menu->countItem() != 0)
                                        이 메뉴는 {{$menu->countItem()}} 개의 메뉴 아이템을 가지고 있습니다.
                                        <br/>메뉴 아이템을 삭제한 뒤 삭제를 다시 시도하십시오.
                                    @else
                                        메뉴 삭제하면 다시 복구할 수 없습니다.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn_group_all">
                @if($menu->countItem() == 0)
                    <button type="submit" class="btn btn_red">{{xe_trans('xe::delete')}}</button>
                @endif
                <a href="{{ route('settings.menu.index')}}" class="btn btn_gray">{{xe_trans('xe::cancel')}}</a>
            </div>
        </div>
    </form>
@endsection
