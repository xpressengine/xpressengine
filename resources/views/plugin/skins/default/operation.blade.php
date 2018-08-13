@php
    $operations = ['install' => xe_trans('xe::install'), 'update' => xe_trans('xe::updates')];
@endphp

    <div class="panel">
        <div class="panel-body">
            @if ($operation['status'] !== 'running' && Session::get('operation') === 'running')
                <strong>{{ xe_trans('xe::loadingForStatus') }}</strong>
            @else
                <strong>{{ xe_trans('xe::recentOperation') }}</strong>

                @if($operation['status'] !== 'running')
                    <div class="pull-right">
                        <form action="{{ route('settings.plugins.operation.delete') }}" method="DELETE" data-submit="xe-ajax" data-callback="deletePluginOperation">
                            <button class="btn-link" type="submit">{{ xe_trans('xe::deleteHistory') }}</button>
                        </form>
                    </div>
                @endif
                <hr>
                <label for="">{{ xe_trans('xe::operation') }}</label>
                    @forelse($operation['targets'] as $name => $package)

                        @if($package['operation'] === 'uninstall')
                            @if(data_get($operation['infos'], $name))
                            <p>{{ data_get($operation['infos'], $name.'.title') }}({{ $package['id'] }}) {{ xe_trans('xe::destroy') }}</p>
                            @else
                            <p>{{ $name }} {{ xe_trans('xe::destroy') }}</p>
                            @endif
                        @else
                            @if(data_get($operation['infos'], $name))
                                <p>{{ data_get($operation['infos'], $name.'.title') }}({{ $package['id'] }}) ver.{{ $package['version'] }} {{ array_get($operations, $package['operation']) }}</p>
                            @else
                                <p>{{ $name }} ver.{{ $package['version'] }} {{ array_get($operations, $package['operation']) }}</p>
                            @endif
                        @endif
                    @empty
                        <p></p>
                    @endforelse

                <label for="">{{ xe_trans('xe::status') }}</label>
                <p>
                    @if($operation['status'] === 'successed')
                        <span class="label label-success">{{ xe_trans('xe::success') }}</span>
                    @elseif($operation['status'] === 'failed')
                        <span class="label label-danger">{{ xe_trans('xe::fail') }}</span>
                    @elseif($operation['status'] === 'expired')
                        <span class="label label-danger">{{ xe_trans('xe::fail') }}({{ xe_trans('xe::timeoutExceeded') }})</span>
                    @else
                        <span class="label label-warning">{{ xe_trans('xe::inProgress') }}</span>
                    @endif
                </p>

                @if($operation['status'] === 'successed')
                    <label for="">{{ xe_trans('xe::changeHistory') }}</label>
                    @foreach($operation['changed'] as $mode => $plugins)
                        @foreach($plugins as $plugin => $version)
                        <p>{{ $plugin }} ver.{{ $version }} {{ $mode }}</p>
                        @endforeach
                    @endforeach
                @elseif($operation['status'] === 'failed')
                    <label for="">{{ xe_trans('xe::failureHistory') }}</label>
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
                    XE.page('".route('settings.plugins.operation')."', '.__xe_operation', {}, function(response){
                        var data = response.data;
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
