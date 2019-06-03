<h3>현재 최신버전의 XE가 설치되어 있습니다.</h3>
<div class="panel">
    <div class="panel-body">
        <p>{{ xe_trans('xe::msgCoreInstalled', ['version' => __XE_VERSION__]) }}</p>
        @if($operation->isSucceed())
            <hr>
            <p>최근 업데이트: <em>{{ $operation->getCompletedAt() }}</em></p>
        @endif
    </div>
</div>