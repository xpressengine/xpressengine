<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
        <option value="">{{xe_trans($config->get('label'))}}</option>
        @foreach ($items as $item)
            <option value="{{$item->id}}">{{$item->word}}</option>
        @endforeach
    </select>
</div>
