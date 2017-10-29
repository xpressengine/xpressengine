<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <select name="{{$config->get('id') . 'ItemId'}}" class="xe-form-control">
        <option value="">{{xe_trans($config->get('label'))}}</option>
        @foreach ($items as $item)
            <option value="{{$item->id}}" {{$itemId == $item->id ? 'selected="selected"' : ''}}>{{$item->word}}</option>
        @endforeach
    </select>
</div>