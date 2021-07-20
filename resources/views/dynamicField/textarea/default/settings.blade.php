<div>
    <input type="text" name="skinDescription" placeholder="skin description" class="form-control" value="{{$config != null ? $config->get('skinDescription') : ''}}" />
</div>

<div style="margin-top: 10px;">
    <input type="number" min="1" name="skinRows" placeholder="skin textarea rows attribute" class="form-control" value="{{ $config != null ? $config->get('skinRows') : '' }}" />
</div>

<div style="margin-top: 10px;">
    <input type="number" min="1" name="skinCols" placeholder="skin textarea cols attribute" class="form-control" value="{{ $config != null ? $config->get('skinCols') : '' }}" />
</div>
