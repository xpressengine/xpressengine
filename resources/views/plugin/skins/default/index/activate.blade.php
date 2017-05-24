<form action="{{ route('settings.plugins.destroy') }}" method="post">
    {{ csrf_field() }}
    {{ method_field('delete') }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::delete') }}</strong>
    </div>
    <div class="xe-modal-body">

        <p>
            아래 플러그인을 켜겠습니까?
        </p>

        <hr>

        <ul>
            @foreach($plugins as $plugin)
                <li>
                    {{ $plugin->getTitle() }}({{ $plugin->getId() }})
                    <input type="hidden" name="pluginId[]" value="{{ $plugin->getId() }}">
                </li>
            @endforeach
        </ul>

    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::activate') }}</button>
    </div>
</form>








