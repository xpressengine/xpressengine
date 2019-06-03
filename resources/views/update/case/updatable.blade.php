<h3>업데이트된 버전의 XE를 사용할 수 있습니다.</h3>
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

                <p class="help-block">
                    지금 업데이트된 버전의 XE를 사용할 수 있습니다.<br>
                    최대 수분이 소요될 수 있습니다. 사이트가 업데이트되는 동안 유지관리 모드가 됩니다.<br>
                    업데이트가 완료되는대로 사이트가 정상으로 돌아올 것 입니다.<br>
                </p>
                {{--<p>--}}
                    {{--{{ xe_trans('xe::newCoreDownloaded') }} <br>--}}
                    {{--{{ xe_trans('xe::alertUpdateCore', ['version' => __XE_VERSION__]) }} {{ xe_trans('xe::confirmUpdate') }}--}}
                {{--</p>--}}

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
                        업데이트 버전 :
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
                <p class="help-block">
                    지금 업데이트된 버전의 XE를 사용할 수 있습니다.<br>
                    최대 수분이 소요될 수 있습니다. 사이트가 업데이트되는 동안 유지관리 모드가 됩니다.<br>
                    업데이트가 완료되는대로 사이트가 정상으로 돌아올 것 입니다.<br>
                </p>
                {{--<p>--}}
                {{--새로운 버전의 XE가 있습니다. <br>--}}
                {{--{{ xe_trans('xe::alertUpdateCore', ['version' => $latest]) }} {{ xe_trans('xe::confirmUpdate') }}--}}
                {{--</p>--}}

                @if($downloaded)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="skip-download" value="Y" onclick="$('#__chkbox-composer').slideDown();">
                            다운로드 {{ xe_trans('xe::doNotRun') }}
                            <small>- 이미 다운로드된 버전으로 업데이트를 마무리하는 경우 체크하십시오.</small>
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

            <button type="submit" class="xe-btn xe-btn-primary xe-btn-lg">지금 업데이트</button>
        </form>
        @if($operation->isFailed() || $operation->isExpired())
            <hr>
            <p>
                최근 기록:
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