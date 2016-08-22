<form id="widgetForm" action="{{ route('settings.widget.generate') }}" method="post">
    <input type="hidden" name="@id" value="{{ $widget }}">
    {!! $widgetForm !!}
</form>
<form id="skinForm">
    <input type="hidden" name="@id" value="{{ $skin->getId() }}">
    {!! $skinForm !!}
</form>
