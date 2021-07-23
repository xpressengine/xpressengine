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

<div style="margin-top: 10px">
    <label class="__xe_df">Href Target</label>
    <select name="skinHrefTarget" class="form-control">
        <option value="_self" @if($config !== null && $config->get('skinHrefTarget') == '_self') selected  @endif>_self</option>
        <option value="_blank" @if($config !== null && $config->get('skinHrefTarget') == '_blank') selected  @endif>_blank</option>
    </select>
</div>
