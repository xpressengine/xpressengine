@if(!$menuTree)
    Cannot found setup menu.
@else
    {{-- 메뉴는 __submenu.blade.php 를 반복적으로 호출해서 처리 --}}
    @include($_skin::getPath() . '._print_menu', [
        '__menuList' => $menuTree,
        '__depth' => 1,
    ])
@endif
