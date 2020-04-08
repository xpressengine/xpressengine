<form class="__xe_skin_form" action="{{ route('settings.skin.section.setting') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="skinId" value="{{ $skinId }}">
    <input type="hidden" name="instanceId" value="{{ $skinInstanceId }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="xe-modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">{{xe_trans('xe::skinSettings')}}</h4>
    </div>
    <div class="modal-body">
        {!! $view or xe_trans('xe::skinNotSupportSetting') !!}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="xe-modal">{{xe_trans('xe::close')}}</button>
        @if($view)
        <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
        @endif
    </div>
</form>
