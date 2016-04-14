@section('page_title', xe_trans('xe::deleteMenu'))
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.delete.menu', $menu->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
    <input type="hidden" name="_method" value="delete"/>
    <input type="hidden" name="menuId" value="{{ $menu->id }}"/>

    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">메뉴 삭제<small>{{xe_trans('xe::deleteMenuConfig', ['title' => $menu->title])}}</small></h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        @if($menu->items->count() != 0)
                            이 메뉴는 {{$menu->items->count()}}개의 메뉴 아이템을 가지고 있습니다.
                            <br/>메뉴 아이템을 삭제한 뒤 삭제를 다시 시도하십시오.
                        @else
                            메뉴 삭제하면 다시 복구할 수 없습니다.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a href="{{ route('settings.menu.index')}}" class="btn btn-default">{{xe_trans('xe::cancel')}}</a>
            @if($menu->items->count() == 0)
            <button type="submit" class="btn btn-danger">{{xe_trans('xe::delete')}}</button>
            @endif
        </div>
    </div>
</form>
@endsection
