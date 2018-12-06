<div class="xe-form-group xe-dynamicField">
    <div>
        <div class="xe-form-inline __xe-input-group">
            <label class="xe-label">
                <strong>{{ xe_trans($config->get('label')) }}</strong>
            </label>
            <label class="xe-label">
                <input type="radio" name="{{$key['boolean']}}" class="__xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}" value="1" data-valid-name="{{ xe_trans($config->get('label')) }}">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{ $config->get('radioLabelYes') ?: xe_trans('xe::yes') }}</span>
            </label>
            <label class="xe-label">
                <input type="radio" name="{{$key['boolean']}}" class="__xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}" value="0" data-valid-name="{{ xe_trans($config->get('label')) }}">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{ $config->get('radioLabelNo') ?: xe_trans('xe::no') }}</span>
            </label>
        </div>
    </div>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
</div>
