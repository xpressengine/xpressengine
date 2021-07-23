<div>
    <label class="__xe_df">Skin Description</label>
    <input type="text" name="skinDescription" placeholder="skin description" class="form-control" value="{{$config != null ? $config->get('skinDescription') : ''}}" />
</div>

<div style="margin-top: 10px">
    <label class="__xe_df">Href Activate</label>
    <select name="skinHrefActivate" class="form-control">
        <option value="off" @if($config !== null && $config->get('skinHrefActivate') == 'off') selected  @endif>off</option>
        <option value="on" @if($config !== null && $config->get('skinHrefActivate') == 'on') selected  @endif>on</option>
    </select>
</div>