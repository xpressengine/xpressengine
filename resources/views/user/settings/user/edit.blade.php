<div class="container-fluid container-fluid--part">
    <div class="row">
        <form class="form" name="fUserEdit" method="post" action="{{ route('settings.user.update', [$user->id]) }}" enctype="multipart/form-data">
            {{ method_field('put') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::editUser')}} - {{ $user->getDisplayName() }}</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{-- displayName --}}
                                    {!! uio('formText', ['id'=>'__xe_displayName', 'label'=>xe_trans(app('xe.config')->getVal('user.register.display_name_caption')), 'placeholder'=>xe_trans('xe::enterDisplayName', ['displayNameCaption' => xe_trans(app('xe.config')->getVal('user.register.display_name_caption'))]), 'value'=> $user->display_name, 'name'=>'display_name']) !!}
                                </div>
                                <div class="form-group">
                                    <label>{{xe_trans('xe::email')}}</label>
                                    {{-- email --}}
                                    <div id="__xe_emailSetting" data-user-id="{{ $user->id }}" data-email="{{ $user->email }}"></div>
                                </div>

                                {!! uio('formText', ['id'=>'__xe_loginId', 'label'=>xe_trans('xe::id'), 'placeholder'=>xe_trans('xe::enterId'), 'value'=> $user->login_id, 'name'=>'login_id']) !!}

                                {{-- introduction --}}
                                {!! uio('formTextarea', ['id'=>'__xe_introduction', 'label'=>xe_trans('xe::introduction'), 'placeholder'=>xe_trans('xe::enterIntroduction'), 'value'=> $user->introduction, 'name'=>'introduction']) !!}

                                {{-- password --}}
                                {!! uio('formPassword', ['id'=>'__xe_password', 'label'=>xe_trans('xe::password'), 'placeholder'=>xe_trans('xe::enterPassword'), 'name'=>'password', 'autocomplete'=>"new-password"]) !!}

                                {{-- status --}}
                                {!! uio('formSelect', ['id'=>'__xe_status', 'label'=>xe_trans('xe::status'), 'name'=>'status', 'options'=> $status]) !!}


                                {{-- accounts --}}
                                @if(count($user->accounts))
                                <div class="form-group">
                                    <label>{{ xe_trans('xe::connectedAccount') }}</label>
                                    <ul class="list-group">
                                        @foreach($user->accounts as $account)
                                            <li class="list-group-item"><span class="{{ $account->provider }}" title="{{ $account->provider }}"><i class="xi-{{ $account->provider }}"></i></span> {{ $account->provider }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                            </div>
                            <div class="col-sm-6">

                                {!!  uio('formImage', [
                                    'name' => 'profile_img_file',
                                    'label' => xe_trans('xe::profileImage') . " <small>(Size ".$profileImgSize['width']."x".$profileImgSize['height'].")</small>",
                                    'value' => ['path' => $user->getProfileImage()],
                                    'width' => $profileImgSize['width'],
                                    'height' => $profileImgSize['height']
                                ]) !!}

                                <div class="form-group">
                                    {{-- rating --}}
                                    {!! uio('formSelect', ['id'=>'__xe_rating', 'label'=>xe_trans('xe::userRating'), 'name'=>'rating', 'options'=> $ratings]) !!}
                                </div>

                                <div class="form-group">
                                    {{-- groups --}}
                                    {!! uio('formCheckbox', ['id'=>'__xe_rating', 'label'=>xe_trans('xe::group'), 'name'=>'group_id', 'checkboxes'=> $groups]) !!}
                                </div>

                                @foreach($fieldTypes as $fieldType)
                                    <div class="form-group has-feedback">
                                        {!! $fieldType->getSkin()->edit($user->toArray()) !!}
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
        </form>
    </div>
</div>

@expose_route('settings.user.mail.list')
@expose_route('settings.user.mail.add')
@expose_route('settings.user.mail.delete')

{{ XeFrontend::js([
    'assets/core/user/settings/edit.js'
])->load() }}
