    <div class="panel">
        <div class="panel-body">
            <strong>최근작업</strong>

            @if($operation['status'] !== 'running')
                <div class="pull-right">
                    <form action="{{ route('settings.coreupdate.operation.delete') }}" method="delete" data-submit="xe-ajax" data-callback="deletePluginOperation">
                        <button class="btn-link" type="submit">내역 삭제</button>
                    </form>
                </div>
            @endif
            <hr>
            <label for="">작업</label>
            <p>{{ $operation['updateVersion'] }} 으로 업데이트</p>
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
        </div>
    </div>

