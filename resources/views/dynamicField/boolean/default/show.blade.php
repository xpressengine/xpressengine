<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    <span class="__xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}">
        @if($data['boolean'])
            {{ $config->get('radioLabelYes') ?: xe_trans('xe::yes') }}
        @else
            {{ $config->get('radioLabelNo') ?: xe_trans('xe::no') }}
        @endif
    </span>
</div>
