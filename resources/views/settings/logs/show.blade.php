    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">관리자 로그 상세 보기</strong>
    </div>
    <div class="xe-modal-body">
        <dl>
            <dt>date</dt>
            <dl> {{ $log->createdAt->format('y.m.d H:i:s') }} </dl>
            <dt>summary</dt>
            <dl> {{ $log->summary }} </dl>
            <dt>detail</dt>
            <dl> {{ $log->detail }} </dl>
            <dt>method</dt>
            <dl> {{ $log->method }} </dl>
            <dt>url</dt>
            <dl> {{ $log->url }} </dl>
            <dt>user</dt>
            <dl> {{ $log->user->getDisplayName() }} </dl>
            <dt>parameters</dt>
            <dl> {{ json_encode($log->parameters) }} </dl>
            <dt>ipaddress</dt>
            <dl> {{ $log->ipaddress }} </dl>
        </dl>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">닫기</button>
    </div>
