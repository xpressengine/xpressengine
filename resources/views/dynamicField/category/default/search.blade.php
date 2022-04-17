{{-- @deprecated .form-control --}}
<select name="{{ $config->get('id') . '_item_id' }}" class="form-control xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
    <option value="">Select {{xe_trans($config->get('label'))}}</option>

    @foreach ($data['items'] as $item)
        <option value="{{$item['value']}}" @if (Request::get($config->get('id') . '_item_id') == $item['value']) selected @endif>
            {{ xe_trans($item['text']) }}
        </option>
    @endforeach
</select>
