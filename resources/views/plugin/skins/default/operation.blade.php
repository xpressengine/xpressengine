    <div class="panel">
        <div class="panel-body">
            @if ($operation['status'] !== 'running' && Session::get('operation') === 'running')
                <strong>진행상태를 불러오고 있습니다.</strong>
            @else
                <strong>최근작업</strong>

                @if($operation['status'] !== 'running')
                    <div class="pull-right">
                        <form action="{{ route('settings.plugins.operation.delete') }}" method="DELETE" data-submit="xe-ajax" data-callback="deletePluginOperation">
                            <button class="btn-link" type="submit">내역 삭제</button>
                        </form>
                    </div>
                @endif
                <hr>
                <label for="">작업</label>
                    @forelse($operation['targets'] as $name => $package)

                        @if($package['operation'] === 'uninstall')
                            @if(data_get($operation['infos'], $name))
                            <p>{{ data_get($operation['infos'], $name.'.title') }}({{ $package['id'] }}) 삭제</p>
                            @else
                            <p>{{ $name }} 삭제</p>
                            @endif
                        @else
                            @if(data_get($operation['infos'], $name))
                                <p>{{ data_get($operation['infos'], $name.'.title') }}({{ $package['id'] }}) ver.{{ $package['version'] }} {{ array_get(['install'=>'설치','update'=>'업데이트'], $package['operation']) }}</p>
                            @else
                                <p>{{ $name }} ver.{{ $package['version'] }} {{ array_get(['install'=>'설치','update'=>'업데이트'], $package['operation']) }}</p>
                            @endif
                        @endif
                    @empty
                        <p></p>
                    @endforelse

                <label for="">상태</label>
                <p>
                    @if($operation['status'] === 'successed')
                        <span class="label label-success">성공</span>
                    @elseif($operation['status'] === 'failed')
                        <span class="label label-danger">실패</span>
                    @elseif($operation['status'] === 'expired')
                        <span class="label label-danger">실패(제한시간 초과)</span>
                    @else
                        <span class="label label-warning">진행중</span>
                    @endif
                </p>

                @if($operation['status'] === 'successed')
                    <label for="">변경 내역</label>
                    @foreach($operation['changed'] as $mode => $plugins)
                        @foreach($plugins as $plugin => $version)
                        <p>{{ $plugin }} ver.{{ $version }} {{ $mode }}</p>
                        @endforeach
                    @endforeach
                @elseif($operation['status'] === 'failed')
                    <label for="">실패 내역</label>
                    @foreach($operation['failed'] as $mode => $plugins)
                        @foreach($plugins as $plugin => $code)
                            <p>{{ $plugin }} {{ $mode.' failed: ' }} {{ array_get([
                                '401' => 'This is paid plugin. If you have already purchased this plugin, check the \'site_token\' field in your setting file(config/production/xe.php).',
                                '403' => 'This is paid plugin. You need to buy it in the Market-place.'
                            ], $code) }}</p>
                        @endforeach
                    @endforeach
                @endif
            @endif
        </div>
    </div>



    @if($operation['status'] === 'running' || Session::get('operation') === 'running')
        {!! app('xe.frontend')->html('plugin.get-operation')->content("
        <script>
            $(function($) {
                var loadOperation = function () {
                    XE.page('".route('settings.plugins.operation')."', '.__xe_operation', {}, function(data){
                        if(data.operation.status != 'running') {
                            //clearInterval(loadOperation);
                            location.reload();
                        } else {
                            loadOperation();
                        }
                    });
                }
                loadOperation();
            });
        </script>
        ")->load() !!}
    @else
        {!! app('xe.frontend')->html('plugin.delete-operation')->content("
        <script>
            window.deletePluginOperation = function (data, textStatus, jqXHR) {
                XE.toast('success', data.message);
                $('.__xe_operation').slideUp();
            };
        </script>
        ")->load() !!}
    @endif
