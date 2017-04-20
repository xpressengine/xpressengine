<div class="form-group">
    @if($label = array_get($args, 'label'))<label>{!! $label !!}</label>@endif
    <div data-selector="{{ $selector }}" data-format="alias" class="input-group colorpicker-component">
        <span class="input-group-addon"><i></i></span>
        <input type="text" id="{{ array_get($args, 'id') }}" value="{{ array_get($args, 'value', '#000000') }}" class="form-control" name="{{ array_get($args, 'name', 'colorpicker') }}" />
    </div>
    <p class="help-block">{{ array_get($args, 'description') }}</p>
</div>

<style>
    .colorpicker-2x .colorpicker-saturation {
        width: 200px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-hue,
    .colorpicker-2x .colorpicker-alpha {
        width: 30px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-color,
    .colorpicker-2x .colorpicker-color div {
        height: 30px;
    }
</style>

<script>
    jQuery(function () {
        $('[data-selector={{ $selector }}]').colorpicker({
            customClass: 'colorpicker-2x',
            align: 'left',
            colorSelectors: {
                'black': '#000000',
                'white': '#ffffff',
                'red': '#FF0000',
                'default': '#777777',
                'primary': '#337ab7',
                'success': '#5cb85c',
                'info': '#5bc0de',
                'warning': '#f0ad4e',
                'danger': '#d9534f'
            },
            sliders: {
                saturation: {
                    maxLeft: 200,
                    maxTop: 200
                },
                hue: {
                    maxTop: 200
                },
                alpha: {
                    maxTop: 200
                }
            }
        });
    });
</script>
