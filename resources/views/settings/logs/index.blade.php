{{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">관리자 접속 로그</h3>
                    </div>
                </div>

                <div class="panel-heading">

                    <div class="pull-left">
                        <div class="btn-group btn-fillter" role="group">
                            @section('type-select')
                            <ul class="dropdown-menu" role="menu">
                                <li @if(request()->get('type') === null) class="active" @endif><a href="{{ route('settings.setting.log.index') }}">모든 타입</a></li>
                                @foreach($loggers as $logger)
                                    <li @if(request()->get('type') === $logger::ID) class="active" @endif><a href="{{ route('settings.setting.log.index', array_merge(request()->all(), ['type'=> $logger::ID] )) }}">{{ $logger::TITLE }}</a></li>
                                    @if(request()->get('type') === $logger::ID) {{-- */ $selectedLogger = $logger/* --}} @endif
                                @endforeach
                            </ul>
                            @show
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{ isset($selectedLogger) ? $selectedLogger::TITLE : '타입' }} <span class="caret"></span>
                            </button>
                            @yield('type-select')
                        </div>
                        <div class="btn-group btn-fillter" role="group">
                            @section('admin-select')
                                <ul class="dropdown-menu" role="menu">
                                    <li @if(request()->get('user_id') === null) class="active" @endif><a href="{{ route('settings.setting.log.index') }}">모든 관리자</a></li>
                                    @foreach($admins as $admin)
                                        <li @if(request()->get('user_id') === $admin->getId()) class="active" @endif><a href="{{ route('settings.setting.log.index', array_merge(request()->all(), ['user_id'=> $admin->getId()] )) }}">{{ $admin->getDisplayName() }}</a></li>
                                        @if(request()->get('user_id') === $admin->getId()) {{-- */ $selectedAdmin = $admin /* --}} @endif
                                    @endforeach
                                </ul>
                            @show
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{ isset($selectedAdmin) ? $selectedAdmin->getDisplayName() : '관리자' }} <span class="caret"></span>
                            </button>
                            @yield('admin-select')
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="input-group search-group">
                            <form method="GET" action="{{ route('settings.setting.log.index') }}" accept-charset="UTF-8" role="form" id="_search-form">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="__xe_selectedKeyfield">
                                        @if(request()->get('keyfield')==='url')
                                            URL
                                        @elseif(request()->get('keyfield')==='summary')
                                            요약
                                        @elseif(request()->get('keyfield')==='ipaddress')
                                            IP주소
                                        @else
                                            선택
                                        @endif
                                        </span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="url">URL</a></li>
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="summary">요약</a></li>
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="ipaddress">IP주소</a></li>
                                    </ul>
                                </div>
                                <div class="search-input-group">
                                    <input type="text" name="keyword" class="form-control" aria-label="Text input with dropdown button" placeholder="{{xe_trans('xe::enterKeyword')}}" value="{{ request()->get('keyword') }}">
                                    <button type="submit" class="btn-link">
                                        <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                    </button>
                                </div>
                                @foreach(request()->except(['keyfield','keyword','page']) as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <input type="hidden" class="__xe_keyfield" name="keyfield" value="{{ request()->get('keyfield') }}">
                            </form>
                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">일시</th>
                            <th scope="col">타입</th>
                            <th scope="col">관리자</th>
                            <th scope="col">요약</th>
                            <th scope="col">자세히</th>
                            <th scope="col">IP주소</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('y-m-d H:i:s') }}</td>
                            <td>
                                @if($logger = array_get($loggers, $log->type))
                                {{  $logger::TITLE }}
                                @else
                                {{ $log->type }}
                                @endif
                            </td>
                            <td><a href="#"
                                   data-toggle="xe-page-toggle-menu"
                                   data-url="{{ route('toggleMenuPage') }}"
                                   data-data='{!! json_encode(['id'=>$log->user->getId(), 'type'=>'user']) !!}'
                                   {{--data-user-id="{{ $log->user->getId() }}" --}} >{{ $log->user->getDisplayName() }}</a></td>
                            <td>{{ $log->summary }}</td>
                            <td><a class="xe-btn xe-btn-link" href="{{ route('settings.setting.log.show', ['id'=>$log->id]) }}" data-toggle="xe-page-modal">보기</a></td>
                            <td>{{ $log->ipaddress }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pagination = $logs->render())
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

    var LogList = (function() {
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
            remove: function() {
            }
        }
    })().init();
</script>
