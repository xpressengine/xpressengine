@section('__xe_before_title' . $config->get('group'))
<select name="{{$config->get('id') . 'ItemId'}}" class="form-control">
    <option value="">{{$config->get('label')}}</option>
    @foreach ($items as $item)
        <option value="{{$item->id}}" {{$itemId == $item->id ? 'selected="selected"' : ''}}>{{$item->word}}</option>
    @endforeach
</select>
@stop