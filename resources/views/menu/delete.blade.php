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
                        <h3 class="panel-title">{{ xe_trans('xe::deleteMenu') }}<small>{{xe_trans('xe::deleteMenuConfig', ['title' => $menu->title])}}</small></h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        @if($menu->items->count() != 0)
                            {!! xe_trans('xe::menuDeleteCautionHaveItems', ['count' => $menu->items->count()]) !!}
                        @else
                            {{xe_trans('xe::menuDeleteCaution')}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a href="{{ route('settings.menu.index')}}" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</a>
            @if($menu->items->count() == 0)
            <button type="submit" class="btn btn-danger btn-lg">{{xe_trans('xe::delete')}}</button>
            @endif
        </div>
    </div>
</form>
@endsection
