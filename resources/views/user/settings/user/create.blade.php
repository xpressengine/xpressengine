
    <form class="form" name="fMemberCreate" method="post" action="{{ route('settings.user.store') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel-group">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">{{xe_trans('xe::addMember')}}</h3>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                        {{-- displayName --}}
                                        {!! XeUI::formText(['id'=>'__xe_displayName', 'label'=>xe_trans('xe::name'), 'placeholder'=>xe_trans('xe::enterName'), 'value'=> old('display_name'), 'name'=>'display_name']) !!}
                                        {{-- email --}}
                                        {!! XeUI::formText(['id'=>'__xe_email', 'label'=>xe_trans('xe::email'), 'placeholder'=>xe_trans('xe::enterEmail'), 'value'=> old('email'), 'name'=>'email']) !!}
                                        {{-- password --}}
                                        {!! XeUI::formPassword(['id'=>'__xe_password', 'label'=>xe_trans('xe::password'), 'placeholder'=>xe_trans('xe::enterPassword'), 'name'=>'password', 'autocomplete'=>"new-password"]) !!}
                                </div>
                                <div class="col-sm-6">
                                        {{-- status --}}
                                        {!! XeUI::formSelect(['id'=>'__xe_status', 'label'=>xe_trans('xe::status'), 'name'=>'status', 'options'=> $status]) !!}
                                        {{-- rating --}}
                                        {!! XeUI::formSelect(['id'=>'__xe_rating', 'label'=>xe_trans('xe::memberRating'), 'name'=>'rating', 'options'=> $ratings]) !!}
                                        {!! XeUI::formCheckbox(['id'=>'__xe_rating', 'label'=>xe_trans('xe::group'), 'name'=>'groupId', 'checkboxes'=> $groups]) !!}
                                </div>
                                <div class="col-sm-12">
                                    @foreach($fieldTypes as $fieldType)
                                        <div class="form-group has-feedback">
                                            {!! $fieldType->getSkin()->create(Input::all()) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <button type="button" class="btn btn-default btn-lg">{{xe_trans('xe::cancel')}}</button>
                                <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

