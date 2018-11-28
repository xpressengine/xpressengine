<div class="form-group">
    @if($label = array_get($args, 'label'))<label>{!! $label !!}</label>@endif
    <div class="__xe_imagebox_{{ $seq }} clearfix list-group-item">

        <div class="btn-group" role="group" aria-label="...">
            <span type="button" class="btn btn-default __xe_inputBtn fileinput-button">
                @if($path = array_get($args, 'value.path', array_get($args, 'image')))
                    <span>변경</span>
                @else
                    <span>{{xe_trans('xe::register')}}</span>
                @endif
                <input class="__xe_file_{{ $seq }}" type="file" name="{{ $name = array_get($args, 'name', 'image') }}"/>
            </span>
            <label @if($path === null) disabled @endif class="btn btn-default">
                <input type="checkbox" class="__xe_delete_file_{{ $seq }}" value="__delete_file__">
                삭제</label>
        </div>

        <div class="__xe_file_preview_{{ $seq }}" style="padding: 10px 0">
            @if($path)
                <img class="__thumbnail center-block" src="{{ asset($path) }}"
                     style="max-width: 100%; height:auto;">
            @endif
        </div>
    </div>
    <p class="help-block">{{ array_get($args, 'description') }}</p>
</div>

<script>
    "use strict"
    jQuery(function ($) {
        var fileInput = $('.__xe_imagebox_{{ $seq }}');
        var context = $('.__xe_file_preview_{{ $seq }}')
        fileInput.fileupload({
            fileInput: $('.__xe_file_{{ $seq }}'),
            previewMaxWidth: {{ $args['width'] }},
            previewMaxHeight: {{ $args['height'] }},
            previewCrop: false,
            previewCanvas: false,
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: {{array_get($args, 'maxSize', 5000000)}}, // 5 MB @FIXME
            replaceFileInput: false,
            disableImageResize: true,
            imageCrop: false,
            dropZone: fileInput
        }).on('fileuploadadd', function (e, data) {
            $('.fileinput-button span', this).text('변경');
            context = $('.__xe_file_preview_{{ $seq }}');
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index, file = data.files[index];
            if (file.error) {
                context.empty().append($('<span class="text-danger"/>').text(file.error));
                return;
            }

            if (file.preview) {
                var $preview = $(file.preview).css({
                    margin: '0 auto',
                    display: 'block',
                    'max-width': '100%',
                    'height': 'auto',
                });
                context.empty().prepend($preview);
                $('input.__xe_delete_file_{{ $seq }}').parent('label').show();
            }
        });

        $('input.__xe_delete_file_{{ $seq }}').change(function () {
            var btn = $('.__xe_imagebox_{{ $seq }} .__xe_inputBtn');
            var file = $('.__xe_file_{{ $seq }}');
            if (this.checked) {
                btn.attr('disabled', 'disabled');
                file.attr('disabled', 'disabled')
                $(this).attr('name', '{{ $name }}')
            } else {
                btn.removeAttr('disabled');
                file.removeAttr('disabled');
                $(this).removeAttr('name');
            }
        })

    })
</script>
