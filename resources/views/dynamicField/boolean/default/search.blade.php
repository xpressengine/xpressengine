<select name="{{$key['boolean']}}" class="xe-form-control form-control __xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}" data-valid-name="{{ xe_trans($config->get('label')) }}">
    <option value="">{{xe_trans($config->get('label'))}}</option>
    <option value="1" @if ($data['boolean'] === 1) selected @endif>{{ $config->get('radioLabelYes') ?: xe_trans('xe::yes') }}</option>
    <option value="0" @if ($data['boolean'] === 0) selected @endif>{{ $config->get('radioLabelNo') ?: xe_trans('xe::no') }}</option>
</select>
