<h3>{{ xe_trans('xe::latestVersionOfCoreInstalled') }}</h3>
<div class="panel">
    <div class="panel-body">
        <p>{{ xe_trans('xe::msgCoreInstalled', ['version' => __XE_VERSION__]) }}</p>
        @if($operation->isSucceed())
            <hr>
            <p>{{ xe_trans('xe::recentUpdate') }}: <em>{{ $operation->getCompletedAt() }}</em></p>
        @endif
    </div>
</div>