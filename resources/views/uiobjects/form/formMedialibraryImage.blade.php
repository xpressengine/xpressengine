<div class="xe-form-group">
    <section class="__xeuio-medialibrary-image" id="__xeuio-{{ $seq }}" data-uio-seq="{{ $seq }}">
        <button type="button" class="ml-image__add"><i class="xi-plus"></i></button>
        <ul class="ml-image__preview"></ul>
    </section>
</div>

<script>
    $(function () {
        var $element = $('#__xeuio-{{ $seq }}')
        var options = {
            valueTarget: 'file_id',
            name: '{{ array_get($args, 'name', 'image[]') }}', // field name
            @if(array_get($args, 'files')) files: {!! json_encode(array_get($args, 'files', [])) !!}, @endif
        }
        $element.uioMedialibraryImage(options)
    })
</script>
