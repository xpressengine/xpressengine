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

            @if($operation)
                <div class="__xe_operation" style="margin-bottom: 10px;">
                @include($_skin::view('operation'))
                </div>
            @endif

            <div class="panel">
                {{-- heading --}}
                <div class="panel-heading" style="padding-top: 17px; padding-bottom: 17px;">

                    <div class="row">

                        <div class="col-md-7 col-sm-12">
                            <form method="GET" action="{{ route('settings.plugins') }}" accept-charset="UTF-8" role="form" id="_search-form" class="form-inline">
                                    <div class="form-group">
                                        <div class="btn-group">
                                            <a href="{{ route('settings.plugins', Input::except('status')) }}" class="btn btn-default @if(Input::get('status') === null) btn-primary @endif">{{ xe_trans('xe::all') }}</a>
                                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_ACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_ACTIVATED) btn-primary @endif">{{ xe_trans('xe::enabled') }}</a>
                                            <a href="{{ route('settings.plugins', array_merge(Input::all(), ['status'=> XePlugin::STATUS_DEACTIVATED] )) }}" class="btn btn-default @if(Input::get('status') === XePlugin::STATUS_DEACTIVATED) btn-primary @endif">{{ xe_trans('xe::disabled') }}</a>
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
                                                        <a href="{{ route('settings.plugins', Input::except(['component'])) }}"><span>{{ xe_trans('xe::all') }} {{ xe_trans('xe::component') }}</span></a>
                                                    </li>
                                                    @foreach($componentTypes as $type => $typeText)
                                                        <li>
                                                            <a href="{{ route('settings.plugins', array_merge( Input::all(), ['component'=> $type] )) }}"><span @if(Input::get('component') === $type)class="text-muted"@endif  >{{ $typeText }}</span></a>
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
                            <a href="{{ route('settings.plugins.install') }}" class="btn btn-primary">{{ xe_trans('xe::installNewPlugin') }}</a>
                            <a href="{{ route('settings.plugins.manage.update') }}" class="btn btn-default __xe_update_plugin"><span>{{ xe_trans('xe::update_plugin') }}</span></a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle __xe_manage_plugin" data-toggle="dropdown" aria-expanded="false" disabled="disabled">선택된 플러그인을 ... <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('settings.plugins.manage.activate') }}" class="__xe_activate_plugin"><span>켜기</span></a>
                                        <a href="{{ route('settings.plugins.manage.deactivate') }}" class="__xe_deactivate_plugin"><span>끄기</span></a>
                                        <a href="{{ route('settings.plugins.manage.delete') }}" class="__xe_remove_plugin"><span>삭제</span></a>
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


{!! app('xe.frontend')->html('plugin.install.check')->content("
<script>
    var checkPluginInstall = function (data) {
        location.reload();
    }
</script>
")->load() !!}

@if($operation && $operation['status'] === 'running')
    {{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
    {!! app('xe.frontend')->html('plugin.get-operation')->content("
    <script>
        $(function($) {
            var loadOperation = setInterval(function(){
                XE.page('".route('settings.plugins.operation')."', '.__xe_operation', {}, function(data){
                    if(data.operation.status != 'running') {
                        clearInterval(loadOperation);
                        location.reload();
                    }
                });
            }, 3000);
        });
    </script>
    ")->load() !!}
@endif

@if($operation && $operation['status'] !== 'running')
{!! app('xe.frontend')->html('plugin.delete-operation')->content("
<script>
    window.deletePluginOperation = function (data, textStatus, jqXHR) {
        XE.toast('success', data.message);
        $('.__xe_operation').slideUp();
    };
</script>
")->load() !!}
@endif

<script type="text/javascript">
    $(function($) {

        var PluginManager = (function() {

            var self;

            return {
                init: function() {
                    self = this;

                    self.cache();
                    self.bindEvents();
                    self.reset();
                    return this;
                },
                cache: function() {
                    self.$manage = $('.__xe_manage_plugin');
                    self.$update = $('.__xe_update_plugin');
                    self.$remove = $('.__xe_remove_plugin');
                    self.$activate = $('.__xe_activate_plugin');
                    self.$deactivate = $('.__xe_deactivate_plugin');
                    self.$checkboxes = $('.__xe_checkbox');
                },
                bindEvents: function() {
                    self.$checkboxes.on('change', self.check);
                    self.$remove.on('click', self.remove);
                    self.$activate.on('click', self.activate);
                    self.$deactivate.on('click', self.deactivate);
                    self.$update.on('click', self.update);
                },
                reset: function() {
                    $checked = $('.__xe_checkbox:checked');
                    if($checked.length) {
                        self.$manage.removeAttr('disabled');
                    } else {
                        self.$manage.attr('disabled', 'disabled');
                    }
                },
                check: function(e) {
                    self.reset();
                },
                checkedList: function() {
                    return $('input.__xe_checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                },
                remove: function() {

                    var pluginIds = self.checkedList();
                    if(pluginIds.length === 0) {
                        return false;
                    }
                    var options = {
                        'data' : {
                            'pluginId': pluginIds.join()
                        }
                    };
                    var url = self.$remove.attr('href');
                    XE.pageModal(url, options);

                    return false;
                },
                activate: function() {
                    var pluginIds = self.checkedList();
                    if(pluginIds.length === 0) {
                        return false;
                    }
                    var options = {
                        'data' : {
                            'pluginId': pluginIds.join()
                        }
                    };
                    var url = self.$activate.attr('href');
                    XE.pageModal(url, options);

                    return false;
                },
                deactivate: function() {

                    var pluginIds = self.checkedList();
                    if(pluginIds.length === 0) {
                        return false;
                    }
                    var options = {
                        'data' : {
                            'pluginId': pluginIds.join()
                        }
                    };
                    var url = self.$deactivate.attr('href');
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
