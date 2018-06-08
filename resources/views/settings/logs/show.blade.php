    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::details') }}</strong>
    </div>
    <div class="xe-modal-body">
        <dl>
            <div class="panel panel-default">
                <div class="panel-heading">{{ xe_trans('xe::date') }}</div>
                <div class="panel-body"> {{ $log->created_at->format('y.m.d H:i:s') }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">{{ xe_trans('xe::displayName') }}</div>
                <div class="panel-body"> {{ $log->getUser()->getDisplayName() }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">{{ xe_trans('xe::summary') }}</div>
                <div class="panel-body"> {{ $log->summary }} </div>
            </div>
            @if($log->detail !== null)
            <div class="panel panel-default">
                <div class="panel-heading">{{ xe_trans('xe::details') }}</div>
                <div class="panel-body"> {{ $log->detail }} </div>
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">{{ xe_trans('xe::ipAddress') }}</div>
                <div class="panel-body"> {{ $log->ipaddress }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">HTTP Method</div>
                <div class="panel-body"> {{ $log->method }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">URL</div>
                <div class="panel-body"> {{ $log->url }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Parameters</div>
                <div class="panel-body">
                    @if(count($log->parameters))
                        <table class="table table-bordered">
                            @foreach($log->parameters as $key => $value)
                                <tr>
                                    <th>
                                        {{ $key }}
                                    </th>
                                    <td>
                                        @if(is_array($value))
                                            {{ json_encode($value) }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </dl>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::close') }}</button>
    </div>
