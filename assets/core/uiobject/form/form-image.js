jQuery(function () {
    var fileInput = $('.__xe_imagebox_{{ $seq }}');
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
        imageCrop: false
}).on('fileuploadadd', function (e, data) {
        $('.fileinput-button span', this).text('변경');
        data.context = $('.__xe_file_preview_{{ $seq }}').empty();

    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index, file = data.files[index];
        if (file.preview) {
            var $preview = $(file.preview).css({
                margin: '0 auto',
                display: 'block'
            });

            data.context.empty().prepend($preview);
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
