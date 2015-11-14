<div class="form-group">
    @if($label = array_get($args, 'label'))<label>{!! $label !!}</label>@endif
    <div class="__xe_imagebox_{{ $seq }} clearfix panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2 col-sm-3">
                <span class="btn btn-default btn-sm __xe_inputBtn fileinput-button">
                @if(isset($args['image']))
                        <span>변경</span>
                    @else
                        <span>등록</span>
                    @endif
                    <input class="__xe_file_{{ $seq }}" type="file" name="{{ array_get($args, 'name', 'imagebox') }}"/>
                </span>
                </div>
                <div class="col-md-10 col-sm-9 text-right" style="height:{{ $args['height'] }}px;">
                    <div class="__xe_file_preview_{{ $seq }}">
                        @if(isset($args['image']))
                            <img class="__thumbnail" src="{{ $args['image'] }}"
                                 style="width:{{ $args['width'] }}px; height:{{ $args['height'] }}px;">
                        @endif
                    </div>
                </div>
            </div>
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
            $('.fileinput-button span').text('변경');
            data.context = $('.__xe_file_preview_{{ $seq }}').empty();

        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index, file = data.files[index];
            if (file.preview) {
                data.context.empty().prepend(file.preview);
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
