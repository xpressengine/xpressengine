    <dt>{{$config->get('dynamicFieldLabel')}}</dt>
    <dd>
        <select name="{{$config->get('id') . 'ItemId'}}" class="form-control">
            <option value="">Select {{$config->get('dynamicFieldLabel')}}</option>
            @foreach ($items as $item)
                <option value="{{$item->id}}" {{$itemId == $item->id ? 'selected="selected"' : ''}}>{{$item->word}}</option>
            @endforeach
        </select>
    </dd>