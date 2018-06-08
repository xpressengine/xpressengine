    <div class="panel">
        <div class="panel-body">
            <strong>{{ xe_trans('xe::recentOperation') }}</strong>

            @if($operation['status'] !== 'running')
                <div class="pull-right">
                    <form action="{{ route('settings.coreupdate.operation.delete') }}" method="delete" data-submit="xe-ajax" data-callback="deletePluginOperation">
                        <button class="btn-link" type="submit">{{ xe_trans('xe::deleteHistory') }}</button>
                    </form>
                </div>
            @endif
            <hr>
            <label for="">{{ xe_trans('xe::operation') }}</label>
            <p>Update ver.{{ $operation['updateVersion'] }}</p>
            <label for="">{{ xe_trans('xe::status') }}</label>
            <p>
                @if($operation['status'] === 'successed')
                    {{ xe_trans('xe::success') }}
                @elseif($operation['status'] === 'failed')
                    {{ xe_trans('xe::fail') }}
                @elseif($operation['status'] === 'expired')
                    {{ xe_trans('xe::fail') }}({{ xe_trans('xe::timeoutExceeded') }})
                @else
                    {{ xe_trans('xe::inProgress') }}
                @endif

                @if($operation['log'])
                <button type="button" class="xe-btn btn-link" data-toggle="collapse" aria-expanded="false" data-target=".operation-log">{{ xe_trans('xe::showDetails') }}</button>
                @endif
            </p>

            @if($operation['log'])
            <div class="collapse operation-log @if($operation['status'] == 'running') in @endif ">
                <div class="well">
                    {!! nl2br(array_get($operation,'log')) !!}
                </div>
            </div>
            @endif
        </div>
    </div>

