<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                <form name="fGroupCreate" method="post" action="{{ route('manage.group.create') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::addNewGroup')}}</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                {!! uio('formText', ['label'=>xe_trans('xe::groupName'), 'placeholder'=>xe_trans('xe::enterName'), 'value'=> old('name'), 'name'=>'name']) !!}
                            </div>
                            <div class="col-sm-12">
                                {!! uio('formTextarea', ['label'=>xe_trans('xe::description'), 'placeholder'=>xe_trans('xe::enterDescription'), 'value'=> old('description'), 'name'=>'description']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <a href="{{ route('manage.group.index') }}" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</a>
                            <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
