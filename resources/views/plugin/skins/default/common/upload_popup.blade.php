<form action="{{ route('settings.plugins.manage.upload') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ $typeName }} {{ xe_trans('xe::upload') }}</strong>
    </div>
    <div class="xe-modal-body">
        <input type="file" name="plugin">
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::upload') }}</button>
    </div>
</form>
