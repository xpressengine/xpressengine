@section('page_title')
    <h2><a href="{{ route('settings.menu.index') }}"><i class='xi-arrow-left'></i></a>{{ xe_trans('xe::editMenu') }}</h2>
@endsection
@section('page_description', xe_trans('xe::editMenuDescription'))
@extends('menu.layout')
@section('menuContent')
<form action="{{ route('settings.menu.update.menu',$menu->id)}}" method="post">
    <input type="hidden" name="_token" value="{{ Session::token() }}">
    <input type="hidden" name="_method" value="put">

    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">
                            {{xe_trans('xe::editMenu')}}
                            <small>{{xe_trans('xe::editMenuDescription')}}</small>
                        </h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>

                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-heading">
                        <div class="pull-left">
                            @include('menu.partial.menuControlPanel')
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="text-title">Menu Title<br><small>{{xe_trans('xe::menuTitleDescription')}}</small></label>

                            <input type="text" class="form-control" name="menuTitle" value="{{ $menu->title }}"placeholder="{{xe_trans('xe::menuTitlePlaceHolder')}}"/>
                        </div>
                        <div class="form-group">
                            <label class="text-title">Menu Description</label>

                            <textarea name="menuDescription" class="form-control" rows="3"placeholder="{{xe_trans('xe::menuDescriptionPlaceHolder')}}">{{ $menu->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">
                            Default Menu Theme
                            <small>{{xe_trans('xe::menuThemeDescription')}}</small>
                        </h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>

                <div id="collapseTwo" class="panel-collapse collapse in">
                    {!! uio('themeSelect', ['selectedTheme' => ['desktop' => $config->get('desktopTheme'), 'mobile' => $config->get('mobileTheme')]]) !!}
                </div>
            </div>
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">{{xe_trans('xe::update')}}</button>
        </div>
    </div>
</form>
@endsection
