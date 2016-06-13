<div class="panel">
    <div class="panel-heading">
        <h3>Storage {{ xe_trans('xe::usage') }}</h3>
    </div>
    <div class="panel-body">
        @if(sizeof($list) == 0)
            <h4>{{xe_trans('xe::msgNoUploadFiles')}}</h4>
        @endif
        @foreach($list as $disk => $value)
            <h4>
                {{ $disk }}
                <small>
                    {{ bytes($value['total']['bytes']) }}
                    {{ number_format($value['total']['count']) }} files
                </small>
            </h4>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ xe_trans('xe::mime') }}</th>
                    <th>{{ xe_trans('xe::count') }}</th>
                    <th>{{ xe_trans('xe::size') }}</th>
                    <th>{{ xe_trans('xe::percent') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($value['bytes'] as $mime => $size)
                    <tr>
                        <td>{{ $mime }}</td>
                        <td>{{ $value['count'][$mime] }}</td>
                        <td>{{ bytes($size) }}</td>
                        <td>
                            <div class="progress" style="background-color: #c4c4c4;">
                                <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                     style="width:{{ sprintf('%.2f', $size / $value['total']['bytes'] * 100) . '%' }}">
                                    {{ sprintf('%.2f', $size / $value['total']['bytes'] * 100) . '%' }}
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</div>
