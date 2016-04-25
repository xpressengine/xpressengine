@section('page_setting_menu')
<a href="{{ route('settings.member.create') }}" class="xe-btn xe-btn-blue v2 pull-right">{{ xe_trans('xe::addMember') }}</a>
@endsection
<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">회원목록</h3>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('settings.member.create') }}" class="btn btn-primary"><i class="xi-plus"></i><span>새회원 추가</span></a>
                    </div>
                </div>

                <div class="panel-heading">
                    <div class="pull-left">
                        <div class="btn-group btn-fillter" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="xe-dropdown-menu" role="menu">
                                <li><strong>승인/거부</strong></li>
                                <li @if(!Input::get('status')) class="active" @endif><a href="{{ route('settings.member.index', Input::except('status') ) }}">전체</a></li>
                                <li @if(Input::get('status') === \XeUser::STATUS_ACTIVATED) class="active" @endif><a href="{{ route('settings.member.index', array_merge(Input::all(), ['status'=> \XeUser::STATUS_ACTIVATED] )) }}">승인됨</a></li>
                                <li @if(Input::get('status') === \XeUser::STATUS_DENIED) class="active" @endif><a href="{{ route('settings.member.index', array_merge(Input::all(), ['status'=> \XeUser::STATUS_DENIED] )) }}">거부됨</a></li>
                                <li class="divider"></li>
                                <li><strong>그룹</strong></li>
                                <li @if(!Input::get('group'))class="active"@endif><a href="{{ route('settings.member.index', Input::except(['group'])) }}"><span>전체 그룹</span></a></li>
                                @foreach($groups as $key => $group)
                                <li @if(Input::get('group') === $group->id)class="active"@endif><a href="{{ route('settings.member.index', array_merge( Input::all(), ['group'=> $group->id] )) }}">{{ $group->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default __xe_remove">선택회원 삭제</button>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="input-group search-group">
                            <form method="GET" action="{{ route('settings.member.index') }}" accept-charset="UTF-8" role="form" id="_search-form">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="__xe_selectedKeyfield">
                                        @if(Input::get('keyfield')==='dispalyName')
                                            이름
                                        @elseif(Input::get('keyfield')==='email')
                                            이메일
                                        @else
                                            검색대상
                                        @endif
                                        </span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="xe-dropdown-menu" role="menu">
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="displayName">이름</a></li>
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="email">이메일</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                                <input type="text" name="keyword" class="form-control" aria-label="Text input with dropdown button" placeholder="검색어를 입력하세요." value="{{ Input::get('keyword') }}">
                                <button type="submit" class="btn-link">
                                    <i class="xi-magnifier"></i><span class="sr-only">검색</span>
                                </button>
                                @foreach(Input::except(['keyfield','keyword']) as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <input type="hidden" class="__xe_keyfield" name="keyfield" value="{{ Input::get('keyfield') }}">
                            </form>
                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                <form id="__xe_fList" method="post" action="{{ route('settings.member.destroy') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" class="__xe_check-all"></th>
                            <th scope="col">이름</th>
                            <th scope="col">계정</th>
                            <th scope="col">이메일</th>
                            <th scope="col">가입일</th>
                            <th scope="col">회원그룹</th>
                            <th scope="col">상태</th>
                            <th scope="col">관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><input name="userId" class="__xe_checkbox" type="checkbox" value="{{ $user->getId() }}" @if($user->rating === \Xpressengine\User\Rating::SUPER) disabled @endif></td>
                            <td>
                                <img data-toggle="xeUserMenu" data-user-id="{{ $user->getId() }}" src="{{ $user->getProfileImage() }}" width="30" height="30" alt="프로필" class="member-profile">
                                <a href="#" data-toggle="xeUserMenu" data-user-id="{{ $user->getId() }}" data-text="{{ $user->getDisplayName() }}">{{ $user->getDisplayName() }}</a></i>
                            </td>
                            <td>

                                @if(count($user->accounts))
                                    @foreach($user->accounts as $account)
                                        <span data-toggle="tooltip" class="xe-badge grey {{ $account->provider }}" title="{{ $account->provider }}"><i class="xi-{{ $account->provider }}"></i></span>
                                    @endforeach
                                @else
                                    <span data-toggle="tooltip" class="xe-badge black" title="기본">xe</span>
                                @endif
                            </td>
                            <td>{{ data_get($user, 'email', '없음') }}</td>
                            <td>{!! $user->createdAt->format('y-m-d') !!}</td>
                            <td>
                                @if($user->groups !== null)
                                    {{ implode(', ', array_pluck($user->groups, 'name')) }}
                                @endif
                            </td>
                            <td>
                                @if($user->status===\XeUser::STATUS_DENIED)
                                <label class="label label-danger">거부됨</label>
                                @else
                                <label class="label label-green">승인됨</label>
                                @endif
                            </td>
                            <td><a href="{{ route('settings.member.edit', ['id' => $user->getId()]) }}" class="btn btn-default">관리</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
                </div>
                @if($pagination = $users->render())
                <div class="panel-footer">
                    <div class="pull-left">
                        <nav>
                            {!! $pagination !!}
                        </nav>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var MemberList = (function() {
        var self;

        return {
            init: function() {
                self = this;

                self.cache();
                self.bindEvents();

                return this;
            },
            cache: function() {
                self.$selectKeyfield = $('.__xe_selectKeyfield');
                self.$selectedKeyfield = $('.__xe_selectedKeyfield');
                self.$keyfield = $('.__xe_keyfield');
                self.$checkAll = $('.__xe_check-all');
                self.$remove = $('.__xe_remove');
                self.$tooltip = $('[data-toggle=tooltip]');
                self.$dropdownToggle = $('.dropdown-toggle');
            },
            bindEvents: function() {
                //tooltip;
                self.$tooltip.tooltip();

                //dropdown toggle
                self.$dropdownToggle.dropdown();

                self.$selectKeyfield.on('click', self.selectKeyfield);
                self.$checkAll.on('change', self.checkAll);
                self.$remove.on('click', self.remove);
            },
            selectKeyfield: function(e) {
                e.preventDefault();

                var $this = $(this),
                        val = $this.attr('data-value'),
                        name = $this.text();

                self.$selectedKeyfield.text(name);
                self.$keyfield.val(val);

            },
            checkAll: function(e) {
                if ($(this).is(':checked')) {
                    $('input.__xe_checkbox:not(disabled)').prop('checked', true);
                } else {
                    $('input.__xe_checkbox:not(disabled)').prop('checked', false);
                }
            },
            remove: function() {
                if (!$('input.__xe_checkbox:checked').is('input')) {
                    return false;
                }
                var $f = $('#__xe_fList');
                $('<input type="hidden" name="_method" value="DELETE">').prependTo($f);
                $f.submit();
            }
        }
    })().init();
</script>

