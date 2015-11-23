{{ Frontend::js('assets/vendor/react/JSXTransformer.js')->before('assets/vendor/react/react.js')->appendTo('head')->load() }}

@section('page_title')
    <h2>회원 수정 - {{ $member->getDisplayName()  }}</h2>
@endsection

@section('page_description')
    회원정보를 수정하는 페이지 입니다.
@endsection

<div class="panel">
    <div class="panel-body">
        <form class="form" name="fMemberEdit" method="post" action="{{ route('settings.member.edit', [$member->id]) }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>이메일</label>
                                        {{-- email --}}
                                        <div id="__xe_emailSetting"></div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    {{-- displayName --}}
                                    {!! uio('formText', ['id'=>'__xe_displayName', 'label'=>'표시이름', 'placeholder'=>'표시이름을 입력하세요', 'value'=> $member->displayName, 'name'=>'displayName']) !!}
                                </div>
                                <div class="col-md-12">
                                    {{-- introduction --}}
                                    {!! uio('formTextarea', ['id'=>'__xe_introduction', 'label'=>'소개글', 'placeholder'=>'소개글을 입력하세요', 'value'=> $member->introduction, 'name'=>'introduction']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!!  uio('formImage',
                            [
                            'name' => 'profileImgFile',
                            'label' => "프로필사진 (".$profileImgSize['width']."x".$profileImgSize['height'].")",
                            'image' => $member->getProfileImage(),
                            'width' => $profileImgSize['width'],
                            'height' => $profileImgSize['height']
                            ]
                            ) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    {{-- password --}}
                    {!! uio('formPassword', ['id'=>'__xe_password', 'label'=>'패스워드', 'placeholder'=>'비밀번호를 입력하세요', 'name'=>'password']) !!}
                </div>
                <div class="col-md-6">
                    {{-- rating --}}
                    {!! uio('formSelect', ['id'=>'__xe_rating', 'label'=>'회원등급', 'name'=>'rating', 'options'=> $ratings]) !!}
                </div>
                <div class="col-md-6">
                    {{-- status --}}
                    {!! uio('formSelect', ['id'=>'__xe_status', 'label'=>'상태', 'name'=>'status', 'options'=> $status]) !!}
                </div>
                <div class="col-md-6">
                    {{-- groups --}}
                    {!! uio('formCheckbox', ['id'=>'__xe_rating', 'label'=>'그룹', 'name'=>'groupId', 'checkboxes'=> $groups]) !!}
                </div>
            </div>

            @foreach($fieldTypes as $fieldType)
                <div class="form-group has-feedback">
                    {!! $fieldType->getSkin()->edit($member->toArray()) !!}
                </div>
            @endforeach

            <div class="btn-toolbar text-right">
                <button type="submit" class="btn btn-primary">저장</button>
            </div>

        </form>
    </div>
</div>



<script>
    XE.$(function () {
        $('.__xe_settingEmail').click(function(){
            $('.__xe_emailView').slideToggle();
            $('#__xe_emailSetting').slideToggle();
        })
    });
</script>
<script type="text/jsx">
    XE.$(function () {

        var url = {
            'mail': {
                'list': "{{ route('settings.member.mail.list') }}",
                'add': "{{ route('settings.member.mail.add') }}",
                'delete': "{{ route('settings.member.mail.delete') }}"
            }
        };

        var EmailBox = React.createClass({
            componentDidMount: function () {
                this.loadCommentsFromServer();
            },
            getInitialState: function () {
                return {mails: [], selected: this.props.email};
            },
            loadCommentsFromServer: function () {
                $.ajax({
                    url: this.props.url.mail.list,
                    type: 'get',
                    dataType: 'json',
                    data: {memberId: this.props.memberId},
                    context: this,
                    success: function (result) {
                        this.setState({mails: result.mails});
                    },
                    error: function (result) {
                        alertBox('danger', '오류!.', '.__xe_alertEmailModal');
                    }
                });
            },
            handleChange: function(address) {
                this.setState($.extend(this.state, {selected: address}));
            },
            handleAddEmail: function (email) {
                $.ajax({
                    url: this.props.url.mail.add,
                    type: 'post',
                    dataType: 'json',
                    data: {memberId: this.props.memberId, address: email.address},
                    context: this,
                    success: function (result) {
                        var mails = this.state.mails;
                        mails[mails.length] = result.mail;
                        this.setState({mails: mails});
                        alertBox('success', '추가되었습니다.', '.__xe_alertEmailModal');
                    },
                    error: function (result) {
                        alertBox('danger', result.responseJSON.message, '.__xe_alertEmailModal');
                    }
                });
            },
            handleDeleteEmail: function (email) {

                $.ajax({
                    url: this.props.url.mail.delete,
                    type: 'post',
                    dataType: 'json',
                    data: {memberId: this.props.memberId, address: email.address},
                    context: this,
                    success: function (result) {
                        var i = this.state.mails.indexOf(email);
                        this.state.mails.splice(i,1);
                        this.setState(this.state.mails);
                        alertBox('success', '삭제하였습니다.', '.__xe_alertEmailModal');
                    },
                    error: function (result) {
                        alertBox('danger', result.responseJSON.message, '.__xe_alertEmailModal');
                    }
                });
            },
            render: function () {
                return (
                    <div>
                        <EmailList
                            box={this}
                            selected={this.state.selected}
                            selectedOrigin={this.props.email}
                            mails={this.state.mails} onChange={this.handleChange} onDeleteEmail={this.handleDeleteEmail} />
                        <EmailInserter onAddEmail={this.handleAddEmail} />
                    </div>
                )
            }
        });
        var EmailList = React.createClass({
            handleChange: function(address) {
                this.props.onChange(address);
            },
            render: function () {
                var mails = this.props.mails;
                var selected = this.props.selected;
                var selectedOrigin = this.props.selectedOrigin;
                var self = this;
                var selectedItem = null;
                var lists = mails.map(function (mail, i) {
                    var item = (
                        <EmailItem
                        box={self.props.box}
                        seq={i}
                        isSelected={mail.address == selected}
                        isSelectedOrigin={mail.address == selectedOrigin}
                        mail={mail} onChange={self.handleChange} onDeleteEmail={self.props.onDeleteEmail} />
                    );
                    if(mail.address != selected) {
                        return item;
                    } else {
                        selectedItem = item;
                    }
                });
                return (
                    <ul className="list-group">
                        {selectedItem}
                        {lists}
                    </ul>
                );
            }
        });
        var EmailItem = React.createClass({
            componentDidMount: function () {
                console.log(this.props.seq);
                this.deleteBtn = $(React.findDOMNode(this.refs.deleteBtn));
                this.deleteConfirmBtn = $(React.findDOMNode(this.refs.deleteConfirmBtn));
                this.deleteCancelBtn = $(React.findDOMNode(this.refs.deleteCancelBtn));
            },
            handleChange: function (e) {
                this.props.onChange(this.props.mail.address)
            },
            handleDelete: function () {
                this.deleteBtn.hide();
                this.deleteConfirmBtn.show();
                this.deleteCancelBtn.show();
            },
            handleDeleteConfirm: function () {
                this.props.onDeleteEmail(this.props.mail);
            },
            handleDeleteCancel: function () {
                this.deleteBtn.show();
                this.deleteConfirmBtn.hide();
                this.deleteCancelBtn.hide();
            },
            render: function () {
                var mail = this.props.mail;

                var deleteBtns = null;

                if(!this.props.isSelectedOrigin) {
                    deleteBtns = (
                        <span className="pull-right">
                        <a ref="deleteBtn" href="#" className="btn btn-sm btn-link" onClick={this.handleDelete}>삭제</a>
                        <a ref="deleteConfirmBtn" href="#" style=@{{'display':'none'}} className="btn btn-sm btn-link" onClick={this.handleDeleteConfirm}>삭제확인</a>
                        <a ref="deleteCancelBtn" href="#" style=@{{'display':'none'}} className="btn btn-sm btn-link" onClick={this.handleDeleteCancel}>취소</a>
                        </span>
                    );
                }

                return (
                    <li className="list-group-item clearfix">
                            <label>
                                <input type="radio" ref="input" onChange={this.handleChange} name="email" value={mail.address} checked={this.props.isSelected} />&nbsp; { mail.address }
                            </label>
                            {deleteBtns}
                    </li>
                );
            }
        });
        var EmailInserter = React.createClass({
            handleClick: function (e) {
                e.preventDefault();
                var input = $(React.findDOMNode(this.refs.input));
                var email = input.val();
                if (!email) {
                    return;
                }
                input.val('');
                this.props.onAddEmail({address: email});
            },
            render: function () {
                return (
                    <div className="input-group input-group-sm" style=@{{ marginBottom: '20px' }} >
                        <input type="text" className="form-control" id="__xe_addedEmailInput" ref='input' placeholder="이메일을 입력하세요" />
                        <span className="input-group-btn">
                            <button id="__xe_emailAddBtn" className="btn btn-default" type="button"  onClick={this.handleClick} ref="btn" >추가</button>
                        </span>
                    </div>
                )
            }
        });

        React.render(
            <EmailBox url={url} memberId="{{ $member->id }}" email="{{ $member->email }}"/>,
            document.getElementById('__xe_emailSetting')
        );

    });
</script>

{!! uio('uiobject/xpressengine@chakIt', 'Settings:회원목록') !!}
