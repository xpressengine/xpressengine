<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_email __xe_df_email_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <div class="xu-form-group__box">
        <input type="email" name="{{$key['email']}}" class="xe-form-control xu-form-group__control __xe_df __xe_df_email __xe_df_email_{{$config->get('id')}}" value="" placeholder="ex) example@email.com" data-valid-name="{{ xe_trans($config->get('label')) }}" />
    </div>
</div>
