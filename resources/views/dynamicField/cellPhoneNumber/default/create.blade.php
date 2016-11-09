<label class="__xe_df __xe_df_number __xe_df_cellPhoneNumber_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
<input type="text" name="{{$key['cellPhoneNumber']}}" class="form-control __xe_df __xe_df_cellPhoneNumber __xe_df_cellPhoneNumber_{{$config->get('id')}}" value="{{Request::old($key['cellPhoneNumber'])}}" />
