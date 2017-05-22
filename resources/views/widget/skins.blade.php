<div class="form-group">
    <label for="selectWidget">위젯 스킨 선택</label>

    @if(!count($skins))
        <p class="text-danger">선택된 위젯에 등록된 위젯스킨이 없습니다. 위젯을 사용하려면 반드시 한개이상의 스킨이 필요합니다.</p>
    @else
    <select class="form-control __xe_select_widgetskin" id="selectWidget" name="widget_skin">
        <option value="select-skin">스킨을 선택하세요</option>
        @foreach($skins as $id => $entity)
            <option @if(isset($skin) && $skin->getId()===$id) selected @endif value="{{ $id }}" data-url="{{ route('settings.widget.form', ['widget'=>$widget, 'skin'=>$id]) }}">{{ $entity->getTitle() }}</option>
        @endforeach
    </select>
    @endif
</div>
