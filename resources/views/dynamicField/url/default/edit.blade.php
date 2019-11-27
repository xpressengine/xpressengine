<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_url __xe_df_url_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <input type="url" name="{{$key['url']}}" class="xe-form-control xu-form-group__control __xe_df __xe_df_url __xe_df_url_{{$config->get('id')}}" value="{{$data['url']}}"
           @if (xe_trans($config->get('placeholder', '')) != '') placeholder="{{xe_trans($config->get('placeholder'))}}" @else placeholder="ex) http://example.com" @endif/>
</div>
