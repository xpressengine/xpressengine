@section('page_title')
    <h2>{{ xe_trans('xe::menuPermissionSettings') }}</h2>
@endsection
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.update.permission.menu',$menu->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="put" />

    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::menuPermissionSettings')}} <small>{{xe_trans('xe::editMenuPermissionDescription')}}</small></h3>
                    </div>
                </div>
                <div class="panel-collapse">
                    <div class="panel-heading">
                        <div class="pull-left">
                            @include('menu.partial.menuControlPanel')
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{ xe_trans('xe::accessPermission') }}</label>
                        {!! uio('permission', $access) !!}
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>{{ xe_trans('xe::visiblePermission') }}</label>
                        {!! uio('permission', $visible) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::modify')}}</button>
        </div>
    </div>
</form>
@endsection
