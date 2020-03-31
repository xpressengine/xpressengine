{{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ xe_trans('xe::accessLog') }}</h3>
                    </div>
                </div>

                <div class="panel-heading">

                    <div class="pull-left">
                        <div class="btn-group btn-fillter" role="group">
                            @section('type-select')
                                <ul class="dropdown-menu" role="menu">
                                    <li @if(request()->get('type') === null) class="active" @endif><a href="{{ route('settings.setting.log.index') }}">{{ xe_trans('xe::all') }}</a></li>
                                    @foreach($loggers as $logger)
                                        <li @if(request()->get('type') === $logger::ID) class="active" @endif><a href="{{ route('settings.setting.log.index', array_merge(request()->all(), ['type'=> $logger::ID] )) }}">{{ $logger::TITLE }}</a></li>
                                        @if(request()->get('type') === $logger::ID) {{-- */ $selectedLogger = $logger/* --}} @endif
                                    @endforeach
                                </ul>
                            @show
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{ isset($selectedLogger) ? $selectedLogger::TITLE : xe_trans('xe::types') }} <span class="caret"></span>
                            </button>
                            @yield('type-select')
                        </div>

                        <div class="btn-group btn-fillter" role="group">
                            @section('admin-select')
                                <ul class="dropdown-menu" role="menu">
                                    <li @if(request()->get('user_id') === null) class="active" @endif><a href="{{ route('settings.setting.log.index') }}">{{ xe_trans('xe::all') }}</a></li>
                                    @foreach($admins as $admin)
                                        <li @if(request()->get('user_id') === $admin->getId()) class="active" @endif><a href="{{ route('settings.setting.log.index', array_merge(request()->all(), ['user_id'=> $admin->getId()] )) }}">{{ $admin->getDisplayName() }}</a></li>
                                        @if(request()->get('user_id') === $admin->getId()) {{-- */ $selectedAdmin = $admin /* --}} @endif
                                    @endforeach
                                </ul>
                            @show
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{ isset($selectedAdmin) ? $selectedAdmin->getDisplayName() : xe_trans('xe::userRatingManager') }} <span class="caret"></span>
                            </button>
                            @yield('admin-select')
                        </div>

                        <div class="btn-group" role="group">
                            <form method="GET" action="{{ route('settings.setting.log.save') }}" accept-charset="UTF-8" role="form" id="_save-form">
                                @foreach(request()->all() as $name => $value)
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endforeach
                                <button type="submit" class="btn btn-default" >{{ xe_trans('xe::download') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="pull-right">
                        <div class="input-group search-group">
                            <form method="GET" action="{{ route('settings.setting.log.index') }}" accept-charset="UTF-8" role="form" id="_search-form">

                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="xi-calendar-check"></i></button>
                                </div>

                                <div class="search-input-group">
                                    <input type="text" name="startDate" class="form-control" placeholder="{{xe_trans('xe::enterStartDate')}}" value={{ request()->get('startDate') }} >
                                    <input type="text" name="endDate" class="form-control" placeholder="{{xe_trans('xe::enterEndDate')}}" value={{ request()->get('endDate') }} >
                                </div>

                                <p></p>

                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="__xe_selectedKeyfield">
                                        @if(request()->get('keyfield')==='url')
                                            URL
                                        @elseif(request()->get('keyfield')==='summary')
                                            {{ xe_trans('xe::summary') }}
                                        @elseif(request()->get('keyfield')==='ipaddress')
                                            {{ xe_trans('xe::ipAddress') }}
                                        @else
                                            {{ xe_trans('xe::select') }}
                                        @endif
                                        </span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="url">URL</a></li>
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="summary">{{ xe_trans('xe::summary') }}</a></li>
                                        <li><a href="#" class="__xe_selectKeyfield" data-value="ipaddress">{{ xe_trans('xe::ipAddress') }}</a></li>
                                    </ul>
                                </div>
                                <div class="search-input-group">
                                    <input type="text" name="keyword" class="form-control" aria-label="Text input with dropdown button" placeholder="{{xe_trans('xe::enterKeyword')}}" value="{{ request()->get('keyword') }}">
                                    <button type="submit" class="btn-link">
                                        <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                    </button>
                                </div>
                                @foreach(request()->except(['keyfield','keyword','page', 'startDate', 'endDate']) as $name => $value)
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
                            <th scope="col">{{ xe_trans('xe::date') }}</th>
                            <th scope="col">{{ xe_trans('xe::types') }}</th>
                            <th scope="col">{{ xe_trans('xe::userRatingManager') }}</th>
                            <th scope="col">{{ xe_trans('xe::summary') }}</th>
                            <th scope="col">{{ xe_trans('xe::target') }} ID</th>
                            <th scope="col">{{ xe_trans('xe::ipAddress') }}</th>
                            <th scope="col">{{ xe_trans('xe::showDetails') }}</th>
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
                            <td>
                                @if ($log->getUser() instanceOf \Xpressengine\User\Models\UnknownUser)
                                    {{ $log->getUser()->getDisplayName() }}
                                @else
                                    <a href="#"
                                       data-toggle="xe-page-toggle-menu"
                                       data-url="{{ route('toggleMenuPage') }}"
                                       data-data='{!! json_encode(['id'=>$log->getUser()->getId(), 'type'=>'user']) !!}'>
                                        {{ sprintf('%s(%s)', $log->getUser()->getDisplayName(), $log->getUser()->email) }}
                                    </a>
                                @endif
                                
                            </td>
                            <td>{{ $log->summary }}</td>
                            <td>{{ $log->target_id }}</td>
                            <td>{{ $log->ipaddress }}</td>
                            <td><a class="xe-btn xe-btn-link" href="{{ route('settings.setting.log.show', ['id'=>$log->id]) }}" data-toggle="xe-page-modal">{{ xe_trans('xe::view') }}</a></td>
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
