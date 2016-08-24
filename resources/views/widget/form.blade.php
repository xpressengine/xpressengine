<p>위젯 설정</p>
<form id="widgetForm" action="{{ route('settings.widget.generate') }}" method="post">
    <input type="hidden" name="@id" value="{{ $widget }}">
    {!! $widgetForm !!}
</form>
<p>스킨 설정</p>
<hr>
<form id="skinForm">
    <input type="hidden" name="@id" value="{{ $skin->getId() }}">
    {!! $skinForm !!}
</form>
