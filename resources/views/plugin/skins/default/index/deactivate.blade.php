<form action="{{ route('settings.plugins.manage.deactivate') }}" method="post">
    {{ csrf_field() }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::deactivate') }}</strong>
    </div>
    <div class="xe-modal-body">

        <p>
            아래 플러그인을 비활성화하시겠습니까? <br>
            플러그인을 비활성화할 경우, 사이트가 정상적으로 작동하지 않을수도 있습니다.
        </p>

        <hr>

        <ul class="list-unstyled">
            @foreach($plugins as $plugin)
                <li>
                    @if($plugin->isActivated())
                        <label>
                            <input type="checkbox" name="pluginId[]" value="{{ $plugin->getId() }}" checked>
                            {{ $plugin->getTitle() }}({{ $plugin->getId() }})
                        </label>
                    @else
                        <input type="checkbox" disabled checked>
                        {{ $plugin->getTitle() }}({{ $plugin->getId() }}) - 이미 비활성화되어 있음
                    @endif
                </li>
            @endforeach
        </ul>

    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::deactivate') }}</button>
    </div>
</form>








