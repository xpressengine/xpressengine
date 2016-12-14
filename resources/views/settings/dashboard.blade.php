@section('page_title')
    <h2>{{ xe_trans('xe::dashBoard') }}</h2>
@stop

@section('page_description')
@stop

{{ uio('widgetbox', ['id' => $widgetbox->id, 'link'=> xe_trans('xe::editDashboard')]) }}
