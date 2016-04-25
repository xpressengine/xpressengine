<div class="form-group">
    @if($label = array_get($args, 'label'))<label>{!! $label !!}</label>@endif
    <div class="__xe_imagebox_{{ $seq }} clearfix list-group-item">
        <a class="pull-left btn btn-default btn-sm __xe_inputBtn fileinput-button">
        @if(isset($args['image']))
            <span>변경하기</span>
            @else
            <span>등록하기</span>
            @endif
            <input class="__xe_file_{{ $seq }}" type="file" name="{{ array_get($args, 'name', 'imagebox') }}"/>
        </a>
        <div class="__xe_file_preview_{{ $seq }}">
            @if(isset($args['image']))
                <img class="__thumbnail center-block" src="{{ asset($args['image']) }}"
                     style="max-width: 100%; width:{{ $args['width'] }}px; height:auto;">
            @endif
        </div>
    </div>
</div>

<script>
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
</script>
