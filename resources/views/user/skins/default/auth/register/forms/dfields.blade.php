@if (count($fields) > 0)
<h4>{{ xe_trans('xe::additionalInfo') }}</h4>
    @foreach($fields as $field)
        <div class="control-group">{!! $field->getSkin()->create(request()->all()) !!}</div>
    @endforeach
@endif
