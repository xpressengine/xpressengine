<div class="form-group">
    <label for="selectWidget">{{ xe_trans('xe::selectWidgetSkin') }}</label>

    @if(!count($skins))
        <p class="text-danger">{{ xe_trans('xe::alertNoWidgetSkins') }}</p>
    @else
    <select class="form-control __xe_select_widgetskin" id="selectWidget" name="widget_skin">
        <option value="select-skin">{{ xe_trans('xe::choose') }}</option>
        @foreach($skins as $id => $entity)
            <option @if(isset($skin) && $skin->getId()===$id) selected @endif value="{{ $id }}" data-url="{{ route('settings.widget.form', ['widget'=>$widget, 'skin'=>$id, 'code'=>$code ]) }}">{{ $entity->getTitle() }}</option>
        @endforeach
    </select>
    @endif
</div>
