<form action="{{ route('settings.user.destroy') }}" method="post">
    {{ csrf_field() }}
    {{ method_field('delete') }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::user') }} {{ xe_trans('xe::delete') }}</strong>
    </div>
    <div class="xe-modal-body">

        {{ xe_trans('xe::confirmDeleteUsers') }}

        <hr>

        <ul>
            @foreach($users as $user)
                <li>
                    {{ $user->getDisplayName() }}({{ $user->email }})
                    <input type="hidden" name="userId[]" value="{{ $user->id }}">
                </li>
            @endforeach
        </ul>

    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::delete') }}</button>
    </div>
</form>








