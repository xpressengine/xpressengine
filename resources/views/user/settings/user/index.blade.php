<?php
use Xpressengine\User\Models\User;
?>
{{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
{{ app('xe.frontend')->js('assets/vendor/jqueryui/jquery-ui.min.js')->load() }}
{{ app('xe.frontend')->css('assets/vendor/jqueryui/jquery-ui.min.css')->load() }}

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::userList')}}</h3>
                        ( {{xe_trans('xe::searchUserCount')}} : {{  $users->total() }} / {{xe_trans('xe::allUserCount')}} : {{ $allUserCount }} )
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('settings.user.create') }}" class="btn btn-primary"><i class="xi-plus"></i><span>{{xe_trans('xe::addNewUser')}}</span></a>
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
                                <li @if(!Request::get('status')) class="active" @endif><a href="{{ route('settings.user.index', Request::except('status') ) }}">{{xe_trans('xe::all')}}</a></li>
                                <li @if(Request::get('status') === User::STATUS_ACTIVATED) class="active" @endif><a href="{{ route('settings.user.index', array_merge(Request::all(), ['status'=> User::STATUS_ACTIVATED] )) }}">{{xe_trans('xe::permitted')}}</a></li>
                                <li @if(Request::get('status') === User::STATUS_DENIED) class="active" @endif><a href="{{ route('settings.user.index', array_merge(Request::all(), ['status'=> User::STATUS_DENIED] )) }}">{{xe_trans('xe::rejected')}}</a></li>
                                <li @if(Request::get('status') === User::STATUS_PENDING_ADMIN) class="active" @endif><a href="{{ route('settings.user.index', array_merge(Request::all(), ['status'=> User::STATUS_PENDING_ADMIN] )) }}">{{xe_trans('xe::pending_admin')}}</a></li>
                                <li @if(Request::get('status') === User::STATUS_PENDING_EMAIL) class="active" @endif><a href="{{ route('settings.user.index', array_merge(Request::all(), ['status'=> User::STATUS_PENDING_EMAIL] )) }}">{{xe_trans('xe::pending_email')}}</a></li>
                                <li class="divider"></li>
                                <li><strong>{{xe_trans('xe::group')}}</strong></li>
                                <li @if(!Request::get('group'))class="active"@endif><a href="{{ route('settings.user.index', Request::except(['group'])) }}"><span>{{xe_trans('xe::allGroup')}}</span></a></li>
                                @foreach($groups as $key => $group)
                                <li @if(Request::get('group') === $group->id)class="active"@endif><a href="{{ route('settings.user.index', array_merge( Request::all(), ['group'=> $group->id] )) }}">{{ $group->name }}</a></li>
                                @endforeach

                                <li><strong>{{xe_trans('xe::userRating')}}</strong></li>
                                <li @if(!Request::get('rating'))class="active"@endif><a href="{{ route('settings.user.index', Request::except(['rating'])) }}"><span>{{xe_trans('xe::allRating')}}</span></a></li>
                                @foreach($ratings as $rating)
                                    <li @if(Request::get('rating') === $rating['value'])class="active"@endif><a href="{{route('settings.user.index', array_merge(Request::all(), ['rating' => $rating['value']]))}}">{{$rating['text']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default __xe_remove">{{xe_trans('xe::deleteSelected')}}</button>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="input-group search-group">
                            <form method="GET" action="{{ route('settings.user.index') }}" accept-charset="UTF-8" role="form" id="_search-form" class="form-inline">
                                <div class="form-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="__xe_selectedKeyfield">
                                            @if (Request::get('keyfield') === 'display_name')
                                                {{xe_trans($config->get('display_name_caption'))}}
                                            @elseif (Request::get('keyfield') === 'login_id')
                                                {{xe_trans('xe::id')}}
                                            @elseif (Request::get('keyfield') === 'email')
                                                {{xe_trans('xe::email')}}
                                            @else
                                                {{xe_trans('xe::select')}}
                                            @endif
                                            </span>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" class="__xe_selectKeyfield" data-value="display_name">{{xe_trans($config->get('display_name_caption'))}}</a></li>
                                            <li><a href="#" class="__xe_selectKeyfield" data-value="login_id">{{xe_trans('xe::id')}}</a></li>
                                            <li><a href="#" class="__xe_selectKeyfield" data-value="email">{{xe_trans('xe::email')}}</a></li>
                                        </ul>
                                    </div>
                                    <div class="search-input-group">
                                        <input type="text" name="keyword" class="form-control" aria-label="Text input with dropdown button" placeholder="{{xe_trans('xe::enterKeyword')}}" value="{{ Request::get('keyword') }}">
                                        <button type="submit" class="btn-link">
                                            <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group input-group-btn">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{xe_trans('xe::signUpDate')}}</span>
                                        <input type="text" id="startDatePicker" name="startDate" class="form-control" value="{{ Request::get('startDate') }}">
                                        <input type="text" id="endDatePicker" name="endDate" class="form-control" value="{{ Request::get('endDate') }}">
                                    </div>
                                </div>
                                @foreach(Request::except(['keyfield','keyword','page','startDate', 'endDate']) as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <input type="hidden" class="__xe_keyfield" name="keyfield" value="{{ Request::get('keyfield') }}">
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" class="__xe_check-all"></th>
                            <th scope="col">
                                @if ($config->get('use_display_name') === true)
                                    {{xe_trans($config->get('display_name_caption'))}}
                                @else
                                    {{xe_trans('xe::id')}}
                                @endif
                            </th>
                            <th scope="col" class="text-center">{{xe_trans('xe::account')}}</th>
                            <th scope="col">{{xe_trans('xe::email')}}</th>
                            <th scope="col">{{xe_trans('xe::signUpDate')}}</th>
                            <th scope="col">{{xe_trans('xe::latestLogin')}}</th>
                            <th scope="col">{{xe_trans('xe::userGroup')}}</th>
                            <th scope="col">{{xe_trans('xe::status')}}</th>
                            <th scope="col">{{xe_trans('xe::management')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><input name="userId[]" class="__xe_checkbox" type="checkbox" value="{{ $user->getId() }}" @if($user->rating === \Xpressengine\User\Rating::SUPER) disabled @endif></td>
                            <td>
                                <img data-toggle="xe-page-toggle-menu"
                                        data-url="{{ route('toggleMenuPage') }}"
                                        data-data='{!! json_encode(['id'=>$user->getId(), 'type'=>'user']) !!}' src="{{ $user->getProfileImage() }}" width="30" height="30" alt="{{xe_trans('xe::profileImage')}}" class="user-profile">
                                <span>
                                    <a href="#"
                                       data-toggle="xe-page-toggle-menu"
                                       data-url="{{ route('toggleMenuPage') }}"
                                       data-data='{!! json_encode(['id'=>$user->getId(), 'type'=>'user']) !!}' data-text="{{ $user->getDisplayName() }}">{{ $user->getDisplayName() }}</a>
                               </span>
                            </td>
                            <td class="text-center">
                                @if(count($user->accounts))
                                    @foreach($user->accounts as $account)
                                        <span data-toggle="tooltip" class="badge black" title="{{ $account->provider }}">{{ $account->provider }}</span>
                                    @endforeach
                                @else
                                    <span data-toggle="tooltip" class="badge black" title="기본">xe</span>
                                @endif
                            </td>
                            <td>{{ data_get($user, 'email', xe_trans('xe::empty')) }}</td>
                            <td>{!! $user->created_at->format('y-m-d') !!}</td>
                            <td>
                                @if($user->login_at !== null)
                                {!! $user->login_at->format('y-m-d') !!}
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
                                @if ($user->status === User::STATUS_ACTIVATED)
                                    <label class="label label-green">{{xe_trans('xe::permitted')}}</label>
                                @elseif ($user->status === User::STATUS_PENDING_ADMIN || $user->status === User::STATUS_PENDING_EMAIL)
                                    <label class="label label-blue">{{ xe_trans('xe::pending') }}</label>
                                @else
                                    <label class="label label-danger">{{xe_trans('xe::rejected')}}</label>
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
    $(function () {
        $("#startDatePicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: 0,
        });

        $("#endDatePicker").datepicker({
            dateFormat: "yy-mm-dd",
        });

        $("#startDatePicker").change(function () {
            setEndDatePickerSetDate($(this).datepicker('getDate'));
            setEndDatePickerMinDate($(this).datepicker('getDate'));

            $(this).closest('form').submit();
        });

        $("#endDatePicker").change(function () {
            $(this).closest('form').submit();
        });

        initDatePicker();
    });

    function initDatePicker() {
        var startDate = $("#startDatePicker").val();

        if (startDate != '') {
            setEndDatePickerMinDate($("#startDatePicker").datepicker('getDate'));
        }
    }

    function setEndDatePickerSetDate(newDate) {
        newDate.setMonth(newDate.getMonth() + 1);
        $("#endDatePicker").datepicker("setDate", newDate);
    }

    function setEndDatePickerMinDate(minDate) {
        minDate.setDate(minDate.getDate());
        $("#endDatePicker").datepicker('option',{minDate:minDate});
    }

    var UserList = (function() {
        var self;

        return {
            init: function() {
                self = this;

                $(function () {
                    self.cache();
                    self.bindEvents();
                });

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
            }
        }
    })().init();
</script>

