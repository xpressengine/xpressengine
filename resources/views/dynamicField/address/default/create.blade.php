<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_address __xe_df_address_{{$config->get('id')}}">
        <span>{{xe_trans($config->get('label'))}}</span>

        @if (!$config->get('use', false))
            @include('dynamicField.userActivateLink')
        @endif
    </label>

    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <div class="xe-form-inline">
        <input type="text" name="{{$key['postcode']}}" placeholder="{{xe_trans('xe::postCode')}}" readonly="readonly" class="xe-form-control xu-form-group__control" value="{{Request::old($key['postcode'])}}" @if (!$config->get('use', false)) disabled @endif data-valid-name="{{ xe_trans('xe::postCode') }}">
        <input type="button" class="xe-btn xe-btn-default" onclick="execDaumPostcode('{{$config->get('id')}}')" value="{{xe_trans('xe::findPostCode')}}"  @if (!$config->get('use', false)) disabled @endif><br>
    </div>
    <div id="{{$config->get('id') . '-daumPostcodeWrap'}}" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
        <img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode('{{$config->get('id')}}')" alt="{{xe_trans('xe::fold')}}">
    </div>
    <div class="xe-form-inline">
        <input type="text" name="{{$key['address1']}}" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::address')}}" readonly="readonly" value="{{Request::old($key['address1'])}}" @if (!$config->get('use', false)) disabled @endif>
        <input type="text" name="{{$key['address2']}}" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::detailedAddress')}}" value="{{Request::old($key['address2'])}}" @if (!$config->get('use', false)) disabled @endif data-valid-name="{{ xe_trans('xe::detailedAddress') }}">
    </div>
</div>
