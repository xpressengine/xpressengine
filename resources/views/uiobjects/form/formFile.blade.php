<div class="form-group">
    @if($label = array_get($args, 'label'))<label>{!! $label !!} @if($description = array_get($args, 'description'))<small>{!! $description !!}</small>@endif</label>@endif
    <div class="__xe_filebox_{{ $seq }} clearfix panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2 col-sm-3">
                <span class="btn btn-default btn-sm fileinput-button">
                @if(isset($args['file']))
                        <span>{{xe_trans('xe::modify')}}</span>
                    @else
                        <span>{{xe_trans('xe::register')}}</span>
                    @endif
                    <input class="__xe_file_{{ $seq }}" type="file" name="{{ array_get($args, 'name', 'filebox') }}"/>
                </span>
                </div>
                <div class="col-md-10 col-sm-9 text-right">
                    <div class="__xe_file_info_{{ $seq }}">
                    </div>
                    <div class="__xe_file_preview_{{ $seq }}">
                        @if(isset($args['value']))
                            {{ array_get($args, 'value.filename') }}
                        @elseif(isset($args['file']))
                            {{ $args['file'] }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="help-block">{{ array_get($args, 'description') }}</p>
</div>

<script>
    jQuery(function ($) {
        var fileInput = $('.__xe_filebox_{{ $seq }}');
        var options = {!! json_encode($args['fileuploadOptions']) !!};
        options['acceptFileTypes'] = new RegExp(options.acceptFileTypes, 'i');
        options['dropZone'] = fileInput;
        fileInput.fileupload(options)
            .on('fileuploadadd', function (e, data) {
                data.context = $('.__xe_file_preview_{{ $seq }}').empty();
            })
            .on('fileuploadprocessalways', function (e, data) {
                var index = data.index, file = data.files[index];
                if (file.preview) {
                    data.context.empty().prepend(file.preview);
                }
                if (file.error) {
                    data.context.empty().append($('<span class="text-danger"/>').text(file.error));
                }

                $('.__xe_file_info_{{ $seq }}').empty().append(file.name)
            }
        );
    });
</script>
