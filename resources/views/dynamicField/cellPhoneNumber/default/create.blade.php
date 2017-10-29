<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_number __xe_df_cell_phone_number_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <input type="text" name="{{$key['cell_phone_number']}}" class="xe-form-control __xe_df __xe_df_cell_phone_number __xe_df_cell_phone_number_{{$config->get('id')}}" value="{{Request::old($key['cell_phone_number'])}}" />
</div>
