{{ XeFrontend::js('assets/core/common/widgetSetup.js')->load() }}
<div class="row">
<form name="__xe_widgetListForm" id="__xe_widgetList" method="get">
    <div class="col-md-12">
        <input type="hidden" name="targetId" id="targetId" value="{{$targetId}}">
        <div class="form-group">
            <label for="">{{ xe_trans('xe::selectWidget') }}</label>
            <p class="desc-text">{{ xe_trans('xe::selectWidgetDescription') }}</p>
            <select id="widget" name="widget" class="form-control">
                @foreach ($widgets as $id => $widget)
                    <option value="{{ $id }}" >
                        {{ $widget::getComponentInfo('name') }} - {{ $widget::getComponentInfo('description') }}
                    </option>
                @endforeach
            </select>
        </div>
        <?php /*
        <a class="btn btn-default" href="/manage/module/pluginA@board/dynamicField/freeboard">list</a>
    */?>
        <button type="button" class="btn btn-primary __xe_btn_getSetup">{{xe_trans('xe::next')}}</button>
    </div>
</form>
</div>
<script>
    var XeWidgetSetup;
    $(function() {
        function setContentToTarget(response) {
            $('#{{$targetId}}').val(response);
        }

        XeWidgetSetup = new XeWidgetSetup;
        XeWidgetSetup.init(
                "__xe_widgetList"
                ,"{{ route('manage.widget.setup') }}"
                ,"{{ route('manage.widget.generate') }}"
                ,setContentToTarget
                );
    });
</script>
