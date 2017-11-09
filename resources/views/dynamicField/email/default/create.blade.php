<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_email __xe_df_email_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <input type="email" name="{{$key['email']}}" class="xe-form-control __xe_df __xe_df_email __xe_df_email_{{$config->get('id')}}" value="" placeholder="ex) example@email.com"/>
</div>
