<div class="__xe_imagebox_{{ $seq }}">
    <div class="__xe_file_preview_{{ $seq }}">
        <img class="__thumbnail" alt="{{ xe_trans('xe::profileImage') }}" src="{{ $args['image'] }}"
             style="width:{{ $args['width'] }}px; height:{{ $args['height'] }}px;">
    </div>
    <div class="__xe_inputBtn fileinput-button btn-file __xe_imgUploadBox" style="display: none;">
        <input class="__xe_file_{{ $seq }}" type="file" name="{{ array_get($args, 'name', 'imagebox') }}"/>
    </div>
</div>

<script>
    jQuery(function ($) {
        var fileInput = $('.__xe_imagebox_{{ $seq }}');
        var context = $('.__xe_file_preview_{{ $seq }}')
        fileInput.fileupload({
            fileInput: fileInput,
            previewMaxWidth: {{ $args['width'] }},
            previewMaxHeight: {{ $args['height'] }},
            previewCrop: true,
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            replaceFileInput: false,
            disableImageResize: true,
            imageCrop: false,
            dropZone: fileInput
        }).on('fileuploadadd', function (e, data) {
            context.empty();

        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index, file = data.files[index];
            if (file.preview) {
                context.empty().prepend(file.preview);
            }
            if (file.error) {
                context.empty().append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        })
    })
</script>
