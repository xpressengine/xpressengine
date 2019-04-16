{{-- @deprecated .form-control --}}
<select name="{{$key['_item_id']}}" class="form-control xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
    <option value="">Select {{xe_trans($config->get('label'))}}</option>
    @foreach ($data['categoryItems'] as $item)
        <option value="{{$item->id}}" {{$itemId == $item->id ? 'selected="selected"' : ''}}>{{$item->word}}</option>
    @endforeach
</select>
