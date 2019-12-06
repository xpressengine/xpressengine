<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_textarea __xe_df_textarea_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <textarea type="text" name="{{$key['text']}}" class="xe-form-control xu-form-group__control __xe_df __xe_df_textarea __xe_df_textarea_{{$config->get('id')}}" value=""
    placeholder="{{xe_trans($config->get('placeholder', ''))}}" /></textarea>
</div>
