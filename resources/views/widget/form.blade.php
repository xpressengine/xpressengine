<p>위젯 설정</p>
<hr>
<form id="widgetForm" action="{{ route('settings.widget.generate') }}" method="post">
    <input type="hidden" name="@id" value="{{ $widget }}">

    {{ uio('formText', ['name'=>'@title', 'value'=> isset($title)?$title:'' , 'label'=>'위젯제목', 'class'=>'__xe_widget-title']) }}

    {!! $widgetForm !!}

</form>

@if(isset($skinForm) && $skinForm !== null)
<p>스킨 설정</p>
<hr>
<form id="skinForm">
    <input type="hidden" name="@id" value="{{ $skin->getId() }}">
    {!! $skinForm !!}
</form>
@endif
