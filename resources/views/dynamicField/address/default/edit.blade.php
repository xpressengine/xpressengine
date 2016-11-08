<input type="text" name="{{$key['postcode']}}" placeholder="{{xe_trans('xe::postCode')}}" readonly="readonly" class="form-control" value="{{$data['postcode']}}">
<input type="button" onclick="execDaumPostcode('{{$config->get('id')}}')" value="{{xe_trans('xe::findPostCode')}}"><br>

<div id="{{$config->get('id') . '-daumPostcodeWrap'}}" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
    <img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode('{{$config->get('id')}}')" alt="{{xe_trans('xe::fold')}}">
</div>
<input type="text" name="{{$key['address1']}}" class="d_form large" placeholder="{{xe_trans('xe::address')}}" readonly="readonly" value="{{$data['address1']}}">
<input type="text" name="{{$key['address2']}}" class="d_form large" placeholder="{{xe_trans('xe::detailedAddress')}}" value="{{$data['address2']}}">
