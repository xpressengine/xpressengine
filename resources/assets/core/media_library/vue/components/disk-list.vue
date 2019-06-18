<template>
  <div class="media-manager-aside">
    <h3 class="media-manager-aside__title">저장소</h3>
    <!--
      [D] 저장소 메뉴 열릴 때(class="media-manager-aside__mobile-button" 버튼 영역 클리 시) class="media-manager-aside__content" 영역에 class="open" 추가 (화살표 방향 변경, 저장소 팝업 노출)
    -->
    <div class="media-manager-aside__content open">
      <button type="button" class="media-manager-aside__mobile-button">
        Main Assets
        <span class="media-manager-aside__mobile-button-icon">
          <i class="xi-angle-down-min"></i>
        </span>
      </button>
      <ul class="media-manager-aside__list">
        <!-- [D] 선택 되어져 있는 저장소 li 태그에 class="on" 추가 -->
        <li class="on">
          <button type="button" class="media-manager-aside__button">Main Assets</button>
        </li>
        <li>
          <button type="button" class="media-manager-aside__button">Common</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
}
</script>
