    <div class="panel">
        <div class="panel-body">
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
                @foreach($operation['targets'] as $name => $package)

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
                @endforeach

            <label for="">상태</label>
            <p>
                @if($operation['status'] === 'successed')
                    성공
                @elseif($operation['status'] === 'failed')
                    실패
                @elseif($operation['status'] === 'expired')
                    실패(제한시간 초과)
                @else
                    진행중
                @endif

                @if($operation['log'])
                <button type="button" class="xe-btn btn-link" data-toggle="collapse" aria-expanded="false" data-target=".operation-log">콘솔보기</button>
                @endif
            </p>

            @if($operation['log'])
            <div class="collapse operation-log @if($operation['status'] == 'running') in @endif ">
                <div class="well">
                    {!! nl2br(array_get($operation,'log')) !!}
                </div>
            </div>
            @endif

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
        </div>
    </div>

