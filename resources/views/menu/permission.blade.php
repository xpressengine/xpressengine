@include('menu.partial.menuPageHeader')
@extends('menu.layout')
@section('menuContent')
    <form action="{{ route('settings.menu.update.permission.menu',$menu->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="put" />

        <div class="col-sm-12">
            <div class="panel menu_detail">
                <div class="panel-heading">
                    <div class="row">
                        <p class="text-title">{{xe_trans('xe::editMenuPermissionDescription')}}</p>
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
                <button type="submit" class="btn btn_apsblue">수정</button>
            </div>
        </div>
    </form>
@endsection
