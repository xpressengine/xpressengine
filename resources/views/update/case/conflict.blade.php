<h3>코어 버전정보가 정상적이지 않습니다.</h3>
<div class="panel">
    <div class="panel-body">
        <p><strong>{{ xe_trans('xe::currentInstalledVersion') }} : {{ $installedVersion }}</strong></p>
        <p><strong>{{ xe_trans('xe::downloadedVersion') }} : {{ __XE_VERSION__ }}</strong></p>
        <p class="help-block">
            임의로 버전정보가 변경된 경우 정상적으로 동작하지 않을 수 있습니다.
        </p>
    </div>
</div>