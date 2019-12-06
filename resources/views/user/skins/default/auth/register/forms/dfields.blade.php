@if (count($fields) > 0)
    @foreach($fields as $field)
        <div class="control-group xu-form-group xu-form-group--large">
            {!! $field->getSkin()->create(request()->all()) !!}
        </div>
    @endforeach
@endif
