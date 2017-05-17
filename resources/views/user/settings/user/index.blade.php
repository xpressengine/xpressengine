{{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::memberList')}}</h3>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('settings.user.create') }}" class="btn btn-primary"><i class="xi-plus"></i><span>{{xe_trans('xe::addNewMember')}}</span></a>
                    </div>
                </div>

                <div class="panel-heading">

                    <div class="pull-left">
                        <div class="btn-group btn-fillter" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><strong>{{xe_trans('xe::approve')}}/{{xe_trans('xe::deny')}}</strong></li>
                                <li @if(!Input::get('status')) class="active" @endif><a href="{{ route('settings.user.index', Input::except('status') ) }}">{{xe_trans('xe::all')}}</a></li>
                                <li @if(Input::get('status') === \XeUser::STATUS_ACTIVATED) class="active" @endif><a href="{{ route('settings.user.index', array_merge(Input::all(), ['status'=> \XeUser::STATUS_ACTIVATED] )) }}">{{xe_trans('xe::permitted')}}</a></li>
                                <li @if(Input::get('status') === \XeUser::STATUS_DENIED) class="active" @endif><a href="{{ route('settings.user.index', array_merge(Input::all(), ['status'=> \XeUser::STATUS_DENIED] )) }}">{{xe_trans('xe::rejected')}}</a></li>
                                <li class="divider"></li>
                                <li><strong>{{xe_trans('xe::group')}}</strong></li>
                                <li @if(!Input::get('group'))class="active"@endif><a href="{{ route('settings.user.index', Input::except(['group'])) }}"><span>{{xe_trans('xe::allGroup')}}</span></a></li>
                                @foreach($groups as $key => $group)
                                <li @if(Input::get('group') === $group->id)class="active"@endif><a href="{{ route('settings.user.index', array_merge( Input::all(), ['group'=> $group->id] )) }}">{{ $group->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default __xe_remove">{{xe_trans('xe::deleteSelected')}}</button>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="input-group search-group">
                            <form method="GET" action="{{ route('settings.user.index') }}" accept-charset="UTF-8" role="form" id="_search-form">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="__xe_selectedKeyfield">
                                        @if(Input::get('keyfield')==='displayName')
                                            {{xe_trans('xe::name')}}
                                        @elseif(Input::get('keyfield')==='email')
                                            {{xe_trans('xe::email')}}
                                        @else
                                            {{xe_trans('xe::select')}}
                                        @endif
                                        </span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="displayName">{{xe_trans('xe::name')}}</a></li>
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="email">{{xe_trans('xe::email')}}</a></li>
                                    </ul>
                                </div>
                                <div class="search-input-group">
                                    <input type="text" name="keyword" class="form-control" aria-label="Text input with dropdown button" placeholder="{{xe_trans('xe::enterKeyword')}}" value="{{ Input::get('keyword') }}">
                                    <button type="submit" class="btn-link">
                                        <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                    </button>
                                </div>
                                @foreach(Input::except(['keyfield','keyword','page']) as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <input type="hidden" class="__xe_keyfield" name="keyfield" value="{{ Input::get('keyfield') }}">
                            </form>
                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" class="__xe_check-all"></th>
                            <th scope="col">{{xe_trans('xe::name')}}</th>
                            <th scope="col">{{xe_trans('xe::account')}}</th>
                            <th scope="col">{{xe_trans('xe::email')}}</th>
                            <th scope="col">{{xe_trans('xe::signUpDate')}}</th>
                            <th scope="col">{{xe_trans('xe::latestLogin')}}</th>
                            <th scope="col">{{xe_trans('xe::memberGroup')}}</th>
                            <th scope="col">{{xe_trans('xe::status')}}</th>
                            <th scope="col">{{xe_trans('xe::management')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><input name="userId[]" class="__xe_checkbox" type="checkbox" value="{{ $user->getId() }}" @if($user->rating === \Xpressengine\User\Rating::SUPER) disabled @endif></td>
                            <td>
                                <img data-toggle="xeUserMenu" data-user-id="{{ $user->getId() }}" src="{{ $user->getProfileImage() }}" width="30" height="30" alt="{{xe_trans('xe::profileImage')}}" class="member-profile">
                                <a href="#" data-toggle="xeUserMenu" data-user-id="{{ $user->getId() }}" data-text="{{ $user->getDisplayName() }}">{{ $user->getDisplayName() }}</a></i>
                            </td>
                            <td>
                                @if(count($user->accounts))
                                    @foreach($user->accounts as $account)
                                        <span data-toggle="tooltip" class="badge grey {{ $account->provider }}" title="{{ $account->provider }}"><i class="xi-{{ $account->provider }}"></i></span>
                                    @endforeach
                                @else
                                    <span data-toggle="tooltip" class="badge black" title="기본">xe</span>
                                @endif
                            </td>
                            <td>{{ data_get($user, 'email', xe_trans('xe::empty')) }}</td>
                            <td>{!! $user->createdAt->format('y-m-d') !!}</td>
                            <td>
                                @if($user->loginAt !== null)
                                {!! $user->loginAt->format('y-m-d') !!}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($user->groups !== null)
                                    {{ implode(', ', array_pluck($user->groups, 'name')) }}
                                @endif
                            </td>
                            <td>
                                @if($user->status===\XeUser::STATUS_DENIED)
                                <label class="label label-danger">{{xe_trans('xe::rejected')}}</label>
                                @else
                                <label class="label label-green">{{xe_trans('xe::permitted')}}</label>
                                @endif
                            </td>
                            <td><a href="{{ route('settings.user.edit', ['id' => $user->getId()]) }}" class="btn btn-default">{{xe_trans('xe::management')}}</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
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

                var userIds = $('input.__xe_checkbox:checked').map(function() {
                    return this.value;
                }).get().join();

                var options = {
                    'data' : {
                        'userIds': userIds
                    }
                };

                XE.pageModal('{{ route('settings.user.delete') }}', options);

                console.log(userIds);
            }
        }
    })().init();
</script>

