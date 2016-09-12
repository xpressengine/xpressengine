<form action="{{ route('widgetbox.store') }}" method="POST" data-submit="xe-ajax" data-callback="location.reload">
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">위젯박스 생성</strong>
    </div>
    <div class="xe-modal-body">
        {{ uio('form', [
            'fields' => [
                'id' => [
                    '_type' => 'text',
                    'label' => '아이디',
                ],
                'title' => [
                    '_type' => 'text',
                    'label' => '박스명'
                ]
            ],
            'value' => [
                'id' => $id
            ]
        ]) }}
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">취소</button>
        <button type="submit" class="xe-btn xe-btn-primary" >저장</button>
    </div>
</form>








