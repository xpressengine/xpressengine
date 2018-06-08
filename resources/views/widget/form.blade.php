<p>{{ xe_trans('xe::widgetSettings') }}</p>
<hr>
<form id="widgetForm" action="{{ route('settings.widget.generate') }}" method="post">
    <input type="hidden" name="@id" value="{{ $widget }}">

    {{ uio('formText', ['name'=>'@title', 'value'=> isset($title)?$title:'' , 'label'=>xe_trans('xe::widgetTitle'), 'class'=>'__xe_widget-title']) }}

    {!! $widgetForm !!}

    <input type="hidden" name="@skin-id" value="{{ $skin->getId() }}">
    @if(isset($skinForm) && $skinForm !== null)
    <p>{{ xe_trans('xe::skinSettings') }}</p>
    <hr>
    <div id="skinForm">
        {!! $skinForm !!}
    </div>
    @endif


</form>

