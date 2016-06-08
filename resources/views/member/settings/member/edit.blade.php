
@section('page_description')
    회원정보를 수정하는 페이지 입니다.
@endsection


<div class="row">
    <form class="form" name="fMemberEdit" method="post" action="{{ route('settings.member.edit', [$user->id]) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">회원 수정 - {{ $user->getDisplayName() }}</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{-- displayName --}}
                                {!! uio('formText', ['id'=>'__xe_displayName', 'label'=>'이름', 'placeholder'=>'이름을 입력하세요', 'value'=> $user->displayName, 'name'=>'displayName']) !!}
                            </div>
                            <div class="form-group">
                                <label>이메일</label>
                                {{-- email --}}
                                <div id="__xe_emailSetting" data-user-id="{{ $user->id }}" data-email="{{ $user->email }}"></div>
                            </div>

                            {{-- introduction --}}
                            {!! uio('formTextarea', ['id'=>'__xe_introduction', 'label'=>'소개글', 'placeholder'=>'소개글을 작성해 주세요', 'value'=> $user->introduction, 'name'=>'introduction']) !!}

                            {{-- password --}}
                            {!! uio('formPassword', ['id'=>'__xe_password', 'label'=>'패스워드', 'placeholder'=>'비밀번호를 입력하세요', 'name'=>'password']) !!}

                            {{-- status --}}
                            {!! uio('formSelect', ['id'=>'__xe_status', 'label'=>'상태', 'name'=>'status', 'options'=> $status]) !!}

                        </div>
                        <div class="col-sm-6">

                            {!!  uio('formImage', [
                                'name' => 'profileImgFile',
                                'label' => "프로필사진 <small>(사이즈 ".$profileImgSize['width']."x".$profileImgSize['height'].")</small>",
                                'image' => $user->getProfileImage(),
                                'width' => $profileImgSize['width'],
                                'height' => $profileImgSize['height']
                            ]) !!}

                            <div class="form-group">
                                {{-- rating --}}
                                {!! uio('formSelect', ['id'=>'__xe_rating', 'label'=>'회원등급', 'name'=>'rating', 'options'=> $ratings]) !!}
                            </div>

                            <div class="form-group">
                                {{-- groups --}}
                                {!! uio('formCheckbox', ['id'=>'__xe_rating', 'label'=>'그룹', 'name'=>'groupId', 'checkboxes'=> $groups]) !!}
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
                        <a href="{{ route('settings.member.index') }}" class="btn btn-default btn-lg">취소</a>
                        <button type="submit" class="btn btn-primary btn-lg">저장</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
var url = {
    'mail': {
        'list': "{{ route('settings.member.mail.list') }}",
        'add': "{{ route('settings.member.mail.add') }}",
        'delete': "{{ route('settings.member.mail.delete') }}"
    }
};
</script>
{{ XeFrontend::js('assets/core/member/settings/edit.js')->load() }}
