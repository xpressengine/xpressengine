<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">


            @if($operation && $operation['updateVersion'])

                {{-- 코어 업데이트 작업 내역이 있음 --}}
                <div class="__xe_operation" style="margin-bottom: 10px;">
                    @include('update.operation')
                </div>

                {!! app('xe.frontend')->html('plugin.install.check')->content("
                <script>
                    var checkPluginInstall = function (data) {
                        location.reload();
                    }
                </script>
                ")->load() !!}

                @if($operation['status'] === 'running')
                    {{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
                    {{ app('xe.frontend')->html('core-update.get-operation')->content("
                    <script>
                        $(function($) {
                            var loadOperation = setInterval(function(){
                                XE.page('".route('settings.coreupdate.operation')."', '.__xe_operation', {}, function(data){
                                    if(data.operation.status != 'running') {
                                        clearInterval(loadOperation);
                                        location.reload();
                                    }
                                });
                            }, 3000);
                        });
                    </script>
                    ")->load() }}
                @else
                    {{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load() }}
                    {!! app('xe.frontend')->html('core-update.delete-operation')->content("
                    <script>
                        window.deletePluginOperation = function (data, textStatus, jqXHR) {
                            XE.toast('success', data.message);
                            $('.__xe_operation').slideUp();
                        };
                    </script>
                    ")->load() !!}
                @endif
            @endif

            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ xe_trans('xe::coreUpdate') }}</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>

                <div class="panel-body">
                    @if($installedVersion === __XE_VERSION__)
                        <p>{{ xe_trans('xe::msgCoreInstalled', ['version' => __XE_VERSION__]) }}</p>
                    @else
                        @if($operation && $operation['updateVersion'] && $operation['status'] === 'running')
                            <p>
                                {{ xe_trans('xe::updatingTo', ['version' => $operation['updateVersion']]) }}
                            </p>

                        @else
                            <form action="{{ route('settings.coreupdate.update') }}" method="POST" id="updateForm">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <p>
                                    {{ xe_trans('xe::newCoreDownloaded') }} <br>
                                    {{ xe_trans('xe::alertUpdateCore', ['version' => __XE_VERSION__]) }} {{ xe_trans('xe::confirmUpdate') }}
                                </p>
                                <br>
                                <div class="well">
                                    <p>
                                        {{ xe_trans('xe::currentInstalledVersion') }}: {{ $installedVersion }}
                                    </p>
                                    <p>
                                        {{ xe_trans('xe::downloadedVersion') }}: {{ __XE_VERSION__ }}
                                    </p>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="skip-composer" value="Y"> <code>composer
                                            update</code> {{ xe_trans('xe::doNotRun') }}
                                    </label>
                                    <p class="help-block">- {{ xe_trans('xe::checkIfAlreadyRunComposer') }}</p>
                                </div>
                            </form>
                            @section('submit_button')
                                <div class="panel-footer">
                                    <div class="pull-right">
                                        <button type="button" class="xe-btn xe-btn-primary" onclick="$('#updateForm').submit();return false">{{ xe_trans('xe::updates') }}</button>
                                    </div>
                                </div>
                            @endsection
                        @endif
                    @endif
                </div>
                @yield('submit_button')
            </div>


        </div>
    </div>
</div>

