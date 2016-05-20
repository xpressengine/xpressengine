
<div class="panel">
    <form method="post" action="{{ route('settings.editor.setting', $instanceId) }}">
        {{ csrf_field() }}
        <div class="panel-body">
            <div class="form-group">
                <div>
                    <label>Editor 선택</label>
                    <a href="#" class="pull-right __xe_btn_go_setting"><i class="xi-cog"></i></a>
                </div>
                <select class="form-control" name="editorId">
                    <option value="">선택하세요</option>
                    @foreach($editors as $id => $class)
                        <option value="{{ $id }}" data-url="{{ $class::getInstanceSettingURI($instanceId) }}" {{ $id == $selected ? 'selected' : '' }}>{{ $class::getComponentInfo('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="xi-download"></i>저장</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function () {
        $('.__xe_btn_go_setting').click(function (e) {
            e.preventDefault();

            var url = $('select[name=editorId] option:selected').data('url');

            if (url) {
                location.assign(url);
            }
        });
    });
</script>