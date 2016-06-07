
    <form class="form" name="fMemberCreate" method="post" action="{{ route('settings.member.store') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel-group">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">새 회원 추가</h3>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                        {{-- displayName --}}
                                        {!! XeUI::formText(['id'=>'__xe_displayName', 'label'=>'이름', 'placeholder'=>'이름을 입력하세요', 'value'=> old('displayName'), 'name'=>'displayName']) !!}
                                        {{-- email --}}
                                        {!! XeUI::formText(['id'=>'__xe_email', 'label'=>'이메일', 'placeholder'=>'이메일을 입력하세요', 'value'=> old('email'), 'name'=>'email']) !!}
                                        {{-- password --}}
                                        {!! XeUI::formPassword(['id'=>'__xe_password', 'label'=>'패스워드', 'placeholder'=>'비밀번호를 입력하세요', 'name'=>'password']) !!}
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{-- status --}}
                                        {!! XeUI::formSelect(['id'=>'__xe_status', 'label'=>'상태', 'name'=>'status', 'options'=> $status]) !!}
                                    </div>
                                    <div class="form-group">
                                        {{-- rating --}}
                                        {!! XeUI::formSelect(['id'=>'__xe_rating', 'label'=>'회원등급', 'name'=>'rating', 'options'=> $ratings]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! XeUI::formCheckbox(['id'=>'__xe_rating', 'label'=>'그룹', 'name'=>'groupId', 'checkboxes'=> $groups]) !!}
                                    </div>
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
                                <button type="button" class="btn btn-default btn-lg">취소</button>
                                <button type="submit" class="btn btn-primary btn-lg">저장</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

