<form action="{{ route('settings.plugins.manage.update') }}" method="post" onsubmit="return ($('.__xe_select-plugin:checked').length != 0);">
    {{ csrf_field() }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::updates') }}</strong>
    </div>
    <div class="xe-modal-body">

        @if(count($plugins))
        <div class="xe-lypop-plugin">
            @if(!$available)
                <div class="alert alert-danger">
                    {!! xe_trans('xe::iniOptionOff', ['option' => '<code>allow_url_fopen</code>']) !!} {!! xe_trans('xe::turnOnIniOptionForPluginUpdate', ['option' => '']) !!}
                </div>
            @else
            <p class="xe-lypop-plugin-text">
                {{ xe_trans('xe::descUpdatePlugins') }} <br>
                {{ xe_trans('xe::confirmUpdatePlugin') }}
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
            {{ xe_trans('xe::noPluginsToUpdate') }}
        </p>
        @endif
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>

        @if($available && count($plugins))
        <button type="submit" class="xe-btn xe-btn-primary">{{ xe_trans('xe::updates') }}</button>
        @endif
    </div>
</form>








