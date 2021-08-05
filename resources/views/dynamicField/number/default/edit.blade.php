<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_number __xe_df_number_{{$config->get('id')}}">
        <span>{{xe_trans($config->get('label'))}}</span>

        @if (!$config->get('use', false))
            @include('dynamicField.userActivateLink')
        @endif
    </label>

    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <input
        type="text"
        name="{{$key['num']}}"
        class="xe-form-control xu-form-group__control __xe_df __xe_df_number __xe_df_number_{{$config->get('id')}}"
        value="{{$data['num']}}"
        data-valid-name="{{ xe_trans($config->get('label')) }}"
        placeholder="{{xe_trans($config->get('placeholder', ''))}}"
        @if (!$config->get('use', false)) disabled @endif
    />
</div>
