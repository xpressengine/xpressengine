<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <div class="xu-form-group__box">
        <input type="text" name="{{ $key['text']}}" class="xe-form-control xu-form-group__control __xe_df __xe_df_text __xe_df_text_{{$config->get('id')}}"
        value="{{ $data['text'] }}" data-valid-name="{{ xe_trans($config->get('label')) }}"
        placeholder="{{xe_trans($config->get('placeholder', ''))}}" />
    </div>
</div>
