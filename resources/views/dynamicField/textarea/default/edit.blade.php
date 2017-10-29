<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_textarea __xe_df_textarea_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <textarea type="text" name="{{$key['text']}}" class="xe-form-control __xe_df __xe_df_textarea __xe_df_textarea_{{$config->get('id')}}"/>{{$data['text']}}</textarea>
</div>
