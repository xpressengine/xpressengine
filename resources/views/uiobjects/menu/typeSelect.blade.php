<div class="row">
 @foreach($types as $id => $menuType)
  <div class="col-md-4 col-sm-12">
   <!--[D] active 시 클래스 on 추가-->
   <div class="theme_con">

    @if(sizeof($menuType['screenshot']) === 0)
     <div class="thumbnail-box" style="height:228px;background-size: cover; ">
      스크린샷 없음
     </div>
    @else
     <div class="thumbnail-box"
          style="height:228px; background: url('{{ (sizeof($menuType['screenshot'])>0)?$menuType['screenshot'][0]:'' }}') no-repeat top center; background-size: cover; ">
     </div>
    @endif

    <div class="theme_tit">
     <p class="txt_theme">{{ $menuType['title'] }}</p>
     <p class="one_line">{{ $menuType['description'] }}</p>
    </div>
    <div class="theme_active">
     <p class="active">ACTIVE</p>

     <label class="inpt_chk __xe_radio @if(shortModuleId($selectedTypeId) === shortModuleId($menuType['id'])) on @endif">
      <input type="radio" class="inpt_hide" name="selectType" value="{{ shortModuleId($menuType['id']) }}"
             @if(shortModuleId($selectedTypeId) === shortModuleId($menuType['id'])) checked @endif>
      <span>{{ $menuType['title'] }}</span>
     </label>
    </div>
   </div>
  </div>
 @endforeach
</div>
