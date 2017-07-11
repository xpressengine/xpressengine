    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">관리자 로그 상세 보기</strong>
    </div>
    <div class="xe-modal-body">
        <dl>
            <div class="panel panel-default">
                <div class="panel-heading">date</div>
                <div class="panel-body"> {{ $log->createdAt->format('y.m.d H:i:s') }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">summary</div>
                <div class="panel-body"> {{ $log->summary }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">detail</div>
                <div class="panel-body"> {{ $log->detail }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">method</div>
                <div class="panel-body"> {{ $log->method }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">url</div>
                <div class="panel-body"> {{ $log->url }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">user</div>
                <div class="panel-body"> {{ $log->user->getDisplayName() }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">parameters</div>
                <div class="panel-body">
                    @if(count($log->parameters))
                        <table class="table table-bordered">
                            @foreach($log->parameters as $key => $value)
                                <tr>
                                    <th>
                                        {{ $key }}
                                    </th>
                                    <td>
                                        {{ $value }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">ipaddress</div>
                <div class="panel-body"> {{ $log->ipaddress }} </div>
            </div>
        </dl>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">닫기</button>
    </div>
