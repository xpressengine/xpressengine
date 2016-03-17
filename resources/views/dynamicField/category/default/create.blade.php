<select name="{{$config->get('id') . 'ItemId'}}" class="form-control">
    <option value="">{{xe_trans($config->get('label'))}}</option>
    @foreach ($items as $item)
        <option value="{{$item->id}}">{{$item->word}}</option>
    @endforeach
</select>