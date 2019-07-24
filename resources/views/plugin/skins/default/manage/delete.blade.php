<form action="{{ route('settings.plugins.manage.delete') }}" method="post" onsubmit="return ($('.__xe_select-plugin:checked').length != 0);">
    {{ csrf_field() }}
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::delete') }}</strong>
    </div>

    <div class="xe-modal-body">
        <div class="xe-lypop-plugin">
            <p class="xe-lypop-plugin-text">
                {{ xe_trans('xe::descDeletePlugin') }} <br>
                {{ xe_trans('xe::confirmDelete') }}
            </p>
            <hr>
            <div class="xe-lypop-plugin-check version">
                @foreach($plugins as $plugin)
                    <label class="xe-label">
                        <input type="checkbox" class="__xe_select-plugin" name="pluginId[]" value="{{ $plugin->getId() }}" checked >
                        <span class="xe-input-helper"></span>
                        <div class="xe-label-text"><span>{{ $plugin->getTitle() }}</span><b>({{ $plugin->getId() }})</b> {{ $plugin->isActivated() ? xe_trans('xe::activatedPlugin') : '' }}</div>
                    </label>
                @endforeach
            </div>
            <div>
                <label>
                    <input type="checkbox" name="force" value="1" checked>
                    <span>{{ xe_trans('xe::descDeleteActivatedPlugin') }} {{ xe_trans('xe::checkToRemove') }}</span>
                </label>
            </div>
        </div>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::delete') }}</button>
    </div>
</form>
