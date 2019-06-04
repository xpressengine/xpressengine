<h3>{{ xe_trans('xe::coreVersionNotCorrect') }}</h3>
<div class="panel">
    <div class="panel-body">
        <p><strong>{{ xe_trans('xe::currentInstalledVersion') }} : {{ $installedVersion }}</strong></p>
        <p><strong>{{ xe_trans('xe::downloadedVersion') }} : {{ __XE_VERSION__ }}</strong></p>
        <p class="help-block">
            {{ xe_trans('xe::notWorkNormallyIfVersionChangedRandomly') }}
        </p>
    </div>
</div>