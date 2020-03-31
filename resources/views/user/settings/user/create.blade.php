
    <form class="form" name="fUserCreate" method="post" action="{{ route('settings.user.store') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel-group">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">{{xe_trans('xe::addUser')}}</h3>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                        {{-- displayName --}}
                                        {!! XeUI::formText(['id'=>'__xe_displayName', 'label'=>xe_trans(app('xe.config')->getVal('user.register.display_name_caption')), 'placeholder'=>xe_trans('xe::enterDisplayName', ['displayNameCaption' => xe_trans(app('xe.config')->getVal('user.register.display_name_caption'))]), 'value'=> old('display_name'), 'name'=>'display_name']) !!}
                                        {{-- email --}}
                                        {!! XeUI::formText(['id'=>'__xe_email', 'label'=>xe_trans('xe::email'), 'placeholder'=>xe_trans('xe::enterEmail'), 'value'=> old('email'), 'name'=>'email']) !!}
                                        {{-- loginId --}}
                                        {!! XeUI::formText(['id'=>'__xe_loginId', 'label'=>xe_trans('xe::id'), 'placeholder'=>xe_trans('xe::enterId'), 'value'=> old('login_id'), 'name'=>'login_id']) !!}
                                        {{-- password --}}
                                        {!! XeUI::formPassword(['id'=>'__xe_password', 'label'=>xe_trans('xe::password'), 'placeholder'=>xe_trans('xe::enterPassword'), 'name'=>'password', 'autocomplete'=>"new-password"]) !!}
                                </div>
                                <div class="col-sm-6">
                                        {{-- status --}}
                                        {!! XeUI::formSelect(['id'=>'__xe_status', 'label'=>xe_trans('xe::status'), 'name'=>'status', 'options'=> $status]) !!}
                                        {{-- rating --}}
                                        {!! XeUI::formSelect(['id'=>'__xe_rating', 'label'=>xe_trans('xe::userRating'), 'name'=>'rating', 'options'=> $ratings]) !!}
                                        {!! XeUI::formCheckbox(['id'=>'__xe_rating', 'label'=>xe_trans('xe::group'), 'name'=>'group_id', 'checkboxes'=> $groups]) !!}
                                </div>
                                <div class="col-sm-12">
                                    @foreach($fieldTypes as $fieldType)
                                        <div class="form-group has-feedback">
                                            {!! $fieldType->getSkin()->create(Request::all()) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <a href="{{ route('settings.user.index') }}" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</a>
                                <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

