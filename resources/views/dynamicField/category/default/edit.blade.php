<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">
        {{xe_trans($config->get('label'))}}

        @if (!$config->get('use', false))
            @include('dynamicField.userActivateLink')
        @endif
    </label>

    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}" @if (!$config->get('use', false)) disabled @endif>
        <option value="" @if (empty($data['item_id'])) selected @endif @if (!$config->get('use', false)) disabled @endif>{{ xe_trans($config->get('label')) }}</option>

        @foreach ($data['items'] as $item)
            <option value="{{$item['value']}}" @if ($data['item_id'] == $item['value']) selected @endif @if (!$config->get('use', false)) disabled @endif>{{xe_trans($item['text'])}}</option>
        @endforeach
    </select>
</div>
