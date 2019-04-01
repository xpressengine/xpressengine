<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_url __xe_df_url_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <input type="url" name="{{$key['url']}}" class="xe-form-control __xe_df __xe_df_url __xe_df_url_{{$config->get('id')}}" value=""
           @if (xe_trans($config->get('placeholder', '')) != '') placeholder="{{xe_trans($config->get('placeholder'))}}" @else placeholder="ex) http://example.com" @endif/>
</div>
