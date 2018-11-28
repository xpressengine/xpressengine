<div class="__xe_imagebox_{{ $seq }}">
    <div class="__xe_inputBtn fileinput-button btn_file __xe_imgUploadBox" style="display: none;">
        <strong>{{ xe_trans('xe::update') }}</strong>
        <input class="__xe_file_{{ $seq }}" type="file" name="{{ array_get($args, 'name', 'imagebox') }}"/>
    </div>
</div>

<script>
    jQuery(function ($) {
        var fileInput = $('.__xe_imagebox_{{ $seq }}');
        fileInput.fileupload({
            fileInput: fileInput,
            previewMaxWidth: {{ $args['width'] }},
            previewMaxHeight: {{ $args['height'] }},
            previewCrop: false,
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            replaceFileInput: false,
            disableImageResize: true,
            imageCrop: false,
            dropZone: fileInput
        }).on('fileuploadadd', function (e, data) {
            data.context = $('.__xe_file_preview_{{ $seq }}').empty();

        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index, file = data.files[index];
            if (file.preview) {

                var dataURL = file.preview.toDataURL();
                $(".__xe_profilePage").css("background-image", 'url(' + dataURL +')');

                //data.context.empty().prepend(file.preview);
            }
            if (file.error) {
                data.context.empty().append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        })
    })
</script>
