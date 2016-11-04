<select name="{{$key['boolean']}}" class="form-control __xe_df __xe_df_boolean __xe_df_boolean_{{$config->get('id')}}">
    <option value="">{{xe_trans($config->get('label'))}}</option>
    <option value="1" @if($data['boolean'] === 1) selected @endif>True</option>
    <option value="0" @if($data['boolean'] === 0) selected @endif>False</option>
</select>
