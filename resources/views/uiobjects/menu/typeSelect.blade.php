<div class="row">
 @foreach($types as $id => $menuType)
  <div class="col-md-4 col-sm-12">
   <!--[D] active 시 클래스 on 추가-->
   <div class="menutype_con">

    @if(sizeof($menuType['screenshot']) === 0)
     <div class="thumbnail-box" style="background: url({{asset('/assets/core/common/img/no_image_632x654.jpg')}}) ; height:228px; background-size: cover; " title="{{xe_trans('xe::noScreenshot')}}">
     </div>
    @else
     <div class="thumbnail-box"
          style="height:228px; background: url('{{ (sizeof($menuType['screenshot'])>0)?asset($menuType['screenshot'][0]):'' }}') no-repeat top center; background-size: cover; ">
     </div>
    @endif

    <div class="menutype_tit">
     <p class="txt_theme">{{ $menuType['title'] }}</p>
     <p class="one_line">{{ $menuType['description'] }}</p>
    </div>
    <div class="menutype_active">
     <p class="active">ACTIVE</p>

     <label class="inpt_chk __xe_radio @if(short_module_id($selectedTypeId) === short_module_id($menuType['id'])) on @endif">
      <input type="radio" class="inpt_hide" name="selectType" value="{{ short_module_id($menuType['id']) }}"
             @if(short_module_id($selectedTypeId) === short_module_id($menuType['id'])) checked @endif>
      <span>{{ $menuType['title'] }}</span>
     </label>
    </div>
   </div>
  </div>
 @endforeach
</div>
