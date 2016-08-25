<div class="form-group">
    <label for="selectWidget">위젯 스킨 선택</label>
    <select class="form-control __xe_select_widgetskin" id="selectWidget" name="widget_skin">
        <option value="">스킨을 선택하세요</option>
        @if(!count($skins))
            <option value="no-skin" data-url="{{ route('settings.widget.form', ['widget'=>$widget]) }}">스킨 사용 안 함(등록된 스킨 없음)</option>
        @endif
        @foreach($skins as $id => $entity)
            <option @if(isset($skin) && $skin->getId()===$id) selected @endif value="{{ $id }}" data-url="{{ route('settings.widget.form', ['widget'=>$widget, 'skin'=>$id]) }}">{{ $entity->getTitle() }}</option>
        @endforeach
    </select>
</div>
