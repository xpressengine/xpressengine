@foreach($items as $itemId => $item)
    @if($item->getDepth() < $maxDepth)
        <option value="{{$itemId}}" @if($parent == $itemId) selected @endif>
            @for($i = 0; $i < $item->getDepth(); $i++){{'-'}}@endfor  {{xe_trans($item->title)}}
        @if($item->hasChild())
                @include('menu.partial.itemOption', ['items' => $item->getChildren(), 'maxDepth' => $maxDepth])
        @endif
    </option>
    @endif
@endforeach
