{{ XeFrontend::css('/assets/core/theme/menutype-select.css')->load() }}

@section('page_title')
    <h2><a href="{{ route('settings.menu.index') }}"><i class='xi-arrow-left'></i></a>{{ xe_trans('xe::selectItemType') }}</h2>
@endsection
@section('page_description')
    <small>{{ xe_trans('xe::selectItemTypeDescription') }}</small>
@endsection
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.create.item', [$menuId]) }}" method="get">
        <input type="hidden" name="parent" value="{{$parent}}"/>
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::menuItemType')}}</h3>
                        </div>
                    </div>

                    <div class="panel-body">
                        {!! uio('uiobject/xpressengine@typeSelect') !!}
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <a href="{{route('settings.menu.index')}}" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</a>
                            <button class="btn btn-primary btn-lg">{{xe_trans('xe::next')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
