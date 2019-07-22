{{ XeFrontend::js('/assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js') }}
{{ XeFrontend::js('/assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js') }}
{{ XeFrontend::js('/assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js') }}

<div id="media-library">
</div>

<script>
    $(function () {
        XE.app('MediaLibrary').then(function (appMediaLibrary) {
            appMediaLibrary.show();
        })
    })
</script>
