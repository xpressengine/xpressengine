    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">관리자 로그 상세 보기</strong>
    </div>
    <div class="xe-modal-body">
        <dl>
            <div class="panel panel-default">
                <div class="panel-heading">요청일시</div>
                <div class="panel-body"> {{ $log->created_at->format('y.m.d H:i:s') }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">관리회원</div>
                <div class="panel-body"> {{ $log->user->getDisplayName() }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">요약</div>
                <div class="panel-body"> {{ $log->summary }} </div>
            </div>
            @if($log->detail !== null)
            <div class="panel panel-default">
                <div class="panel-heading">상세정보</div>
                <div class="panel-body"> {{ $log->detail }} </div>
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">HTTP 메소드</div>
                <div class="panel-body"> {{ $log->method }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">URL</div>
                <div class="panel-body"> {{ $log->url }} </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">파라미터</div>
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
            <div class="panel panel-default">
                <div class="panel-heading">IP주소</div>
                <div class="panel-body"> {{ $log->ipaddress }} </div>
            </div>
        </dl>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">닫기</button>
    </div>
