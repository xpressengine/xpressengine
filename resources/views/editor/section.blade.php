
<div id="__xe_section_editor">
    <div class="form-group">
        <div class="pull-left">
            <label>Editor</label>
        </div>
        <div class="pull-right">
            <a href="{{ route('settings.editor.setting.detail', $instanceId) }}" class="btn btn-link"><i class="xi-cog"></i><span class="hidden-xs">{{xe_trans('xe::setup')}}</span></a>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" aria-describedby="basic-addon2" readonly="readonly" value="{{ $selected ? $selected->getComponentInfo('name') : '' }}">
            <!--[D] 상세 설정 등 투명 링크는 .input-group-link 클래스 추가  -->
            <span class="input-group-btn input-group-link">
                @if($selected && $link = $selected->getInstanceSettingURI($instanceId))
                    <a href="{{ $link }}" class="btn btn-link">{{xe_trans('xe::detailConfigure')}}</a>
                @endif
            </span>

            <span class="input-group-btn">
                <button class="btn btn-default __xe_btn_edit" type="button">{{xe_trans('xe::edit')}}</button>
            </span>
        </div>
    </div>
    <!--[D] 변경 버튼 클릭 시 display: none/block 처리 -->
    <div class="panel-body __xe_edit_body" style="display: none;">
        <form method="post" action="{{ route('settings.editor.setting', $instanceId) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label>{{xe_trans('xe::editorEdit')}}</label>
                <select class="form-control" name="editorId">
                    @foreach($editors as $id => $class)
                        <option value="{{ $id }}" {{ $selected && $id === $selected->getId() ? 'selected' : '' }}>{{ $class::getComponentInfo('name') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group clearfix">
                <div class="pull-right">
                    <button type="button" class="btn btn-default __xe_btn_close">{{xe_trans('xe::close')}}</button>
                    <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.__xe_btn_edit', '#__xe_section_editor').click(function () {
            $('.__xe_edit_body', '#__xe_section_editor').show();
        });
        $('.__xe_btn_close', '#__xe_section_editor').click(function () {
            $('.__xe_edit_body', '#__xe_section_editor').hide();
        });
    });
</script>
