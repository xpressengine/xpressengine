<div class="panel">
    <div class="panel-heading">
        <h3>{{ xe_trans($title) }}</h3>
    </div>
    <div class="panel-body">
        @if(count($files) == 0)
            <h4>{{xe_trans('xe::msgNoUploadFiles')}}</h4>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>{{ xe_trans('xe::filename') }}</th>
                    <th>{{ xe_trans('xe::count') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr>
                        <td>{{ $file['clientname'] }}</td>
                        <td>{{ $file['download_count'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
