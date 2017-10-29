<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <input type="checkbox" name="{{$key['boolean']}}" class="xe-form-control __xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}" value="1" @if($data['boolean'] === 1) checked @endif />
</div>
