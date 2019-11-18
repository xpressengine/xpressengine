@expose_route('manage.dynamicField.index')
@expose_route('manage.dynamicField.update')
@expose_route('manage.dynamicField.getEditInfo')
@expose_route('manage.dynamicField.destroy')
@expose_route('manage.dynamicField.getSkinOption')
@expose_route('manage.dynamicField.getAdditionalConfigure')


<!-- 사용자 정의 항목 -->
<div style="margin-top: 26px;">
    <!-- 드래그 리스트 항목 -->
    <ul class="sort-list sort-list--custom-item sort-list sort-list--custom-item-header">
        <li>
            <div class="sort-list__header-title">사용자 정의 항목</div>
            <div class="sort-list__header-text">사용</div>
            <div class="sort-list__header-text">필수</div>
            <div class="sort-list__header-text sort-list__header-text--empty"></div>
        </li>
    </ul>

    <!-- 드래그 리스트 -->
    <ul class="sort-list sort-list--custom-item __user-dfield-items">
    </ul>

    <div>
        <button type="button" class="xu-button xu-button--link __xe_btn_add" style="margin-top: 16px;">
            <span class="xu-button__text">사용자 정의 항목 추가</span>
        </button>
    </div>
</div>




<!-- Modal -->
<div class="xe-modal __xe_df_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="xe-modal">&times;</button>
                <h4 class="modal-title">{{xe_trans('xe::dynamicField')}}</h4>
            </div>
            <div class="modal-body">
                <p><!-- form --></p>
            </div>
            <div class="xe-modal-footer">
                <button type="button" class="xe-btn xe-btn-secondary __xe_btn_close" data-dismiss="xe-modal">{{xe_trans('xe::cancel')}}</button>
                <button type="button" class="xe-btn xe-btn-primary __xe_btn_submit">{{xe_trans('xe::submit')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var that = this
        var data = { group: 'user' }

        XE.get('manage.dynamicField.index', data)
            .then(function (result) {
                console.debug('result', result)
                for (var i in result.data.list) {
                    drawDynamicFieldItem(result.data.list[i])
                }
            })
    })

    function drawDynamicFieldItem (item) {
        console.debug('drawDynamicFieldItem', item)
        var $container = $('.__user-dfield-items')
        var $item = $(dynamicFieldTemplate)

        $item.find('.sort-list__text').text(item.label)
        $item.find('[name=df_use]').prop('checked', item.use).attr('name', 'df_use[' + item.id + ']')
        $item.find('[name=df_required]').prop('checked', item.required).attr('name', 'df_required[' + item.id + ']')

        $container.append($item)
    }

    var dynamicFieldTemplate = '<li>\
        <div class="sort-list__handler">\
            <button type="button" class="xu-button xu-button--subtle-link xu-button--icon __handler">\
                <span class="xu-button__icon">\
                    <i class="xi-drag-vertical"></i>\
                </span>\
            </button>\
        </div>\
        <p class="sort-list__text"></p>\
        <div class="sort-list__checkradio">\
            <label class="xu-label-checkradio">\
                <input type="checkbox" name="df_use">\
                <span class="xu-label-checkradio__helper"></span>\
            </label>\
        </div>\
        <div class="sort-list__checkradio">\
            <label class="xu-label-checkradio">\
                <input type="checkbox" name="df_required">\
                <span class="xu-label-checkradio__helper"></span>\
            </label>\
        </div>\
        <div class="sort-list__button">\
            <button type="button" class="xu-button xu-button--subtle xu-button--icon">\
                <span class="xu-button__icon">\
                    <i class="xi-pen"></i>\
                </span>\
            </button>\
        </div>\
        <div class="sort-list__button">\
            <button type="button" class="xu-button xu-button--subtle xu-button--icon">\
                <span class="xu-button__icon">\
                    <i class="xi-trash"></i>\
                </span>\
            </button>\
        </div>\
    </li>'
</script>
