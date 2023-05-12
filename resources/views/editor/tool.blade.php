@include('editor._title')

@include('editor._tab', ['_active' => 'tool', 'instanceId' => $instanceId])

<div class="panel-group" role="tablist" aria-multiselectable="true">
    <div class="panel">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">{{ xe_trans('xe::addTools') }}</h3>
            </div>
        </div>
        <div class="panel-collapse collapse in">
            <form method="post" id="f-editor-tool" action="{{ route('settings.editor.setting.tool', $instanceId) }}">
                {{ csrf_field() }}
                <div class="panel-body">

                    <div class="panel">
                            <label>
                                <input type="checkbox" class="__xe_inherit" name="inherit" {{ $inherit ? 'checked' : '' }}>
                                {{ xe_trans('xe::inheritMode') }}
                            </label>
                        <ul class="list-group item-setting">
                            @foreach ($items as $id => $item)
                                <li class="list-group-item">
                                    <button class="btn handler"><i class="xi-drag-vertical"></i></button>
                                    <em class="item-title">{{ $item['class']::getComponentInfo('name') }}</em>
                                    <span class="item-subtext">{{ $item['class']::getComponentInfo('description') }}</span>
                                    <div class="xe-btn-toggle pull-right">
                                        <label>
                                            <span class="sr-only">toggle</span>
                                            <input type="checkbox" name="tools[]" value="{{ $id }}" {{$item['activated'] ? 'checked' : ''}}>
                                            <span class="toggle"></span>
                                        </label>
                                    </div>
                                    <div class="pull-right">
                                        @if($uri = $item['class']::getInstanceSettingURI($instanceId))
                                            <a href="{{ $uri }}">{{ xe_trans('xe::setup') }}</a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary">{{ xe_trans('xe::save') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        XE.DynamicLoadManager.jsLoad("/assets/vendor/jqueryui/jquery-ui.min.js", function () {
            $(".item-setting").sortable({
                handle: '.handler',
                cancel: ''
            }).disableSelection();


            $('.__xe_inherit', '#f-editor-tool').click(function (e) {
                var bool = $(this).is(':checked');
                $('input,select,textarea', $('#f-editor-tool .item-setting')).not(this).prop('disabled', $(this).is(':checked'));
                bool ? $('.item-setting').sortable('disable') : $('.item-setting').sortable('enable');
            }).each(function () {
                $(this).triggerHandler('click');
            });
        })
    });
</script>
