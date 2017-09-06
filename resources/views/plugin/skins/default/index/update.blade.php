<form action="{{ route('settings.plugins.manage.update') }}" method="post" onsubmit="return ($('.__xe_select-plugin:checked').length != 0);">
    {{ csrf_field() }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::update_plugin') }}</strong>
    </div>
    <div class="xe-modal-body">

        @if(count($plugins))
        <div class="xe-lypop-plugin">
            @if(!$available)
                <div class="alert alert-danger">
                    <code>allow_url_fopen</code> 설정이 꺼져있습니다. 플러그인을 업데이트하려면 php.ini 파일에서 이 설정을 켜야 합니다.
                </div>
            @else
            <p class="xe-lypop-plugin-text">
                아래 플러그인을 업데이트합니다. 업데이트하는 플러그인에서 의존하는 다른 플러그인이 같이 설치될 수 있습니다.
                업데이트 과정은 수분이상 소요될 수 있습니다. <br>
                업데이트하시겠습니까?
            </p>
            @endif
            <div class="xe-lypop-plugin-check version">
                @foreach($plugins as $plugin)
                <label class="xe-label">
                    <input type="checkbox" class="__xe_select-plugin" name="plugin[{{ $plugin->getId() }}][update]" value="1" checked>
                    <span class="xe-input-helper"></span>
                    <div class="xe-label-text"><span>{{ $plugin->getTitle() }}</span><b>({{ $plugin->getId() }})</b>
                        <dl>
                            <dt class="xe-sr-only">현재 버전</dt>
                            <dd>ver.{{ $plugin->getVersion() }} <i class="xi-long-arrow-right"></i></dd>
                            <dt class="xe-sr-only">다음 버전</dt>
                            <dd>
                                <select name="plugin[{{ $plugin->getId() }}][version]">
                                    @foreach(array_reverse($plugin->getVersions()) as $release)
                                    <option value="{{$release->version}}">ver.{{ $release->version }}</option>
                                    @endforeach
                                </select>
                            </dd>
                        </dl>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @else
        <p>
            업데이트할 플러그인이 없습니다 모든 플러그인이 최신 버전입니다.
        </p>
        @endif
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>

        @if($available && count($plugins))
        <button type="submit" class="xe-btn xe-btn-primary">{{ xe_trans('xe::update_plugin') }}</button>
        @endif
    </div>
</form>








