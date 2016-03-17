@section('page_title', xe_trans($item->title).'-'.xe_trans('xe::editItemPermission'))
@include('menu.partial.itemPageHeader')
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.update.permission.item', [$menu->id, $item->id]) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="put" />

    <div class="col-sm-12">
        <div class="panel menu_detail">
            <div class="panel-heading">
                <div class="row">
                    <p class="txt_tit">{{xe_trans('xe::editItemPermissionDescription')}}</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row_con v2">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="inpt_bd">
                                {!! uio('permission', $access) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row_con v2">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="inpt_bd">
                                {!! uio('permission', $visible) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn_group_all">
            <button type="submit" class="xe-button xe-button-blue">{{xe_trans('xe::update')}}</button>
        </div>
    </div>
</form>
@endsection
