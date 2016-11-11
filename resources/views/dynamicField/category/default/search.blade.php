<select name="{{$key['itemId']}}" class="form-control">
    <option value="">Select {{xe_trans($config->get('label'))}}</option>
    @foreach ($data['categiryItems'] as $item)
        <option value="{{$item->id}}" {{$itemId == $item->id ? 'selected="selected"' : ''}}>{{$item->word}}</option>
    @endforeach
</select>