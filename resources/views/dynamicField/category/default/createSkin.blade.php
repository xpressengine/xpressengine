<div class="form-group">
    <label for="">카테고리 스킨 Colorset 설정</label>
    @if ($config == null)
    <select type="text" name="colorSet" class="form-control">
        <option value="default">Default</option>
        <option value="red">Red</option>
    </select>
    @else
    <select type="text" name="colorSet" class="form-control">
        <option value="default" {{(Input::old('colorSet', $config->get('colorSet')) == 'default') ? 'selected="selected"' : ''}}>Default</option>
        <option value="red" {{(Input::old('colorSet', $config->get('colorSet')) == 'red') ? 'selected="selected"' : ''}}>Red</option>
    </select>
    @endif
</div>
