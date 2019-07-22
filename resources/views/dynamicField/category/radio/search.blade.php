<div class="xe-form-group xe-dynamicField">
    @foreach ($data['items'] as $item)
        <label class="xe-label">
            <input type="radio" name="{{$config->get('id') . '_item_id'}}" value="{{$item['value']}}"
                   @if (Request::get($config->get('id') . '_item_id') == $item['value']) checked @endif>
            <span class="xe-input-helper"></span>
            <span class="xe-label-text">{{xe_trans($item['text'])}}</span>
        </label>
    @endforeach
</div>
