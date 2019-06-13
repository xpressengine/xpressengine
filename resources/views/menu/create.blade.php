@section('page_title')
    <h2><a href="{{ route('settings.menu.index') }}"><i class='xi-arrow-left'></i></a>{{ xe_trans('xe::newMenu') }}</h2>
@endsection
@section('page_description')
    <small>{{ xe_trans('xe::newMenuDescription') }}</small>
@endsection

@extends('menu.layout')

@section('menuContent')
    <form action="{{ route('settings.menu.store.menu') }}" method="post">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <input type="hidden" name="siteKey" value="{{ $siteKey }}">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::createMenuTitle')}}</h3>
                        </div>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>
                                Menu Title
                                <br>
                                <small>{{xe_trans('xe::menuTitleDescription')}}</small>
                            </label>

                            <input type="text" class="form-control" name="menuTitle" value="{{Request::old('menuTitle')}}"placeholder="{{xe_trans('xe::menuTitlePlaceHolder')}}"/>
                        </div>
                        <div class="form-group">
                            <label>Menu Description</label>
                                <textarea name="menuDescription" class="form-control" rows="3" placeholder="{{xe_trans('xe::menuDescriptionPlaceHolder')}}">{{Request::old('menuDescription')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::theme')}}<small>{{xe_trans('xe::menuThemeDescription')}}</small></h3>
                        </div>
                        <div class="pull-right">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                        </div>
                    </div>

                    <div id="collapseTwo" class="panel-collapse collapse in">
                        <div id="themeSelect">
                            {!! uio('themeSelect') !!}
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="pull-right">
                            <a href="{{ route('settings.menu.index')}}" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</a>
                            <button class="btn btn-primary btn-lg">{{xe_trans('xe::submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
