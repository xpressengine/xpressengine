<div id="widgetbox-{{ $id }}">
    @if($widgetbox)
        <div class="widgetbox-content">
        {!! $presenter->render() !!}
        </div>
        @can('edit', new Xpressengine\Permission\Instance('widgetbox.'.$id))
        <hr>
        <div class="widget-controll">
            <p>
                <button class="xe-btn widget-controll__btn" type="button" onclick="window.open('{{route('widgetbox.edit', ['id' => $id])}}', 'widgetboxEditor', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no');return false">
                    <i class="xi-xpressengine" style="user-select: auto;"></i>
                    <span class="widget-controll__btn-label">{{ $link or $widgetbox->title.' '.xe_trans('xe::editWidgetBox') }}</span>
                </button>
            </p>
        </div>
        @endcan
    @else
        @if(auth()->user()->isAdmin())

        {{ app('xe.frontend')->js(['assets/core/xe-ui-component/js/xe-page.js', 'assets/core/xe-ui-component/js/xe-form.js'])->load() }}

        <div class="widget-controll">
        <p>{{ xe_trans('xe::notFoundWidgetBox', ['id' => $id]) }} <a href="#" data-url="{{  route('widgetbox.create', ['id' => $id]) }}" data-toggle="xe-page-modal" >{{ xe_trans('xe::createNow') }}</a></p>
        </div>
        @endif
    @endif
</div>

{{ XeFrontend::html('widgetbox.preview')->content("
<script>
function previewWidgetBox(id, html) {
    $('#widgetbox-'+id).find('.widgetbox-content').html(html);
}
</script>
")->load() }}
