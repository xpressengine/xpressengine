<div class="xe-form-group">
    <section class="xeuio-medialibrary xeuio-medialibrary--image __xeuio-medialibrary-image" id="__xeuio-{{ $seq }}" data-uio-seq="{{ $seq }}">
        <ul class="xeuio-ml__preview">
            @if(! array_get($args, 'browser'))
                <li class="xeuio-ml__add-item"><button type="button" class="xeuio-ml__button xeuio-ml__add"><i class="xi-plus"></i> 추가</button></li>
            @endif
        </ul>
        @if(array_get($args, 'browser'))
            @if ($args['limit'] <= 1)
                <div class="xeuio-ml__add-item"><label class="xeuio-ml__button xeuio-ml__add" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <input type="file" class="xe-hidden" name="file" /><i class="xi-plus"></i> 추가</label>
                </div>
            @else
                <div class="xeuio-ml__add-item"><label class="xeuio-ml__button xeuio-ml__add" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <input type="file" class="xe-hidden" name="file" multiple /><i class="xi-plus"></i> 추가</label>
                </div>
            @endif
        @endif
    </section>
</div>


<script>
    $(function () {
        var $element = $('#__xeuio-{{ $seq }}')
        var options = {
            valueTarget: 'file_id',
            name: '{{ array_get($args, 'name', 'image[]') }}', // field name
            limit: '{{ array_get($args, 'limit', 0) }}',
            @if(array_get($args, 'files')) files: {!! json_encode(array_get($args, 'files', [])) !!}, @endif
            @if(array_get($args, 'field')) field: '{{ array_get($args, 'field') }}', @endif
            @if(array_get($args, 'renderMode')) renderMode: '{{ array_get($args, 'renderMode') }}', @endif
            @if(array_get($args, 'browser')) browser: '{{ array_get($args, 'browser') }}', @endif
        }
        $element.uioMedialibraryImage(options)
    })
</script>

<style>
.xeuio-medialibrary {
    display: flex;
    flex-direction: row;
    width: auto;
}
.xeuio-medialibrary ul {
    display: flex;
    margin: 0;
    padding: 0;
    list-style: none;
}
.xeuio-medialibrary .xeuio-ml__preview {
    display: flex;
    flex-wrap: nowrap;
    flex-direction: row;
}
.xeuio-medialibrary .xeuio-ml__preview-item {
    display: flex;
    width: 105px;
    height: 105px;
}
</style>
