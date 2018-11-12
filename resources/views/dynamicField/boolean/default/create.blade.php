<div class="xe-form-group xe-dynamicField">
    <div>
        <label class="xe-label">
            <input type="checkbox" name="{{$key['boolean']}}"class="xe-form-control __xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}" value="1" data-valid-name="{{ xe_trans($config->get('label')) }}">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text">{{ xe_trans($config->get('label')) }}</span>
        </label>
    </div>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
</div>
