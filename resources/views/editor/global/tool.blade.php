{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.min.js')->appendTo('head')->load() }}

@include('editor.global._title')

<div class="container-fluid container-fluid--part">
    @include('editor.global._tab', ['_active' => 'tool'])
</div>

<div class="container-fluid container-fluid--part">
    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::addTools') }}</h3>
                </div>
            </div>
            <div class="panel-collapse collapse in">
                <form method="post" action="{{ route('settings.editor.global.tool') }}">
                    {{ csrf_field() }}
                    <div class="panel-body">

                        <div class="panel">
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
</div>

<script>
    $(function () {
        $(".item-setting").sortable({
            handle: '.handler',
            cancel: ''
        }).disableSelection();
    });
</script>
