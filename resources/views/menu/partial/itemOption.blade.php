@foreach($items as $item)
    @if($item->getDepth() < $maxDepth)
        <option value="{{$item->getKey()}}" @if($parent == $item->getKey()) selected @endif>
            @for($i = 0; $i <= $item->getDepth(); $i++){{'-'}}@endfor {{xe_trans($item->title)}}
        </option>
        @if($item->hasChild())
            @include('menu.partial.itemOption', ['items' => $item->getChildren(), 'maxDepth' => $maxDepth])
        @endif
    @endif
@endforeach
