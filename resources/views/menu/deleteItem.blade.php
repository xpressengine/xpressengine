@section('page_title', xe_trans('xe::deleteItem'))
@include('menu.partial.menuPageHeader')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.delete.item', [$menu->getKey(), $item->getKey()]) }}" method="post">
    <input type="hidden" name="_token" value="{{ Session::token() }}" />
    <input type="hidden" name="_method" value="delete" />

        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="text-title">{{xe_trans('xe::deleteItemConfirm', ['title' => xe_trans($item->title)])}}</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row_con v2">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="inpt_bd">
                                    @if($item->getDescendantCount() == 0)
                                        {{$menuType->summary($item->getKey())}}
                                        <br/>
                                        메뉴 아이템을삭제하면 다시 복구할 수 없습니다.
                                    @else
                                        이 메뉴 아이템 하위에 {{ $item->countSubItems() }} 개의 메뉴 아이템이 존재하고 있어 삭제할 수 없습니다.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn_group_all">
                @if($item->getDescendantCount() == 0)
                    <button type="submit" class="btn btn_red">{{xe_trans('xe::delete')}}</button>
                @endif
                <a href="{{ route('settings.menu.index')}}" class="xe-btn xe-btn-gray">{{xe_trans('xe::cancel')}}</a>
            </div>
        </div>
    </form>
@endsection
