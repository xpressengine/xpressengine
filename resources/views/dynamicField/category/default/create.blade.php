<select name="{{$config->get('id') . 'ItemId'}}" class="form-control">
    <option value="">{{$config->get('label')}}</option>
    @foreach ($items as $item)
        <option value="{{$item->id}}">{{$item->word}}</option>
    @endforeach
</select>