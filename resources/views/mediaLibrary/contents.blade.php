@section('page_title')
    <h2>{{xe_trans('xe::mediaLibrary')}}</h2>
@endsection

@expose_route('auth.admin')
@expose_route('media_library.index')
@expose_route('media_library.drop')
@expose_route('media_library.get_folder')
@expose_route('media_library.store_folder')
@expose_route('media_library.update_folder')
@expose_route('media_library.move_folder')
@expose_route('media_library.get_file')
@expose_route('media_library.update_file')
@expose_route('media_library.modify_file')
@expose_route('media_library.move_file')
@expose_route('media_library.upload')
@expose_route('media_library.download_file')

<div id="media-library"></div>

<script>
    $(function () {
        XE.app('MediaLibrary', function (appMediaLibrary) {
            appMediaLibrary.config = {
                disallowExtensions: '{{ app('config')['xe.media.mediaLibrary.disallow_extensions'] }}',
                maxSize: '{{ app('config')['xe.media.mediaLibrary.max_size'] }}'
            }
        }).then(function (appMediaLibrary) {
            appMediaLibrary.show({
                user: {
                    id: XE.config.getters['user/id'],
                    rating: XE.config.getters['user/rating']
                },
            });
        })
    })
</script>
