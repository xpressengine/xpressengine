@if (count($fields) > 0)
<h4>부가 정보 입력</h4>
    @foreach($fields as $field)
        <div class="control-group">{!! $field->getSkin()->create(request()->all()) !!}</div>
    @endforeach
@endif
