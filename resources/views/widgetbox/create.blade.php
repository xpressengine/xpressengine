<form action="{{ route('widgetbox.store') }}" method="POST" data-submit="xe-ajax" data-callback="location.reload">
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::createWidgetBox') }}</strong>
    </div>
    <div class="xe-modal-body">
        {{ uio('form', [
            'fields' => [
                'id' => [
                    '_type' => 'text',
                    'label' => xe_trans('xe::id'),
                ],
                'title' => [
                    '_type' => 'text',
                    'label' => xe_trans('xe::widgetBoxName')
                ]
            ],
            'value' => [
                'id' => $id
            ]
        ]) }}
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::save') }}</button>
    </div>
</form>








