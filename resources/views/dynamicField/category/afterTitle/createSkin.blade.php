<span>카테고리 스킨 Colorset 설정</span>
@if ($config == null)
<div>

    <select type="text" name="colorSet">
        <option value="default">Default</option>
        <option value="red">Red</option>
    </select>
</div>
@else
<div>
    <select type="text" name="colorSet">
        <option value="default" {{(Input::old('colorSet', $config->get('colorSet')) == 'default') ? 'selected="selected"' : ''}}>Default</option>
        <option value="red" {{(Input::old('colorSet', $config->get('colorSet')) == 'red') ? 'selected="selected"' : ''}}>Red</option>
    </select>
</div>
@endif