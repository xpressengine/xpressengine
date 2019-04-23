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

                @if(in_array($operation['status'], ['running', 'ready']))
                    {{ app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load() }}
                    {{ app('xe.frontend')->html('core-update.get-operation')->content("
                    <script>
                        $(function($) {
                            var loadOperation = setInterval(function(){
                                XE.page('".route('settings.coreupdate.operation')."', '.__xe_operation', {}, function(response){
                                    var data = response.data;
                                    if(data.operation.status !== 'running' && data.operation.status !== 'ready') {
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
                    @if(version_compare($latest, __XE_VERSION__) === -1 || version_compare(__XE_VERSION__, $installedVersion) === -1)
                        <p>코어 버전정보가 정상적이지 않습니다. 임의로 버전정보가 변경된 경우 정상적으로 동작하지 않을 수 있습니다.</p>
                    @elseif($latest === __XE_VERSION__ && $installedVersion === __XE_VERSION__)
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
                                @if(version_compare(__XE_VERSION__, $latest) === 0)
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
                                            <input type="checkbox" name="skip-composer" value="Y">
                                            <code>composer update</code> {{ xe_trans('xe::doNotRun') }}
                                        </label>
                                        <p class="help-block">- {{ xe_trans('xe::checkIfAlreadyRunComposer') }}</p>
                                    </div>

                                @else

                                    <p>
                                        새로운 버전의 XE가 있습니다. <br>
                                        {{ xe_trans('xe::alertUpdateCore', ['version' => $latest]) }} {{ xe_trans('xe::confirmUpdate') }}
                                    </p>
                                    <br>
                                    <div class="well">
                                        <p>
                                            {{ xe_trans('xe::currentInstalledVersion') }}: {{ $installedVersion }}
                                        </p>
                                        <p>
                                            업데이트 버전:
                                            <select name="version">
                                                @foreach(array_reverse($updatables) as $updatable)
                                                    <option value="{{ $updatable }}">{{ $updatable }}</option>
                                                @endforeach
                                            </select>
                                            @if($downloaded = version_compare(__XE_VERSION__, $installedVersion) === 1)
                                                <span>({{ xe_trans('xe::downloadedVersion') }}: {{ __XE_VERSION__ }})</span>
                                            @endif
                                        </p>
                                    </div>

                                    @if($downloaded)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="skip-download" value="Y" onclick="$('#__chkbox-composer').slideDown();">
                                            다운로드 {{ xe_trans('xe::doNotRun') }}
                                        </label>
                                        <p class="help-block">- 이미 다운로드된 버전으로 업데이트를 마무리하는 경우 체크하십시오.</p>
                                    </div>
                                        <div class="checkbox" id="__chkbox-composer" style="display: none;">
                                            <label>
                                                <input type="checkbox" name="skip-composer" value="Y">
                                                <code>composer update</code> {{ xe_trans('xe::doNotRun') }}
                                            </label>
                                            <p class="help-block">- {{ xe_trans('xe::checkIfAlreadyRunComposer') }}</p>
                                        </div>
                                        <script>
                                            jQuery(function($) {
                                              $('input[name="skip-download"]').change(function () {
                                                if ($(this).is(':checked')) {
                                                  $('#__chkbox-composer').slideDown();
                                                  $('select[name="version"]').prop('disabled', true);
                                                } else {
                                                  $('#__chkbox-composer').slideUp();
                                                  $('select[name="version"]').prop('disabled', false);
                                                }
                                              }).triggerHandler('change');
                                            });
                                        </script>
                                    @endif
                                @endif

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

