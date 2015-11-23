
@section('page_setting_menu')
<a href="{{ route('settings.member.create') }}" class="btn btn_blue v2 pull-right">{{ xe_trans('xe::addMember') }}</a>
@endsection

        <!--[DD] panel-default와 같이 서브속성이 지정되어야 기본 bs환경에서 제대로 출력됨 -->
        <div class="panel">
            <div class="panel-heading">
                <!--[DD] panel-heading.row에 좌우마진도 유지하면 좋겠음-->
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default __xe_remove">선택회원 삭제</button>
                        </div>

                        {{-- status --}}
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                @if(Input::get('status') === \Member::STATUS_ACTIVATED)
                                    승인됨
                                @elseif(Input::get('status') === \Member::STATUS_DENIED)
                                    거부됨
                                @else
                                    승인/거부
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('settings.member.index', Input::except('status') ) }}" @if(! Input::has('status')) active @endif">전체</a></li>
                                <li><a href="{{ route('settings.member.index', array_merge(Input::all(), ['status'=> \Member::STATUS_ACTIVATED] )) }}" @if(Input::get('status') === \Member::STATUS_ACTIVATED) active @endif">승인됨</a></li>
                                <li><a href="{{ route('settings.member.index', array_merge(Input::all(), ['status'=> \Member::STATUS_DENIED] )) }}" @if(Input::get('status') === \Member::STATUS_DENIED) active @endif">거부됨</a></li>
                            </ul>
                        </div>
                        {{-- groups --}}
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                {{ $selectedGroup ? $selectedGroup->name : '그룹' }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('settings.member.index', Input::except(['group'])) }}"><span>전체 그룹</span></a>
                                </li>
                                @foreach($groups as $key => $group)
                                    <li>
                                        <a href="{{ route('settings.member.index', array_merge( Input::all(), ['group'=> $group->id] )) }}"><span @if(Input::get('group') === $group->id)class="text-muted"@endif >{{ $group->name }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    {{-- search --}}
                    <div class="col-sm-12 col-md-6 text-right">
                        <form method="GET" class="form-inline" action="{{ route('settings.member.index') }}" accept-charset="UTF-8" role="form" id="_search-form">

                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="__xe_selectedKeyfield">검색대상</span> <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="email">이메일</a></li>
                                    </ul>
                                </div>
                                @foreach(Input::except(['keyfield','keyword']) as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <input type="hidden" class="__xe_keyfield" name="keyfield" value="{{ Input::get('keyfield') }}">
                                <input type="text" name="keyword" class="form-control" value="{{ Input::get('keyword') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">검색</button>
                                    <a class="btn btn-default" href="{{ route('settings.member.index', Input::except('keyfield','keyword')) }}">취소</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form id="__xe_fList" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" title="Check All" class="__xe_check-all"></th>
                            <th scope="col">표시이름</th>
                            <th scope="col">계정</th>
                            <th scope="col">대표이메일</th>
                            <th scope="col">가입일</th>
                            <th scope="col">상태</th>
                            <th scope="col">회원그룹</th>
                            <th scope="col">관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td><input type="checkbox" name="id[]" class="__xe_checkbox" value="{{ $member->getId() }}" @if($member->rating === \Xpressengine\Member\Rating::SUPER) disabled @endif /></td>
                                <td>
                                    <img class="__xe_member" data-id="{{ $member->getId() }}" src="{{ $member->getProfileImage() }}" style="height: 20px;">
                                    <span role="button" class="__xe_member" data-id="{{ $member->getId() }}" data-text="{{ $member->getDisplayName() }}">{{ $member->getDisplayName() }}</span>
                                </td>

                                <td>
                                    @if(isset($member->accounts))
                                        @foreach($member->accounts as $account)
                                            <span class="label label-default">{{ $account->provider }}</span>
                                        @endforeach
                                    @else
                                        <span class="label label-default">default</span>
                                    @endif
                                </td>
                                <td>{{ data_get($member, 'email', '없음') }}</td>
                                <td>{!! $member->createdAt->format('y-m-d') !!}</td>
                                <td>{!! $member->status==='denied'?'거부됨':'승인됨' !!}</td>
                                <td>
                                    @if($member->groups !== null)
                                        {{ implode(', ', array_pluck($member->groups, 'name')) }}
                                    @endif
                                </td>
                                <td><a href="{{ route('settings.member.edit', ['id' => $member->getId()]) }}" class="btn btn-default btn-sm">관리</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>

        </div>

        {{-- page navigation--}}
        <nav class="text-center">{!! $members->render() !!}</nav>


<script type="text/javascript">
    $(function () {

        $('.__xe_selectKeyfield').click(function (event) {
            event.preventDefault();
            var val = $(this).attr('data-value');
            var name = $(this).text();
            $('.__xe_selectedKeyfield').text(name);
            $('.__xe_keyfield').val(val);
        });

        $('.__xe_check-all').change(function () {
            if ($(this).is(':checked')) {
                $('input.__xe_checkbox:not(disabled)').prop('checked', true);
            } else {
                $('input.__xe_checkbox:not(disabled)').prop('checked', false);
            }
        });

        $('.__xe_remove').click(function (e) {
            if (!$('input.__xe_checkbox:checked').is('input')) {
                return false;
            }
            var $f = $('#__xe_fList');
            $f.attr('action', "{{ route('settings.member.destroy') }}");
            $('<input type="hidden" name="_method" value="DELETE">').prependTo($f);
            $f.submit();
        });
    });
</script>

{!! uio('uiobject/xpressengine@chakIt', 'Settings:회원목록') !!}
