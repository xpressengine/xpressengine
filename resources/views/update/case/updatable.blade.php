@section('updateDescription')
    <p class="help-block">
        {{ xe_trans('xe::availableUpdatedCoreVersion') }}<br>
        {{ xe_trans('xe::takeUpSeveralMinutes') }} {{ xe_trans('xe::beMaintenanceModeWhileUpdating') }}<br>
        {{ xe_trans('xe::returnToNormalWhenUpdateComplete') }}<br>
    </p>
@endsection
<h3>{{ xe_trans('xe::availableUpdatedCoreVersion') }}</h3>
<div class="panel">
    <div class="panel-body">
        <form action="{{ route('settings.coreupdate.update') }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('put') }}
            @if(version_compare(__XE_VERSION__, $latest) === 0)
                <p>
                    <strong>{{ xe_trans('xe::currentInstalledVersion') }}: {{ $installedVersion }}</strong>
                    <br>
                    <strong>{{ xe_trans('xe::downloadedVersion') }}: {{ __XE_VERSION__ }}</strong>
                </p>


                @yield('updateDescription')

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="skip-composer" value="Y">
                        <code>composer update</code> {{ xe_trans('xe::doNotRun') }}
                        <small>- {{ xe_trans('xe::checkIfAlreadyRunComposer') }}</small>
                    </label>
                </div>
            @else
                <p>
                    <strong>{{ xe_trans('xe::currentInstalledVersion') }} : {{ $installedVersion }}</strong>
                    <br>
                    <strong>
                        {{ xe_trans('xe::updateVersion') }} :
                        <select name="version">
                            @foreach(array_reverse($updatables) as $updatable)
                                <option value="{{ $updatable }}">{{ $updatable }}</option>
                            @endforeach
                        </select>
                        @if($downloaded = version_compare(__XE_VERSION__, $installedVersion) === 1)
                            <span>({{ xe_trans('xe::downloadedVersion') }} : {{ __XE_VERSION__ }})</span>
                        @endif
                    </strong>
                </p>

                @yield('updateDescription')

                @if($downloaded)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="skip-download" value="Y" onclick="$('#__chkbox-composer').slideDown();">
                            {{ xe_trans('xe::download') }} {{ xe_trans('xe::doNotRun') }}
                            <small>- {{ xe_trans('xe::checkIfFinalizingUpdateToDownloadedVersion') }}</small>
                        </label>
                    </div>
                    <div class="checkbox" id="__chkbox-composer" style="display: none;">
                        <label>
                            <input type="checkbox" name="skip-composer" value="Y">
                            <code>composer update</code> {{ xe_trans('xe::doNotRun') }}
                            <small>- {{ xe_trans('xe::checkIfAlreadyRunComposer') }}</small>
                        </label>
                    </div>
                    <script>
                      jQuery(function($) {
                        $('input[name="skip-download"]').change(function () {
                          if ($(this).is(':checked')) {
                            $('#__chkbox-composer').slideDown();
                            $('select[name="version"]').prop('disabled', true);
                          } else {
                            $('#__chkbox-composer').slideUp();
                            $('select[name="version"]').prop('disabled', false);
                          }
                        }).triggerHandler('change');
                      });
                    </script>
                @endif
            @endif

            <button type="submit" class="xe-btn xe-btn-primary xe-btn-lg">{{ xe_trans('xe::updateNow') }}</button>
        </form>
        @if($operation->isFailed() || $operation->isExpired())
            <hr>
            <p>
                {{ xe_trans('xe::recentOperation') }}:
                @if($operation->isFailed())
                    <span class="label label-danger">{{ xe_trans('xe::fail') }}</span>
                @else
                    <span class="label label-danger">{{ xe_trans('xe::fail') }}({{ xe_trans('xe::timeoutExceeded') }})</span>
                @endif
                {{ $operation->getCompletedAt() }}
                @if($filePath = $operation->getLogFile())
                <button type="button" class="xe-btn btn-link btn-sm" data-toggle="collapse" aria-expanded="false" data-target=".operation-log">로그보기</button>
                <div class="collapse operation-log">
                    <div class="well">{!! nl2br(file_get_contents(storage_path($filePath))) !!}</div>
                </div>
                @endif
            </p>
        @endif
    </div>
</div>