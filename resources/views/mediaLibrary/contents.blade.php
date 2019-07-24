{{ XeFrontend::js('/assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js') }}
{{ XeFrontend::js('/assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js') }}
{{ XeFrontend::js('/assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js') }}

@section('page_title')
    <h2>{{xe_trans('xe::mediaLibrary')}}</h2>
@endsection

<div id="media-library"></div>

<script>
    $(function () {
        XE.app('MediaLibrary', function (appMediaLibrary) {
            appMediaLibrary.config = {
                disallowExtensions: '{{ app('config')['xe.media.mediaLibrary.disallow_extensions'] }}',
                maxSize: '{{ app('config')['xe.media.mediaLibrary.max_size'] }}'
            }
        }).then(function (appMediaLibrary) {
            appMediaLibrary.show();
        })
    })
</script>
