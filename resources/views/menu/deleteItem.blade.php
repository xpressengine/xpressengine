@section('page_title', xe_trans('xe::deleteItem'))
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.delete.item', [$menu->getKey(), $item->getKey()]) }}" method="post">
    <input type="hidden" name="_token" value="{{ Session::token() }}" />
    <input type="hidden" name="_method" value="delete" />

    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ xe_trans('xe::deleteItem') }}<small>{{xe_trans('xe::deleteItemConfirm', ['title' => xe_trans($item->title)])}}</small></h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        @if($item->getDescendantCount() == 0)
                            {{$menuType->summary($item->getKey())}}
                            <br/>
                            메뉴 아이템을삭제하면 다시 복구할 수 없습니다.
                        @else
                            이 메뉴 아이템 하위에 {{ $item->countSubItems() }} 개의 메뉴 아이템이 존재하고 있어 삭제할 수 없습니다.
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <a href="{{ route('settings.menu.index')}}" class="btn btn-default">{{xe_trans('xe::cancel')}}</a>
                        @if($item->getDescendantCount() == 0)
                            <button type="submit" class="btn btn-danger">{{xe_trans('xe::delete')}}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
