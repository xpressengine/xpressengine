<div class="form-group">
    <label for="selectWidget">위젯 스킨 선택</label>
    <select class="form-control __xe_select_widgetskin" id="selectWidget" name="widget_skin">
        @if(!count($skins))
            <option>등록된 스킨 없음</option>
        @else
            <option value="">스킨을 선택하세요.</option>
        @endif
        @foreach($skins as $id => $entity)
            <option @if(isset($skin) && $skin->getId()===$id) selected @endif value="{{ $id }}" data-url="{{ route('settings.widget.form', ['widget'=>$widget, 'skin'=>$id]) }}">{{ $entity->getTitle() }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <button type="button" class="btn btn-default __xe_select_skin">선택</button>
</div>
