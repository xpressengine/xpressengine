<form action="{{ route('settings.plugins.manage.delete') }}" method="post" onsubmit="return ($('.__xe_update-plugin:checked').length != 0);">
    {{ csrf_field() }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::delete') }}</strong>
    </div>



    <div class="xe-modal-body">
        <div class="xe-lypop-plugin">
            <p class="xe-lypop-plugin-text">
                아래 플러그인을 삭제합니다. 플러그인이 지정한 삭제작업을 실행한 후, 플러그인의 소스코드 디렉토리를 삭제합니다.
                삭제하시겠습니까?
            </p>
            <hr>
            <ul>
                <li>활성화되어 있는 플러그인은 비활성화된 후 삭제됩니다. 삭제하시려면 체크하십시오.</li>
                <li>직접 설치한 플러그인일 경우, 플러그인의 소스코드 디렉토리는 삭제하지 않습니다.</li>
            </ul>
            <div class="xe-lypop-plugin-check version">

                @foreach($plugins as $plugin)
                    @if($plugin->isActivated())
                        <label class="xe-label">
                            <input type="checkbox">
                            <span class="xe-input-helper"></span>
                            <div class="xe-label-text"><span>{{ $plugin->getTitle() }}</span><b>({{ $plugin->getId() }})</b> 활성화 되어 있음</div>
                        </label>
                    @else
                        <label class="xe-label">
                            <input type="checkbox" name="pluginId[]" value="{{ $plugin->getId() }}" checked >
                            <span class="xe-input-helper"></span>
                            <div class="xe-label-text"><span>{{ $plugin->getTitle() }}</span><b>({{ $plugin->getId() }})</b></div>
                        </label>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::delete') }}</button>
    </div>
</form>








