@section('page_title', '<h2>' . xe_trans($item->title).'-'.xe_trans('xe::editItemPermission') . '</h2>')
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.update.permission.item', [$menu->id, $item->id]) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="put" />

    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::editItemPermissionDescription')}}</h3>
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        @include('menu.partial.itemControlPanel')
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! uio('permission', $access) !!}
                    </div>
                    <hr/>
                    <div class="form-group">
                        {!! uio('permission', $visible) !!}
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="xe-btn xe-btn-blue">{{xe_trans('xe::update')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
