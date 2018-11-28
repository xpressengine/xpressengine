
<div class="xe-form-group">
    <label>{{ xe_trans('xe::view') }} Text</label>
    <div class="xe-row">
        <div class="xe-col-md-6">
            <input type="text" name="radioLabelYes" placeholder="{{ xe_trans('xe::yes') }}" class="form-control" value="{{$config ? $config->get('radioLabelYes') : ''}}" />
        </div>
        <div class="xe-col-md-6">
            <input type="text" name="radioLabelNo" placeholder="{{ xe_trans('xe::no') }}" class="form-control" value="{{$config ? $config->get('radioLabelNo') : ''}}" />
        </div>
    </div>
</div>

<div class="xe-form-group">
    <label>{{ xe_trans('xe::description') }}</label>
    <input type="text" name="skinDescription" placeholder="skin description" class="form-control" value="{{$config != null ? $config->get('skinDescription') : ''}}" />
</div>