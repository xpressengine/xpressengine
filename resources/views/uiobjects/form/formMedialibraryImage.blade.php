<div class="xe-form-group">
    <section class="xeuio-medialibrary xeuio-medialibrary--image __xeuio-medialibrary-image" id="__xeuio-{{ $seq }}"
             data-uio-seq="{{ $seq }}">
        @if(array_get($args, 'browser', false))
            <div class="xeuio-ml__add-item">
                <label class="xeuio-ml__button xeuio-ml__add">
                    <input type="file" class="xe-hidden" name="file" multiple/>
                    <i class="xi-plus"></i>
                    <span class="xeuio-ml__label">추가</span>
                </label>
            </div>
        @endif
        @if(!array_get($args, 'browser', false))
            <div class="xeuio-ml__add-item">
                <button type="button" class="xeuio-ml__button xeuio-ml__add">
                    <i class="xi-plus"></i>
                    <span class="xeuio-ml__label">추가</span>
                </button>
            </div>
        @endif
        <ul class="xeuio-ml__preview"></ul>
    </section>
</div>

<script defer>
$(function () {
    const $element = $('#__xeuio-{{ $seq }}')
    const options = {
        valueTarget: 'file_id',
        name: '{{ array_get($args, 'name', 'image[]') }}', // field name
        limit: '{{ array_get($args, 'limit', 0) }}',
        @if(array_get($args, 'files')) files: {!! json_encode(array_get($args, 'files', [])) !!}, @endif
        @if(array_get($args, 'field')) field: '{{ array_get($args, 'field') }}', @endif
        @if(array_get($args, 'renderMode')) renderMode: '{{ array_get($args, 'renderMode') }}', @endif
        @if(array_get($args, 'browser', false)) browser: {{ array_get($args, 'browser', false) ? 'true' : 'false' }}, @endif
    }
    $element.uioMedialibraryImage(options)
})
</script>
