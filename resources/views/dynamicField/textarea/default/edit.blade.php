<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_textarea __xe_df_textarea_{{$config->get('id')}}">
        {{xe_trans($config->get('label'))}}

        @if (!$config->get('use', false))
            @include('dynamicField.userActivateLink')
        @endif
    </label>

    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <textarea
        type="text" name="{{$key['text']}}"
        class="xe-form-control xu-form-group__control __xe_df __xe_df_textarea __xe_df_textarea_{{$config->get('id')}}"
        placeholder="{{xe_trans($config->get('placeholder', ''))}}"
        data-valid-name="{{ xe_trans($config->get('label')) }}"
        @if($config->get('skinRows') !== null && $config->get('skinRows') > 0) rows="{{ $config->get('skinRows') }}" @endif
        @if($config->get('skinCols') !== null && $config->get('skinCols') > 0) cols="{{ $config->get('skinCols') }}" @endif
        @if (!$config->get('use', false)) disabled @endif
    />{{$data['text']}}</textarea>
</div>
