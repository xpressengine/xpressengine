
    <form class="form" name="fMemberCreate" method="post" action="{{ route('settings.member.store') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-6">
                {{-- email --}}
                {!! XeUI::formText(['id'=>'__xe_email', 'label'=>'이메일', 'placeholder'=>'이메일을 입력하세요', 'value'=> old('email'), 'name'=>'email']) !!}
            </div>
            <div class="col-md-6">
                {{-- displayName --}}
                {!! XeUI::formText(['id'=>'__xe_displayName', 'label'=>'표시이름', 'placeholder'=>'표시이름을 입력하세요', 'value'=> old('displayName'), 'name'=>'displayName']) !!}
            </div>
            <div class="col-md-6">
                {{-- password --}}
                {!! XeUI::formPassword(['id'=>'__xe_password', 'label'=>'패스워드', 'placeholder'=>'비밀번호를 입력하세요', 'name'=>'password']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {{-- rating --}}
                {!! XeUI::formSelect(['id'=>'__xe_rating', 'label'=>'회원등급', 'name'=>'rating', 'options'=> $ratings]) !!}
            </div>
            <div class="col-md-6">
                {{-- status --}}
                {!! XeUI::formSelect(['id'=>'__xe_status', 'label'=>'상태', 'name'=>'status', 'options'=> $status]) !!}
            </div>
        </div>

        {{-- groups --}}
        {!! XeUI::formCheckbox(['id'=>'__xe_rating', 'label'=>'그룹', 'name'=>'groupId', 'checkboxes'=> $groups]) !!}

        @foreach($fieldTypes as $fieldType)
        <div class="form-group has-feedback">
        {!! $fieldType->getSkin()->create(Input::all()) !!}
        </div>
        @endforeach

        <div class="btn-toolbar text-right">

            <button type="submit" class="btn btn-primary">등록</button>
        </div>

    </form>

