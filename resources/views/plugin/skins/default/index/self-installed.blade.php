@section('page_title')
    <h2>{{ xe_trans('xe::pluginList') }}</h2>
@stop

@section('page_description')
    <p class="sub-text">{{ xe_trans('xe::pluginListDescription') }}</p>
@stop

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">

            @include($_skin::view('index.tab'))

            <div class="panel">
                {{-- heading --}}
                <div class="panel-heading" style="padding-top: 17px; padding-bottom: 17px;">

                    <div class="row">

                        <div class="col-md-7 col-sm-12">
                            <form method="GET" action="{{ route('settings.plugins.self') }}" accept-charset="UTF-8" role="form" id="_search-form" class="form-inline">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <a href="{{ route('settings.plugins.self', Input::except('status')) }}" class="btn btn-default @if(Input::get('status') === null) btn-primary @endif">{{ xe_trans('xe::all') }}</a>
                                        <a href="{{ route('settings.plugins.self', array_merge(Input::all(), ['status'=> XePlugin::STATUS_ACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_ACTIVATED) btn-primary @endif">{{ xe_trans('xe::enabled') }}</a>
                                        <a href="{{ route('settings.plugins.self', array_merge(Input::all(), ['status'=> XePlugin::STATUS_DEACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_DEACTIVATED) btn-primary @endif">{{ xe_trans('xe::disabled') }}</a>
                                    </div>
                                    {{--<button class="btn btn-default __xe_btn-show-update">{{ xe_trans('xe::updateList') }}</button>--}}
                                </div>

                                <div class="form-group">
                                    <div class="input-group search-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                {{ Input::get('component') ? $componentTypes[Input::get('component')] : xe_trans('xe::supportingComponents') }}
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route('settings.plugins.self', Input::except(['component'])) }}"><span>{{ xe_trans('xe::all') }} {{ xe_trans('xe::component') }}</span></a>
                                                </li>
                                                @foreach($componentTypes as $type => $typeText)
                                                    <li>
                                                        <a href="{{ route('settings.plugins.self', array_merge( Input::all(), ['component'=> $type] )) }}"><span @if(Input::get('component') === $type)class="text-muted"@endif  >{{ $typeText }}</span></a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="search-input-group">
                                            @foreach(Input::except(['query']) as $name => $value)
                                                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                            @endforeach
                                            <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="{{ xe_trans('xe::enterKeyword') }}" name="query" value="{{ Input::get('query') }}">
                                            <button class="btn-link">
                                                <i class="xi-magnifier"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-5 col-sm-12 text-right">
                            <button type="button" data-toggle="modal" data-target="#installPlugin" class="btn btn-primary">빈 플러그인 생성</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle __xe_manage_plugin" data-toggle="dropdown" aria-expanded="false" disabled="disabled">선택된 플러그인을 ... <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('settings.plugins.delete-page') }}" class="__xe_remove_plugin"><span>삭제</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- plugin list --}}
                <ul class="list-group list-plugin">

                    @foreach($plugins as $plugin)
                        @include($_skin::view('index.item'))
                    @endforeach

                </ul>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function($) {

        var PluginList = (function() {
            var self;

            return {
                init: function() {
                    self = this;

                    self.cache();
                    self.bindEvents();

                    return this;
                },
                cache: function() {
                    self.$manage = $('.__xe_manage_plugin');
                    self.$update = $('.__xe_update_plugin');
                    self.$remove = $('.__xe_remove_plugin');
                    self.$checkboxes = $('.__xe_checkbox');
                },
                bindEvents: function() {
                    self.$checkboxes.on('change', self.checked);
                    self.$remove.on('click', self.remove);
                    self.$update.on('click', self.update);
                },
                checked: function(e) {
                    $checked = $('.__xe_checkbox:checked');
                    if($checked.length) {
                        self.$manage.removeAttr('disabled');
                    } else {
                        self.$manage.attr('disabled', 'disabled');
                    }
                },
                remove: function() {
                    if (!$('input.__xe_checkbox:checked').is('input')) {
                        return false;
                    }

                    var pluginIds = $('input.__xe_checkbox:checked').map(function() {
                        return this.value;
                    }).get().join();

                    var options = {
                        'data' : {
                            'pluginIds': pluginIds
                        }
                    };

                    var url = self.$remove.attr('href');
                    XE.pageModal(url, options);

                    return false;
                },
                update: function() {

                    var url = self.$update.attr('href');
                    XE.pageModal(url);

                    return false;
                }
            }
        })().init();
    });
</script>
