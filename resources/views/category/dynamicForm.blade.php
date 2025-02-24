
@if(blank($categoryItem))
    @foreach($types as $type)
        {!! $type->getSkin()->create([]) !!}
    @endforeach
@else
    @foreach($types as $type)
        {!! $type->getSkin()->edit($categoryItem->toArray()) !!}
    @endforeach
@endif


