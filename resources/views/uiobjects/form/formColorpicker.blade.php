<div class="form-group">
    @if($label = array_get($args, 'label'))<label>{!! $label !!}</label>@endif
    <div data-selector="{{ $selector }}" data-format="alias" class="input-group colorpicker-component">
        <span class="input-group-addon"><i></i></span>
        <input type="text" id="{{ array_get($args, 'id') }}" value='{{ array_get($args, 'value') }}' class="form-control" name="{{ array_get($args, 'name', 'colorpicker') }}" />
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
                '#000000': '#000000',     //black
                '#ffffff': '#ffffff',     //white
                '#FF0000': '#FF0000',       //red
                '#777777': '#777777',   //default
                '#337ab7': '#337ab7',   //primary
                '#5cb85c': '#5cb85c',   //success
                '#5bc0de': '#5bc0de',      //info
                '#f0ad4e': '#f0ad4e',   //warning
                '#d9534f': '#d9534f'     //danger
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
