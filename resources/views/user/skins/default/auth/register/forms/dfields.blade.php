@if (count($fields) > 0)
    <h3>{{ xe_trans('xe::additionalInfo') }}</h3>
    @foreach($fields as $field)
        <div class="control-group xu-form-group">
            {!! $field->getSkin()->create(request()->all()) !!}
        </div>
    @endforeach
@endif
