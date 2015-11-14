@if($parent->getParent() !== null)
 @include('menu.partial.itemBreadCrumbs', ['parent' => $parent->getParent()])
@endif
<li><i class="xi-angle-right"></i><a
         href="{{ route('settings.menu.edit.item', [$parent->menuId, $parent->id]) }}">{{xe_trans($parent->title)}}</a>
</li>
