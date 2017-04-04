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
                        <h3 class="panel-title">XE3 코어 업데이트</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>

                <div class="panel-body">
                    @if($installedVersion === __XE_VERSION__)
                        <p>현재 XE3 {{ __XE_VERSION__ }} 버전이 정상적으로 설치되어 있습니다.</p>
                    @else
                        @if($operation && $operation['updateVersion'] && $operation['status'] === 'running')
                            <p>
                                {{ $operation['updateVersion'] }} 으로 업데이트 중입니다.
                            </p>

                        @else
                            <form action="{{ route('settings.coreupdate.update') }}" method="POST" id="updateForm">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <p>
                                    새로운 버전의 XE가 다운로드 되었습니다. <br>
                                    XE를 {{ __XE_VERSION__ }} 버전으로 업데이트합니다. 최대 수분이 소요될 수 있습니다. 업데이트 하시겠습니까?
                                </p>
                                <br>
                                <div class="well">
                                    <p>
                                        현재 설치된 버전: {{ $installedVersion }}
                                    </p>
                                    <p>
                                        새로 다운로드된 버전: {{ __XE_VERSION__ }}
                                    </p>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="skip-composer" value="Y"> <code>composer
                                            update</code> 실행 안 함
                                    </label>
                                    <p class="help-block">- 이미 직접 composer update를 실행한 경우 체크하십시오.</p>
                                </div>
                            </form>
                            @section('submit_button')
                                <div class="panel-footer">
                                    <div class="pull-right">
                                        <button type="button" class="xe-btn xe-btn-primary" onclick="$('#updateForm').submit();return false">{{ xe_trans('xe::update_plugin') }}</button>
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

